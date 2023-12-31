<?php

namespace App\Http\Controllers\SIMRS;

use App\Http\Controllers\Admin\WhatsappController;
use App\Http\Controllers\API\AntrianBPJSController;
use App\Http\Controllers\BPJS\Antrian\AntrianController as AntrianAntrianController;
use App\Http\Controllers\BPJS\Vclaim\VclaimController;
use App\Http\Controllers\Controller;
use App\Models\Antrian;
use App\Models\AntrianDB;
use App\Models\BPJS\Antrian\JadwalDokterAntrian;
use App\Models\JadwalDokter;
use App\Models\KunjunganDB;
use App\Models\ParamedisDB;
use App\Models\PenjaminSimrs;
use App\Models\PoliklinikDB;
use App\Models\SIMRS\JadwalDokter as SIMRSJadwalDokter;
use App\Models\SIMRS\Pasien;
use App\Models\SuratKontrol;
use App\Models\UnitDB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Laravolt\Indonesia\Models\Provinsi;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
use RealRashid\SweetAlert\Facades\Alert;

class AntrianController extends Controller
{
    public function console()
    {
        $poliklinik = PoliklinikDB::with(['antrians', 'jadwals'])->where('status', 1)->get();
        $jadwal = JadwalDokter::where('hari',  now()->dayOfWeek)->get();
        $antrian_terakhir1 = Antrian::where('tanggalperiksa', now()->format('Y-m-d'))->where('method', 'Offline')->where('lantaipendaftaran', 1)->count();
        $antrian_terakhir2 = Antrian::where('tanggalperiksa', now()->format('Y-m-d'))->where('method', 'Offline')->where('lantaipendaftaran', 2)->where('jenispasien', 'JKN')->count();
        $antrian_terakhir3 = Antrian::where('tanggalperiksa', now()->format('Y-m-d'))->where('method', '!=', 'Offline')->where('method', '!=', 'Bridging')->count();
        $antrian_terakhir4 = Antrian::where('tanggalperiksa', now()->format('Y-m-d'))->where('method', '!=', 'Bridging')->count();
        return view('simrs.antrian_console', compact(
            [
                'poliklinik',
                'jadwal',
                'antrian_terakhir1',
                'antrian_terakhir2',
                'antrian_terakhir3',
                'antrian_terakhir4',
            ]
        ));
    }
    public function daftar_pasien_bpjs_offline(Request $request)
    {
        $request['tanggalperiksa'] = now()->format('Y-m-d');
        $request['kodepoli'] = $request->kodesubspesialis;
        $validator = Validator::make(request()->all(), [
            "kodesubspesialis" => "required",
            "kodedokter" => "required",
        ]);
        if ($validator->fails()) {
            Alert::error('Error', $validator->errors()->first());
            return redirect()->route('antrian.console');
        }
        // get jadwal
        $jadwal = JadwalDokterAntrian::where('kodesubspesialis', $request->kodesubspesialis)
            ->where('kodedokter', $request->kodedokter)
            ->where('hari', now()->dayOfWeek)->first();
        if ($jadwal == null) {
            Alert::error('Error',  "Jadwal tidak ditemukan");
            return redirect()->route('antrian.console');
        }
        $request['jampraktek'] = $jadwal->jadwal;
        $request['jenispasien'] = 'JKN';
        $request['method'] = 'Offline';
        // ambil antrian offline
        $antrian_api = new AntrianAntrianController();
        $response = $antrian_api->ambil_antrian_offline($request);
        if ($response->status() == 200) {
            // cek printer
            try {
                $connector = new WindowsPrintConnector(env('PRINTER_CHECKIN'));
                $printer = new Printer($connector);
                $printer->close();
            } catch (\Throwable $th) {
                return $this->sendError('Printer Mesin Antrian Tidak Menyala', null, 201);
            }
            $antrian = $response->getData()->response;
            $this->print_karcis_offline($request, $antrian);
            Alert::success('Success', 'Anda berhasil mendaftar dengan antrian ' . $antrian->angkaantrean . " / " . $antrian->nomorantrean);
            return redirect()->route('antrian.console');
        } else {
            Alert::error('Error ' . $response->getData()->metadata->code,  $response->getData()->metadata->message);
            return redirect()->route('antrian.console');
        }
    }
    public function daftar_pasien_umum_offline(Request $request)
    {
        $request['tanggalperiksa'] = now()->format('Y-m-d');
        $request['kodepoli'] = $request->kodesubspesialis;
        $validator = Validator::make(request()->all(), [
            "kodesubspesialis" => "required",
            "kodedokter" => "required",
        ]);
        if ($validator->fails()) {
            Alert::error('Error', $validator->errors()->first());
            return redirect()->route('antrian.console');
        }
        // get jadwal
        $jadwal = JadwalDokterAntrian::where('kodesubspesialis', $request->kodesubspesialis)
            ->where('kodedokter', $request->kodedokter)
            ->where('hari', now()->dayOfWeek)->first();
        if ($jadwal == null) {
            Alert::error('Error',  "Jadwal tidak ditemukan");
            return redirect()->route('antrian.console');
        }
        $request['jampraktek'] = $jadwal->jadwal;
        $request['jenispasien'] = 'NON-JKN';
        $request['method'] = 'Offline';
        // ambil antrian offline
        $antrian_api = new AntrianAntrianController();
        $response = $antrian_api->ambil_antrian_offline($request);
        if ($response->status() == 200) {
            // cek printer
            try {
                $connector = new WindowsPrintConnector(env('PRINTER_CHECKIN'));
                $printer = new Printer($connector);
                $printer->close();
            } catch (\Throwable $th) {
                return $this->sendError('Printer Mesin Antrian Tidak Menyala', null, 201);
            }
            $antrian = $response->getData()->response;
            $this->print_karcis_offline($request, $antrian);
            Alert::success('Success', 'Anda berhasil mendaftar dengan antrian ' . $antrian->angkaantrean . " / " . $antrian->nomorantrean);
            return redirect()->route('antrian.console');
        } else {
            Alert::error('Error ' . $response->getData()->metadata->code,  $response->getData()->metadata->message);
            return redirect()->route('antrian.console');
        }
    }
    function print_karcis_offline(Request $request, $antrian)
    {
        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');
        $now = Carbon::now();
        $connector = new WindowsPrintConnector(env('PRINTER_CHECKIN'));
        $printer = new Printer($connector);
        $printer->setEmphasis(true);
        $printer->text("ANTRIAN RAWAT JALAN\n");
        $printer->text("RSUD WALED KAB. CIREBON\n");
        $printer->setEmphasis(false);
        $printer->text("================================================\n");
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text("Angka Antrian Pendaftaran :\n");
        $printer->setTextSize(2, 2);
        $printer->text($antrian->angkaantrean . "\n");
        $printer->setTextSize(1, 1);
        $printer->text("Kode Booking : " . $antrian->kodebooking . "\n");
        $printer->text("Lokasi Pendaftaran Lantai " . $request->lantaipendaftaran . " \n");
        $printer->text("================================================\n");
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->text("================================================\n");
        $printer->text("Jenis Kunj. : " . $request->method . "\n");
        $printer->text("Jenis Pasien : " . $request->jenispasien . "\n");
        $printer->text("No. Antrian Poli : " . $antrian->nomorantrean . "\n");
        $printer->text("Poliklinik : " . $antrian->namapoli . "\n");
        $printer->text("Dokter : " . $antrian->namadokter . "\n");
        $printer->text("Jam Praktek : " . $request->jampraktek . "\n");
        $printer->text("Tanggal : " . Carbon::parse($request->tanggalperiksa)->format('d M Y') . "\n");
        $printer->text("================================================\n");
        $printer->text("Keterangan : \n" . $antrian->keterangan . "\n");
        $printer->text("================================================\n");
        $printer->text("Cetakan 1 : " . $now . "\n");
        $printer->cut();
        $printer->close();
    }
    public function daftar_online(Request $request)
    {
        return view('simrs.pendaftaran.daftar_online', compact(['request']));
    }
    public function checkin_update(Request $request)
    {
        // checking request
        $validator = Validator::make(request()->all(), [
            "kodebooking" => "required",
            "waktu" => "required|numeric",
        ]);
        if ($validator->fails()) {
            $response = [
                'metadata' => [
                    'code' => 400,
                    'message' => $validator->errors()->first(),
                ],
            ];
            return $response;
        }
        // cari antrian
        $antrian = Antrian::firstWhere('kodebooking', $request->kodebooking);
        if (isset($antrian)) {
            $api = new AntrianAntrianController();
            $response = $api->checkin_antrian($request)->getData();
            return $response;
        }
        // jika antrian tidak ditemukan
        else {
            return $response = [
                'metadata' => [
                    'code' => 400,
                    'message' => "Antrian tidak ditemukan",
                ],
            ];
        }
    }
    // pendaftaran
    public function antrian_pendaftaran(Request $request)
    {
        $antrians = null;
        if ($request->tanggal && $request->loket && $request->jenispasien  && $request->lantai) {
            $antrians = Antrian::whereDate('tanggalperiksa', $request->tanggal)
                ->where('method', 'Offline')
                ->where('jenispasien', $request->jenispasien)
                ->where('lantaipendaftaran', $request->lantai)
                ->get();
            if ($request->kodepoli != null) {
                $antrians = $antrians->where('kodepoli', $request->kodepoli);
            }
        }
        $polis = PoliklinikDB::where('status', 1)->get();
        return view('simrs.pendaftaran.pendaftaran_antrian', compact([
            'antrians',
            'request',
            'polis',
        ]));
    }
    public function panggil_pendaftaran($kodebooking, $loket, $lantai, Request $request)
    {
        $antrian = Antrian::where('kodebooking', $kodebooking)->first();
        if ($antrian) {
            $request['kodebooking'] = $antrian->kodebooking;
            $request['taskid'] = 2;
            $now = Carbon::now();
            $request['waktu'] = Carbon::now()->timestamp * 1000;
            $vclaim = new AntrianBPJSController();
            $antrian->update([
                'taskid' => 2,
                'loket' => $request->loket,
                'status_api' => 1,
                'loket' => $request->loket,
                'keterangan' => "Panggilan ke loket pendaftaran",
                'taskid2' => $now,
                'user' => Auth::user()->name,
            ]);
            //panggil urusan mesin antrian
            try {
                // notif wa
                // $wa = new WhatsappController();
                // $request['message'] = "Panggilan antrian atas nama pasien " . $antrian->nama . " dengan nomor antrian " . $antrian->angkaantrean . "/" . $antrian->nomorantrean . " untuk melakukan pendaftaran di Loket " . $loket . " Lantai " . $lantai;
                // $request['number'] = $antrian->nohp;
                // $wa->send_message($request);
                $tanggal = now()->format('Y-m-d');
                $urutan = $antrian->angkaantrean;
                if ($antrian->jenispasien == 'JKN') {
                    $tipeloket = 'BPJS';
                } else {
                    $tipeloket = 'UMUM';
                }
                $mesin_antrian = DB::connection('mysql3')->table('tb_counter')
                    ->where('tgl', $tanggal)
                    ->where('kategori', $tipeloket)
                    ->where('loket', $loket)
                    ->where('lantai', $lantai)
                    ->get();
                if ($mesin_antrian->count() < 1) {
                    $mesin_antrian = DB::connection('mysql3')->table('tb_counter')->insert([
                        'tgl' => $tanggal,
                        'kategori' => $tipeloket,
                        'loket' => $loket,
                        'counterloket' => $urutan,
                        'lantai' => $lantai,
                        'mastercount' => $urutan,
                        'sound' => 'PLAY',
                    ]);
                } else {
                    DB::connection('mysql3')->table('tb_counter')
                        ->where('tgl', $tanggal)
                        ->where('kategori', $tipeloket)
                        ->where('loket', $loket)
                        ->where('lantai', $lantai)
                        ->limit(1)
                        ->update([
                            // 'counterloket' => $antrian->first()->mastercount + 1,
                            'counterloket' => $urutan,
                            // 'mastercount' => $antrian->first()->mastercount + 1,
                            'mastercount' => $urutan,
                            'sound' => 'PLAY',
                        ]);
                }
            } catch (\Throwable $th) {
                Alert::error('Error', $th->getMessage());
                return redirect()->back();
            }
            Alert::success('Success', 'Panggilan Berhasil');
            return redirect()->back();
        } else {
            Alert::error('Error', 'Kode Booking tidak ditemukan');
            return redirect()->back();
        }
    }
    public function selesai_pendaftaran($kodebooking, Request $request)
    {
        $antrian = Antrian::where('kodebooking', $kodebooking)->first();
        $request['kodebooking'] = $antrian->kodebooking;
        $request['taskid'] = 3;
        $request['waktu'] = Carbon::now()->timestamp * 1000;

        if ($antrian->jenispasien == 'JKN') {
            $request['keterangan'] = "Silahkan menunggu dipoliklinik";
            $request['status_api'] = 1;
        } else {
            $request['keterangan'] = "Silahkan lakukan pembayaran di Loket Pembayaran, setelah itu dapat menunggu dipoliklinik";
            $request['status_api'] = 0;
        }
        // $vclaim = new AntrianAntrianController();
        // $response = $vclaim->update_antrean($request);
        // if ($response->status() == 200) {
        // } else {
        //     Alert::error('Error ' . $response->status(), $response->getData()->metadata->message);
        // }
        $antrian->update([
            'taskid' => $request->taskid,
            'status_api' => $request->status_api,
            'keterangan' => $request->keterangan,
            'user' => Auth::user()->name,
        ]);
        try {
            // notif wa
            $wa = new WhatsappController();
            $request['message'] = "Anda berhasil di daftarkan atas nama pasien " . $antrian->nama . " dengan nomor antrean " . $antrian->nomorantrean . " telah selesai. " . $request->keterangan;
            $request['number'] = $antrian->nohp;
            $wa->send_message($request);
        } catch (\Throwable $th) {
            //throw $th;
        }
        Alert::success('Success', 'Pasien diteruskan ke poliklinik');
        return redirect()->back();
    }
    // poliklinik
    public function antrian_poliklinik(Request $request)
    {
        $antrians = null;
        if ($request->tanggal) {
            $antrians = Antrian::whereDate('tanggalperiksa', $request->tanggal);
            if ($request->kodepoli != null) {
                $antrians = $antrians->where('method', '!=', 'Offline')->where('kodepoli', $request->kodepoli)->get();
            }
            if ($request->kodedokter != null) {
                $antrians = $antrians->where('method', '!=', 'Offline')->where('kodedokter', $request->kodedokter)->get();
            }
            if ($request->kodepoli == null && $request->kodedokter == null) {
                $antrians = $antrians->where('method', '!=', 'Offline')->get();
            }
        }
        $polis = PoliklinikDB::where('status', 1)->get();
        $dokters = ParamedisDB::where('kode_dokter_jkn', "!=", null)
            ->where('unit', "!=", null)
            ->get();
        if (isset($request->kodepoli)) {
            $poli = UnitDB::firstWhere('KDPOLI', $request->kodepoli);
            $dokters = ParamedisDB::where('unit', $poli->kode_unit)
                ->where('kode_dokter_jkn', "!=", null)
                ->get();
        }
        return view('simrs.poliklinik.poliklinik_antrian', [
            'antrians' => $antrians,
            'request' => $request,
            'polis' => $polis,
            'dokters' => $dokters,
        ]);
    }
    public function panggil_poliklinik(Antrian $antrian, Request $request)
    {
        $request['kodebooking'] = $antrian->kodebooking;
        $request['taskid'] = 4;
        $request['keterangan'] = "Panggilan ke poliklinik yang anda pilih";
        $request['waktu'] = Carbon::now()->timestamp * 1000;
        $vclaim = new AntrianAntrianController();
        $response = $vclaim->update_antrean($request);
        if ($response->status() == 200) {
            // try {
            //     // notif wa
            //     $wa = new WhatsappController();
            //     $request['message'] = "Panggilan antrian atas nama pasien " . $antrian->nama . " dengan nomor antrean " . $antrian->nomorantrean . " untuk segera dilayani di POLIKLINIK " . $antrian->namapoli;
            //     $request['number'] = $antrian->nohp;
            //     $wa->send_message($request);
            // } catch (\Throwable $th) {
            //     //throw $th;
            // }
            $antrian->update([
                'taskid' => $request->taskid,
                'status_api' => 1,
                'keterangan' => $request->keterangan,
                'user' => Auth::user()->name,
            ]);
            Alert::success('Success', 'Panggil Pasien Berhasil');
        } else {
            Alert::error('Error ' . $response->status(), $response->getData()->metadata->message);
        }
        return redirect()->back();
    }
    public function panggil_ulang_poliklinik(Antrian $antrian, Request $request)
    {
        $request['kodebooking'] = $antrian->kodebooking;
        $request['taskid'] = 4;
        $request['keterangan'] = "Panggilan ke poliklinik yang anda pilih";
        $request['waktu'] = Carbon::now()->timestamp * 1000;
        // try {
        //     // notif wa
        //     $wa = new WhatsappController();
        //     $request['message'] = "Panggilan ulang antrian atas nama pasien " . $antrian->nama . " dengan nomor antrean " . $antrian->nomorantrean . " untuk segera dilayani di POLIKLINIK " . $antrian->namapoli;
        //     $request['number'] = $antrian->nohp;
        //     $wa->send_message($request);
        // } catch (\Throwable $th) {
        //     //throw $th;
        // }
        Alert::success('Success', 'Panggil Pasien Berhasil');
        return redirect()->back();
    }
    public function batal_antrian_poliklinik(Antrian $antrian, Request $request)
    {
        $request['kodebooking'] = $antrian->kodebooking;
        $request['taskid'] = 99;
        $request['keterangan'] = "Antrian dibatalkan di poliklinik oleh " . Auth::user()->name;
        $vclaim = new AntrianAntrianController();
        $response = $vclaim->batal_antrian($request);
        if ($response->status() == 200) {
            Alert::success('Success', "Antrian berhasil dibatalkan");
        } else {
            Alert::error('Error ' . $response->status(), $response->getData()->metadata->message);
        }
        return redirect()->back();
    }
    public function lanjut_farmasi($kodebooking, Request $request)
    {
        $antrian = Antrian::firstWhere('kodebooking', $kodebooking);
        $request['kodebooking'] = $antrian->kodebooking;
        $request['jenisresep'] = 'Non Racikan';
        $request['taskid'] = 5;
        $request['keterangan'] = "Silahkan tunggu di farmasi untuk pengambilan obat.";
        $request['waktu'] = Carbon::now()->timestamp * 1000;
        $api = new AntrianAntrianController();
        $response = $api->update_antrean($request);
        if ($response->status() == 200) {
            $antrian->update([
                'taskid' => $request->taskid,
                'status_api' => 0,
                'keterangan' => $request->keterangan,
                'user' => Auth::user()->name,
            ]);
            // try {
            //     // notif wa
            //     $wa = new WhatsappController();
            //     $request['message'] = "Pelayanan di poliklinik atas nama pasien " . $antrian->nama . " dengan nomor antrean " . $antrian->nomorantrean . " telah selesai. " . $request->keterangan;
            //     $request['number'] = $antrian->nohp;
            //     $wa->send_message($request);
            // } catch (\Throwable $th) {
            //     //throw $th;
            // }
            Alert::success('Success', 'Pasien Dilanjutkan Ke Farmasi');
        } else {
            Alert::error('Error ' . $response->status(), $response->getData()->metadata->message);
        }
        $response = $api->ambil_antrian_farmasi($request);
        // if ($response->status() == 200) {
        //     Alert::success('Success', 'Pasien Dilanjutkan Ke Farmasi');
        // } else {
        //     Alert::error('Error Tambah Antrian Farmasi ' . $response->status(), $response->getData()->metadata->message);
        // }
        return redirect()->back();
    }
    public function lanjut_farmasi_racikan($kodebooking, Request $request)
    {
        $antrian = Antrian::firstWhere('kodebooking', $kodebooking);
        $request['kodebooking'] = $antrian->kodebooking;
        $request['jenisresep'] = 'Racikan';
        $request['taskid'] = 5;
        $request['keterangan'] = "Silahkan tunggu di farmasi untuk pengambilan obat.";
        $request['waktu'] = Carbon::now()->timestamp * 1000;
        $api = new AntrianAntrianController();
        $response = $api->update_antrean($request);
        if ($response->status() == 200) {
            $antrian->update([
                'taskid' => $request->taskid,
                'status_api' => 0,
                'keterangan' => $request->keterangan,
                'user' => Auth::user()->name,
            ]);
            // try {
            //     // notif wa
            //     $wa = new WhatsappController();
            //     $request['message'] = "Pelayanan di poliklinik atas nama pasien " . $antrian->nama . " dengan nomor antrean " . $antrian->nomorantrean . " telah selesai. " . $request->keterangan;
            //     $request['number'] = $antrian->nohp;
            //     $wa->send_message($request);
            // } catch (\Throwable $th) {
            //     //throw $th;
            // }
            Alert::success('Success', 'Pasien Dilanjutkan Ke Farmasi');
        } else {
            Alert::error('Error ' . $response->status(), $response->getData()->metadata->message);
        }
        $response = $api->ambil_antrian_farmasi($request);
        // if ($response->status() == 200) {
        //     Alert::success('Success', 'Pasien Dilanjutkan Ke Farmasi');
        // } else {
        //     Alert::error('Error Tambah Antrian Farmasi ' . $response->status(), $response->getData()->metadata->message);
        // }
        return redirect()->back();
    }
    public function selesai_poliklinik($kodebooking, Request $request)
    {
        $antrian = Antrian::where('kodebooking', $kodebooking)->first();
        $request['kodebooking'] = $antrian->kodebooking;
        $request['taskid'] = 5;
        $request['keterangan'] = "Selesai poliklinik";
        $request['waktu'] = Carbon::now()->timestamp * 1000;
        $vclaim = new AntrianAntrianController();
        $response = $vclaim->update_antrean($request);
        if ($response->status() == 200) {
            $antrian->update([
                'taskid' => $request->taskid,
                'status_api' => 1,
                'keterangan' => $request->keterangan,
                'user' => Auth::user()->name,
            ]);
            // try {
            //     // notif wa
            //     $wa = new WhatsappController();
            //     $request['message'] = "Pelayanan di poliklinik atas nama pasien " . $antrian->nama . " dengan nomor antrean " . $antrian->nomorantrean . " telah selesai. " . $request->keterangan;
            //     $request['number'] = $antrian->nohp;
            //     $wa->send_message($request);
            // } catch (\Throwable $th) {
            //     //throw $th;
            // }
            Alert::success('Success', 'Pasien Selesai Di Poliklinik');
        } else {
            Alert::error('Error ' . $response->status(), $response->getData()->metadata->message);
        }
        return redirect()->back();
    }
    public function suratkontrol_poliklinik(Request $request)
    {
        $kunjungans = null;
        $surat_kontrols = null;
        if ($request->tanggal) {
            $surat_kontrols = SuratKontrol::whereDate('tglTerbitKontrol', $request->tanggal)->get();
            $kunjungans = KunjunganDB::whereDate('tgl_masuk', $request->tanggal)
                ->where('status_kunjungan', "!=", 8)
                ->where('kode_unit', "!=", null)
                ->where('kode_unit', 'LIKE', '10%')
                ->where('kode_unit', "!=", 1002)
                ->where('kode_unit', "!=", 1023)
                ->with(['dokter', 'unit', 'pasien', 'surat_kontrol'])
                ->get();
            if ($request->kodepoli != null) {
                $poli = UnitDB::where('KDPOLI', $request->kodepoli)->first();
                $kunjungans = $kunjungans->where('kode_unit', $poli->kode_unit);
                $surat_kontrols = $surat_kontrols->where('poliTujuan', $request->kodepoli);
            }
            if ($request->kodedokter != null) {
                $dokter = ParamedisDB::where('kode_dokter_jkn', $request->kodedokter)->first();
                $kunjungans = $kunjungans->where('kode_paramedis', $dokter->kode_paramedis);
            }
        }
        if ($request->kodepoli == null) {
            $unit = UnitDB::where('KDPOLI', "!=", null)
                ->where('KDPOLI', "!=", "")
                ->get();
            $dokters = ParamedisDB::where('kode_dokter_jkn', "!=", null)
                ->where('unit', "!=", null)
                ->get();
        } else {
            $unit = UnitDB::where('KDPOLI', "!=", null)
                ->where('KDPOLI', "!=", "")
                ->get();
            $poli =   UnitDB::firstWhere('KDPOLI', $request->kodepoli);
            $dokters = ParamedisDB::where('unit', $poli->kode_unit)
                ->where('kode_dokter_jkn', "!=", null)
                ->get();
        }
        return view('simrs.poliklinik.poliklinik_suratkontrol', [
            'kunjungans' => $kunjungans,
            'request' => $request,
            'unit' => $unit,
            'dokters' => $dokters,
            'surat_kontrols' => $surat_kontrols,
        ]);
    }
    public function laporan_kunjungan_poliklinik(Request $request)
    {
        $response = null;
        $kunjungans = null;
        if (isset($request->tanggal) && isset($request->kodepoli)) {
            $poli = UnitDB::where('KDPOLI', $request->kodepoli)->first();
            $kunjungans = KunjunganDB::whereDate('tgl_masuk', $request->tanggal)
                ->where('kode_unit', $poli->kode_unit)
                ->where('status_kunjungan',  "<=", 2)
                ->with(['dokter', 'unit', 'pasien', 'diagnosapoli', 'pasien.kecamatans', 'penjamin', 'surat_kontrol'])
                ->get();
            $response = DB::connection('mysql2')->select("CALL SP_PANGGIL_PASIEN_RAWAT_JALAN_KUNJUNGAN('" . $poli->kode_unit . "','" . $request->tanggal . "')");
        }
        $unit = UnitDB::where('KDPOLI', "!=", null)->where('KDPOLI', "!=", "")->get();
        $penjaminrs = PenjaminSimrs::get();
        $response = collect($response);
        return view('simrs.poliklinik.poliklinik_laporan_kunjungan', [
            'kunjungans' => $kunjungans,
            'request' => $request,
            'response' => $response,
            'penjaminrs' => $penjaminrs,
            'unit' => $unit,
        ]);
    }
    public function laporan_antrian_poliklinik(Request $request)
    {
        if ($request->tanggal == null) {
            $tanggal_awal = now()->startOfDay()->format('Y-m-d');
            $tanggal_akhir = now()->endOfDay()->format('Y-m-d');
        } else {
            $tanggal = explode(' - ', $request->tanggal);
            $tanggal_awal = Carbon::parse($tanggal[0])->format('Y-m-d');
            $tanggal_akhir = Carbon::parse($tanggal[1])->format('Y-m-d');
        }
        $antrians = Antrian::whereBetween('tanggalperiksa', [$tanggal_awal, $tanggal_akhir])
            ->get();
        $kunjungans = KunjunganDB::whereBetween('tgl_masuk', [Carbon::parse($tanggal_awal)->startOfDay(), Carbon::parse($tanggal_akhir)->endOfDay()])
            ->where('kode_unit', "!=", null)
            ->where('kode_unit', 'LIKE', '10%')
            ->where('kode_unit', '!=', 1002)
            ->where('kode_unit', "!=", 1023)
            ->where('kode_unit', "!=", 1015)
            ->get();
        $units = UnitDB::where('KDPOLI', '!=', null)->get();
        return view('simrs.laporan_kunjungan', [
            'antrians' => $antrians,
            'request' => $request,
            'kunjungans' => $kunjungans,
            'units' => $units,
        ]);
    }
    // farmasi
    public function antrian_farmasi(Request $request)
    {
        $antrians = null;
        if ($request->tanggal) {
            $request['tanggal'] = Carbon::now()->format('Y-m-d');
            $antrians = Antrian::whereDate('tanggalperiksa', $request->tanggal)
                ->where('taskid', '>=', 3)->get();
        }
        // $polis = PoliklinikDB::where('status', 1)->get();
        // $dokters = Dokter::get();
        return view('simrs.antrian_farmasi', [
            'antrians' => $antrians,
            'request' => $request,
            // 'polis' => $polis,
            // 'dokters' => $dokters,
        ]);
    }
    public function racik_farmasi($kodebooking, Request $request)
    {
        $antrian = Antrian::where('kodebooking', $kodebooking)->first();
        if ($antrian) {
            $request['kodebooking'] = $antrian->kodebooking;
            $request['taskid'] = 6;
            $request['keterangan'] = "Proses peracikan obat";
            $request['waktu'] = Carbon::now()->timestamp * 1000;

            $api = new AntrianAntrianController();
            $response = $api->update_antrean($request);
            if ($response->status() == 200) {
                $antrian->update([
                    'taskid' => $request->taskid,
                    'status_api' => 1,
                    'keterangan' => $request->keterangan,
                    'user' => Auth::user()->name,
                ]);
                // try {
                //     // notif wa
                //     $wa = new WhatsappController();
                //     $request['message'] = "Resep obat atas nama pasien " . $antrian->nama . " dengan nomor antrean " . $antrian->nomorantrean . " telah diterima farmasi. Silahkan menunggu peracikan obat.";
                //     $request['number'] = $antrian->nohp;
                //     $wa->send_message($request);
                // } catch (\Throwable $th) {
                //     //throw $th;
                // }
                Alert::success('Success', 'Resep Obat Pasien Diterima Farmasi');
            } else {
                Alert::error('Error ' . $response->status(), $response->getData()->metadata->message);
            }
            return redirect()->back();
        } else {
            Alert::error('Error', 'Kodebooking tidak ditemukan');
            return redirect()->back();
        }
    }
    public function selesai_farmasi($kodebooking, Request $request)
    {
        $antrian = Antrian::where('kodebooking', $kodebooking)->first();
        $request['kodebooking'] = $antrian->kodebooking;
        $request['taskid'] = 7;
        $request['keterangan'] = "Selesai peracikan obat";
        $request['waktu'] = Carbon::now()->timestamp * 1000;
        $api = new AntrianAntrianController();
        $response = $api->update_antrean($request);
        if ($response->status() == 200) {
            $antrian->update([
                'taskid' => $request->taskid,
                'status_api' => 1,
                'keterangan' => $request->keterangan,
                'user' => Auth::user()->name,
            ]);
            // try {
            //     // notif wa
            //     $wa = new WhatsappController();
            //     $request['message'] = "Resep obat atas nama pasien " . $antrian->nama . " dengan nomor antrean " . $antrian->nomorantrean . " telah diterima farmasi. Silahkan menunggu peracikan obat.";
            //     $request['number'] = $antrian->nohp;
            //     $wa->send_message($request);
            // } catch (\Throwable $th) {
            //     //throw $th;
            // }
            Alert::success('Success', 'Selesai Peracikan Obat.');
        } else {
            Alert::error('Error ' . $response->status(), $response->getData()->metadata->message);
        }
        return redirect()->back();
    }
    // ADM
    public function dashboard_antrian_tanggal(Request $request)
    {
        $antrians = null;
        if (isset($request->tanggal) && isset($request->waktu)) {
            $api = new AntrianAntrianController();
            $response = $api->dashboard_tanggal($request);
            if ($response->status() == 200) {
                $antrians = $response->getData()->response->list;
                Alert::success('Success', "Berhasil Dapatkan Data Antrian");
            } else {
                Alert::error('Error ' . $response->status(),  $response->getData()->metadata->message);
                return redirect()->route('antrian.laporan_tanggal');
            }
        }
        return view('simrs.antrian_laporan_tanggal', [
            'antrians' => $antrians,
            'request' => $request,
        ]);
    }
    public function dashboard_antrian_bulan(Request $request)
    {
        if ($request['tanggal'] == null) {
            $request['tanggal'] = Carbon::now()->format('Y-m');
            $request['tahun'] = Carbon::now()->format('Y');
            $request['bulan'] = Carbon::now()->format('m');
            $request['waktu'] = 'rs';
            $antrians = null;
            return view('simrs.antrian_laporan_bulan', [
                'antrians' => $antrians,
                'request' => $request,
            ]);
        } else {
            $tanggal = explode('-', $request->tanggal);
            $request['tahun'] = $tanggal[0];
            $request['bulan'] = $tanggal[1];
            $api = new AntrianBPJSController();
            $response = $api->dashboard_bulan($request);
            if ($response->metadata->code == 200) {
                Alert::success('Success', "Success Message " . $response->metadata->message);
                $antrians = collect($response->response->list);
                $antri_group = collect($antrians)->groupBy('namapoli');
                // dd($antrians);
                return view('simrs.antrian_laporan_bulan', [
                    'antrians' => $antrians,
                    'request' => $request,
                    'antri_group' => $antri_group,
                ]);
            } else {
                Alert::error('Error Title', "Error Message " . $response->metadata->message);
                return redirect()->route('antrian.laporan_bulan');
            }
        }
    }
    public function antrian_per_tanggal(Request $request)
    {
        $antrians = null;
        if (isset($request->tanggal)) {
            $api = new AntrianAntrianController();
            $response = $api->antrian_tanggal($request);
            if ($response->status() == 200) {
                $antrians = $response->getData()->response;
                Alert::success('Success', "Berhasil Dapatkan Data Antrian");
            } else {
                Alert::error('Error ' . $response->status(),  $response->getData()->metadata->message);
                return redirect()->route('bpjs.antrian.antrian_per_tanggal');
            }
        }
        return view('simrs.antrian_per_tanggal', [
            'antrians' => $antrians,
            'request' => $request,
        ]);
    }
    public function antrian_per_kodebooking(Request $request)
    {
        $antrian = null;
        if ($request->kodebooking) {
            $request['kodeBooking'] = $request->kodebooking;
            $api = new AntrianAntrianController();
            $response = $api->antrian_kodebooking($request);
            if ($response->status() == 200) {
                $antrian = $response->getData()->response[0];
            }
        } else {
            # code...
        }
        return view('bpjs.antrian.antrian_per_kodebooking', compact([
            'request', 'antrian'
        ]));
    }
    public function antrian_belum_dilayani(Request $request)
    {
        // $antrians = null;
        // if (isset($request->tanggal)) {
        $request['tanggal'] = now()->format('Y-m-d');
        $api = new AntrianAntrianController();
        $response = $api->antrian_belum_dilayani($request);
        if ($response->status() == 200) {
            $antrians = $response->getData()->response;
            Alert::success('Success', "Berhasil Dapatkan Data Antrian");
        } else {
            $antrians = null;
            Alert::error('Error ' . $response->status(),  $response->getData()->metadata->message);
            return redirect()->route('antrian.laporan_tanggal');
        }
        // }
        return view('simrs.antrian_belum_dilayani', [
            'antrians' => $antrians,
            'request' => $request,
        ]);
    }
    public function antrian_per_dokter(Request $request)
    {
        $antrians = null;
        $jadwaldokter = SIMRSJadwalDokter::orderBy('hari', 'ASC')->get();
        if (isset($request->jadwaldokter)) {
            $jadwal = SIMRSJadwalDokter::find($request->jadwaldokter);
            $api = new AntrianAntrianController();
            $request['kodePoli'] = $jadwal->kodesubspesialis;
            $request['kodeDokter'] = $jadwal->kodedokter;
            $request['hari'] = $jadwal->hari;
            $request['jamPraktek'] = $jadwal->jadwal;
            $response = $api->antrian_poliklinik($request);
            if ($response->status() == 200) {
                $antrians = $response->getData()->response;
                Alert::success('Success', "Berhasil Dapatkan Data Antrian");
            } else {
                Alert::error('Error ' . $response->status(),  $response->getData()->metadata->message);
            }
        }
        return view('simrs.antrian_per_dokter', [
            'antrians' => $antrians,
            'jadwaldokter' => $jadwaldokter,
            'request' => $request,
        ]);
    }
    public function antrian_capaian(Request $request)
    {
        $antrians_total = Antrian::select(
            DB::raw("count(*) as total"),
            DB::raw("(DATE_FORMAT(created_at, '%Y-%m')) as bulan")
        )


            ->orderBy('created_at')
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
            ->get();

        $tanggal_awal = Antrian::orderBy('tanggalperiksa', 'ASC')->first()->tanggalperiksa;
        $kunjungans = KunjunganDB::whereBetween('tgl_masuk', [Carbon::parse($tanggal_awal)->startOfDay(), Carbon::now()->endOfDay()])
            ->where('kode_unit', "!=", null)
            ->where('kode_unit', 'LIKE', '10%')
            ->where('kode_unit', '!=', 1002)
            ->where('kode_unit', "!=", 1023)
            ->where('kode_unit', "!=", 1015)
            ->select(
                DB::raw("count(*) as total"),
                DB::raw("(DATE_FORMAT(tgl_masuk, '%Y-%m')) as bulan")
            )
            ->orderBy('tgl_masuk')
            ->groupBy(DB::raw("DATE_FORMAT(tgl_masuk, '%Y-%m')"))
            ->get();
        $antrian_nobatal = Antrian::where('taskid', '!=', 99)
            ->where('method', '!=', 'Offline')
            ->select(
                DB::raw("count(*) as total"),
                DB::raw("(DATE_FORMAT(created_at, '%Y-%m')) as bulan")
            )
            ->orderBy('created_at')
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
            ->get();

        $antrian_selesai = Antrian::whereIn('taskid',  [5, 7])
            ->select(
                DB::raw("count(*) as total"),
                DB::raw("(DATE_FORMAT(created_at, '%Y-%m')) as bulan")
            )
            ->orderBy('created_at')
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
            ->get();

        $antrian_whatsapp = Antrian::where('taskid', '!=', 99)
            ->whereIn('method', ['Whatsapp', 'ON'])
            ->select(
                DB::raw("count(*) as total"),
                DB::raw("(DATE_FORMAT(created_at, '%Y-%m')) as bulan")
            )
            ->orderBy('created_at')
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
            ->get();


        $antrian_jkn = Antrian::where('taskid', '!=', 99)
            ->whereIn('method', ['JKN Mobile'])
            ->select(
                DB::raw("count(*) as total"),
                DB::raw("(DATE_FORMAT(created_at, '%Y-%m')) as bulan")
            )
            ->orderBy('created_at')
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
            ->get();

        $antrian_lainnya = Antrian::where('taskid', '!=', 99)
            ->whereNotIn('method', ['JKN Mobile', 'Whatsapp', 'ON', 'OFF', 'Offline'])
            ->select(
                DB::raw("count(*) as total"),
                DB::raw("(DATE_FORMAT(created_at, '%Y-%m')) as bulan")
            )
            ->orderBy('created_at')
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
            ->get();

        return view('simrs.pendaftaran.capaian_antrian', compact([
            // 'antrians_total',
            'antrian_nobatal',
            'antrian_selesai',
            'antrian_whatsapp',
            'antrian_jkn',
            'antrian_lainnya',
            'kunjungans',
            'request',
        ]));
    }
}
