<?php

namespace App\Http\Controllers\SIMRS;

use App\Http\Controllers\BPJS\Antrian\AntrianController;
use App\Http\Controllers\Controller;
use App\Models\BPJS\Antrian\DokterAntrian;
use App\Models\Dokter;
use App\Models\ParamedisDB;
use App\Models\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class DokterController extends Controller
{
    public function index(Request $request)
    {
        $paramedis = ParamedisDB::get(['kode_paramedis', 'kode_dokter_jkn', 'nama_paramedis', 'sip_dr']);
        $paramedis_total = ParamedisDB::count();
        $total_paramedis = ParamedisDB::count();

        // get dokter vclaim bpjs
        $controller = new AntrianController();
        $response = $controller->ref_dokter();
        if ($response->status() == 200) {
            $dokter_bpjs = collect($response->getData()->response);
        } else {
            $dokter_bpjs = null;
            Alert::error($response->getData()->metadata->message . ' ' . $response->status());
        }

        // $paramedis->where('kode_dokter_jkn', )
        return view('simrs.dokter_index', compact([
            'request',
            'dokter_bpjs',
            'paramedis',
            'paramedis_total',
            'total_paramedis',
        ]));
    }
    public function show($id)
    {
        $dokter = ParamedisDB::where('kode_paramedis', $id)->first();
        return response()->json($dokter);
    }
    public function create()
    {
        $api = new AntrianController();
        $dokters = $api->ref_dokter()->getData()->response;
        foreach ($dokters as $value) {
            Dokter::updateOrCreate(
                [
                    'kodedokter' => $value->kodedokter,
                ],
                [
                    'namadokter' => $value->namadokter,
                    'status' => 1,
                ]
            );
            $user = User::updateOrCreate([
                'email' => $value->kodedokter . '@gmail.com',
                'username' => $value->kodedokter,
            ], [
                'name' => $value->namadokter,
                'phone' => $value->kodedokter,
                'password' => bcrypt($value->kodedokter),
            ]);
            $user->assignRole('Dokter');
        }
        Alert::success('Success', 'Refresh User Data Dokter Berhasil');
        return redirect()->back();
    }
    public function dokter_antrian_bpjs()
    {
        $controller = new AntrianController();
        $response = $controller->ref_dokter();
        if ($response->status() == 200) {
            $dokters = $response->getData()->response;
            Alert::success($response->statusText(), 'Dokter Antrian BPJS Total : ' . count($dokters));
        } else {
            $dokters = null;
            Alert::error($response->getData()->metadata->message . ' ' . $response->status());
        }
        $dokter_jkn_simrs = Dokter::get();
        return view('bpjs.antrian.dokter', compact([
            'dokters',
            'dokter_jkn_simrs',
        ]));
    }
    public function dokter_antrian_refresh(Request $request)
    {
        $controller = new AntrianController();
        $response = $controller->ref_dokter();
        if ($response->status() == 200) {
            $dokters = $response->getData()->response;
            foreach ($dokters as $value) {
                DokterAntrian::firstOrCreate([
                    'kodeDokter' => $value->kodedokter,
                    'namaDokter' => $value->namadokter,
                ]);
            }
            Alert::success($response->statusText(), 'Refresh Dokter Antrian BPJS Total : ' . count($dokters));
        } else {
            Alert::error($response->getData()->metadata->message . ' ' . $response->status());
        }
        return redirect()->route('pelayanan-medis.dokter_antrian');
    }
    public function dokter_antrian_yanmed(Request $request)
    {
        $dokters =  DokterAntrian::get();
        return view('simrs.pelyananmedis.dokter_antrian', compact([
            'dokters'
        ]));
    }
}
