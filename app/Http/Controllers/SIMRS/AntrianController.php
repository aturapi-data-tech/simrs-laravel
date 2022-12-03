<?php

namespace App\Http\Controllers\SIMRS;

use App\Http\Controllers\BPJS\Antrian\AntrianController as AntrianAntrianController;
use App\Http\Controllers\Controller;
use App\Models\Antrian;
use App\Models\AntrianDB;
use App\Models\JadwalDokter;
use App\Models\KunjunganDB;
use App\Models\ParamedisDB;
use App\Models\PenjaminSimrs;
use App\Models\PoliklinikDB;
use App\Models\UnitDB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravolt\Indonesia\Models\Provinsi;
use RealRashid\SweetAlert\Facades\Alert;

class AntrianController extends Controller
{
    public function anjungan()
    {
        $poliklinik = PoliklinikDB::with(['antrians', 'jadwals'])->where('status', 1)->get();
        $jadwal = JadwalDokter::where('hari',  now()->dayOfWeek)->get();
        return view('simrs.antrian_console', [
            'poliklinik' => $poliklinik,
            'jadwal' => $jadwal,
        ]);
    }
    public function pendaftaran(Request $request)
    {
        $antrians = [];
        if ($request->tanggal) {
            $antrians = Antrian::where('tanggalperiksa', $request->tanggal)->get();
        }
        $provinsis = Provinsi::get();
        return view('simrs.laporan_antrian', [
            'antrians' => $antrians,
            'request' => $request,
            'provinsis' => $provinsis,
        ]);
    }
    // poliklinik
    public function antrian_poliklinik(Request $request)
    {
        $antrians = null;
        if ($request->tanggal) {
            $antrians = Antrian::whereDate('tanggalperiksa', $request->tanggal)
                ->get();
            if ($request->kodepoli != null) {
                $antrians = $antrians->where('kodepoli', $request->kodepoli);
            }
            if ($request->kodedokter != null) {
                $antrians = $antrians->where('kodedokter', $request->kodedokter);
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
        $request['waktu'] = Carbon::now()->timestamp * 1000;
        $request['keterangan'] = "Dibatalkan dari sisi sistem oleh " . Auth::user()->name;
        $vclaim = new AntrianAntrianController();
        $response = $vclaim->update_antrean($request);
        if ($response->status() == 200) {
            $antrian->update([
                "taskid" => $request->taskid,
                "status_api" => 1,
                "keterangan" => $request->keterangan,
            ]);
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
        $request['taskid'] = 5;
        $request['keterangan'] = "Silahkan tunggu di farmasi untuk pengambilan obat.";
        $request['waktu'] = Carbon::now()->timestamp * 1000;
        $vclaim = new AntrianAntrianController();
        $response = $vclaim->update_antrean($request);
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
            Alert::success('Success', 'Panggil Pasien Berhasil');
        } else {
            Alert::error('Error ' . $response->status(), $response->getData()->metadata->message);
        }
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
            Alert::success('Success', 'Panggil Pasien Berhasil');
        } else {
            Alert::error('Error ' . $response->status(), $response->getData()->metadata->message);
        }
        return redirect()->back();
    }



    public function laporan(Request $request)
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
    public function laporan_kunjungan(Request $request)
    {

        $response = null;
        $kunjungans = null;
        if (isset($request->tanggal) && isset($request->kodepoli)) {
            $poli = UnitDB::where('KDPOLI', $request->kodepoli)->first();
            $kunjungans = KunjunganDB::whereDate('tgl_masuk', $request->tanggal)
                ->where('kode_unit', $poli->kode_unit)
                ->where('status_kunjungan',  2)
                ->with(['dokter', 'unit', 'pasien', 'diagnosapoli', 'pasien.kecamatans', 'penjamin', 'surat_kontrol'])
                ->get();
            $response = DB::connection('mysql2')->select("CALL SP_PANGGIL_PASIEN_RAWAT_JALAN_KUNJUNGAN('" . $poli->kode_unit . "','" . $request->tanggal . "')");
        }
        $unit = UnitDB::where('KDPOLI', "!=", null)->get();
        $penjaminrs = PenjaminSimrs::get();
        $response = collect($response);
        // dd($response);
        // dd($response->where('KODE_KUNJUNGAN', $kunjungans->first()->kode_kunjungan)->first()->diagx);
        return view('simrs.antrian_laporan_kunjungan', [
            'kunjungans' => $kunjungans,
            'request' => $request,
            'response' => $response,
            'penjaminrs' => $penjaminrs,
            'unit' => $unit,
        ]);
    }
}
