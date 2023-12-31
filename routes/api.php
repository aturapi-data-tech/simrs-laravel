<?php

use App\Http\Controllers\Admin\WhatsappController as AdminWhatsappController;
use App\Http\Controllers\AntrianController;
use App\Http\Controllers\API\AntrianBPJSController;
use App\Http\Controllers\API\VclaimBPJSController;
use App\Http\Controllers\API\WhatsappController;
use App\Http\Controllers\BPJS\Antrian\AntrianController as AntrianAntrianController;
use App\Http\Controllers\BPJS\Vclaim\VclaimController as VclaimVclaimController;
use App\Http\Controllers\Inacbg\InacbgController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\SatuSehat\EncounterController;
use App\Http\Controllers\SatuSehat\LocationController;
use App\Http\Controllers\SatuSehat\OrganizationController;
use App\Http\Controllers\SatuSehat\PatientController;
use App\Http\Controllers\SatuSehat\PractitionerController;
use App\Http\Controllers\SIMRS\ICD10Controller;
use App\Http\Controllers\SIMRS\ICD9Controller;
use App\Http\Controllers\SIMRS\LayananController;
use App\Http\Controllers\SIMRS\ObatController;
use App\Http\Controllers\SIMRS\PasienController as SIMRSPasienController;
use App\Http\Controllers\SIMRS\PenunjangController;
use App\Http\Controllers\SIMRS\RISController;
use App\Http\Controllers\VclaimController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('vclaim')->group(function () {
    Route::get('caripasien', [SIMRSPasienController::class, 'caripasien'])->name('api.caripasien');
});
// tanda tanya
Route::prefix('antrian')->group(function () {
    Route::get('signature', [AntrianBPJSController::class, 'signature']);
    Route::get('ref_poli', [AntrianBPJSController::class, 'ref_poli']);
    Route::get('ref_dokter', [AntrianBPJSController::class, 'ref_dokter']);
    Route::get('ref_jadwal', [AntrianBPJSController::class, 'ref_jadwal_dokter']);
    Route::post('ref_updatejadwal', [AntrianBPJSController::class, 'update_jadwal_dokter']);
    Route::post('tambah', [AntrianBPJSController::class, 'tambah_antrian']);
    Route::post('update', [AntrianBPJSController::class, 'update_antrian']);
    Route::post('batal', [AntrianBPJSController::class, 'batal_antrian_bpjs']);
    Route::post('listtask', [AntrianBPJSController::class, 'list_waktu_task']);
    Route::get('dashboard_tanggal', [AntrianBPJSController::class, 'dashboard_tanggal']);
    Route::get('dashboard_bulan', [AntrianBPJSController::class, 'dashboard_bulan']);
    Route::get('status_antrean', [AntrianBPJSController::class, 'status_antrean'])->name('api.status_antrean');
    Route::post('ambil_antrean', [AntrianBPJSController::class, 'ambil_antrean'])->name('api.ambil_antrean');
});
//
Route::get('token', [AntrianAntrianController::class, 'token']);
Route::prefix('wsrs')->group(function () {
    Route::post('status_antrian', [AntrianAntrianController::class, 'status_antrian']);
    Route::post('ambil_antrian', [AntrianAntrianController::class, 'ambil_antrian']);
    Route::post('sisa_antrian', [AntrianAntrianController::class, 'sisa_antrian']);
    Route::post('batal_antrian', [AntrianAntrianController::class, 'batal_antrian']);
    Route::post('checkin_antrian', [AntrianAntrianController::class, 'checkin_antrian']);
    Route::post('info_pasien_baru', [AntrianAntrianController::class, 'info_pasien_baru']);
    Route::post('jadwal_operasi_rs', [AntrianAntrianController::class, 'jadwal_operasi_rs']);
    Route::post('jadwal_operasi_pasien', [AntrianAntrianController::class, 'jadwal_operasi_pasien']);
    Route::post('ambil_antrean_farmasi', [AntrianAntrianController::class, 'ambil_antrian_farmasi']);
    Route::post('status_antrean_farmasi', [AntrianAntrianController::class, 'status_antrian_farmasi']);
    Route::post('update_antrean_pendaftaran', [AntrianAntrianController::class, 'update_antrean_pendaftaran']); #integrasi bridging pendaftaran agil
});
Route::prefix('vclaim')->group(function () {
    // ref
    Route::get('signature', [VclaimBPJSController::class, 'signature'])->name('signature');
    Route::get('ref_provinsi', [VclaimBPJSController::class, 'ref_provinsi'])->name('ref_provinsi');
    Route::post('ref_kabupaten', [VclaimBPJSController::class, 'ref_kabupaten'])->name('ref_kabupaten');
    Route::post('ref_kecamatan', [VclaimBPJSController::class, 'ref_kecamatan'])->name('ref_kecamatan');
    // monitoring
    Route::get('monitoring_pelayanan_peserta', [VclaimBPJSController::class, 'monitoring_pelayanan_peserta']);
    // peserta cek
    Route::get('peserta_nomorkartu', [VclaimBPJSController::class, 'peserta_nomorkartu'])->name('api.cek_nomorkartu');
    Route::get('peserta_nik', [VclaimBPJSController::class, 'peserta_nik'])->name('api.cek_nik');
    // rujukan
    Route::get('rujukan_nomor', [VclaimBPJSController::class, 'rujukan_nomor'])->name('api.rujukan_nomor');
    Route::get('rujukan_peserta', [VclaimBPJSController::class, 'rujukan_peserta'])->name('api.rujukan_peserta');
    Route::get('rujukan_rs_nomor', [VclaimBPJSController::class, 'rujukan_rs_nomor'])->name('api.rujukan_rs_nomor');
    Route::get('rujukan_rs_peserta', [VclaimBPJSController::class, 'rujukan_rs_peserta'])->name('api.rujukan_rs_peserta');
    Route::get('rujukan_jumlah_sep', [VclaimBPJSController::class, 'rujukan_jumlah_sep'])->name('api.rujukan_jumlah_sep');
    // sep
    Route::post('insert_sep', [VclaimBPJSController::class, 'insert_sep']);
    Route::delete('delete_sep', [VclaimBPJSController::class, 'delete_sep']);
    Route::get('cari_sep', [VclaimBPJSController::class, 'cari_sep']);
    Route::get('sep_internal', [VclaimBPJSController::class, 'sep_internal']);
    Route::delete('sep_internal_delete', [VclaimBPJSController::class, 'sep_internal_delete'])->name('api.sep_internal_delete');
    // surat kontrol
    Route::post('insert_rencana_kontrol', [VclaimBPJSController::class, 'insert_rencana_kontrol']);
    Route::post('surat_kontrol_insert', [VclaimBPJSController::class, 'surat_kontrol_insert'])->name('api.surat_kontrol_insert');
    Route::post('surat_kontrol_update', [VclaimBPJSController::class, 'surat_kontrol_update'])->name('api.surat_kontrol_update');
    Route::post('surat_kontrol_delete', [VclaimBPJSController::class, 'surat_kontrol_delete'])->name('api.surat_kontrol_delete');
    Route::get('surat_kontrol_nomor', [VclaimBPJSController::class, 'surat_kontrol_nomor'])->name('api.surat_kontrol_nomor');
    Route::get('surat_kontrol_peserta', [VclaimBPJSController::class, 'surat_kontrol_peserta'])->name('api.surat_kontrol_peserta');
    Route::get('surat_kontrol_poli', [VclaimBPJSController::class, 'surat_kontrol_poli'])->name('api.surat_kontrol_poli');
    Route::get('surat_kontrol_dokter', [VclaimBPJSController::class, 'surat_kontrol_dokter'])->name('api.surat_kontrol_dokter');
});
Route::prefix('wa')->group(function () {
    Route::get('test', [AdminWhatsappController::class, 'test']);
    Route::post('callback', [AdminWhatsappController::class, 'callback']);
});
// APP.RSUDWALED.ID
Route::get('token', [AntrianAntrianController::class, 'token']);
Route::post('statusantrean', [AntrianAntrianController::class, 'status_antrian']);
Route::post('ambilantrean', [AntrianAntrianController::class, 'ambil_antrian']);
Route::post('sisaantrean', [AntrianAntrianController::class, 'sisa_antrian']);
Route::post('batalantrean', [AntrianAntrianController::class, 'batal_antrian']);
Route::post('checkin', [AntrianAntrianController::class, 'checkin_antrian']);
Route::post('infopasienbaru', [AntrianAntrianController::class, 'infoPasienBaru']);
Route::post('jadwaloperasi', [AntrianAntrianController::class, 'jadwal_operasi_rs']);
Route::post('jadwaloperasipasien', [AntrianAntrianController::class, 'jadwal_operasi_pasien']);
Route::post('ambilantreanfarmasi', [AntrianAntrianController::class, 'ambil_antrian_farmasi']);
Route::post('statusantreanfarmasi', [AntrianAntrianController::class, 'status_antrian_farmasi']);
// API SIMRS
Route::prefix('simrs')->name('api.simrs.')->group(function () {
    Route::get('get_icd10', [ICD10Controller::class, 'get_icd10'])->name('get_icd10');
    Route::get('get_icd9', [ICD9Controller::class, 'get_icd9'])->name('get_icd9');
    Route::get('get_obats', [ObatController::class, 'get_obats'])->name('get_obats');
    Route::get('get_layanans', [LayananController::class, 'get_layanans'])->name('get_layanans');
});
// API BPJS
Route::prefix('bpjs')->name('api.bpjs.')->group(function () {
    // ANTRIAN
    Route::prefix('antrian')->name('antrian.')->group(function () {
        // API BPJS
        Route::get('ref_poli', [AntrianAntrianController::class, 'ref_poli'])->name('ref_poli');
        Route::get('ref_dokter', [AntrianAntrianController::class, 'ref_dokter'])->name('ref_dokter');
        Route::get('ref_jadwal_dokter', [AntrianAntrianController::class, 'ref_jadwal_dokter'])->name('ref_jadwal_dokter');
        Route::get('ref_poli_fingerprint', [AntrianAntrianController::class, 'ref_poli_fingerprint'])->name('ref_poli_fingerprint');
        Route::get('ref_pasien_fingerprint', [AntrianAntrianController::class, 'ref_pasien_fingerprint'])->name('ref_pasien_fingerprint');
        Route::post('update_jadwal_dokter', [AntrianAntrianController::class, 'update_jadwal_dokter'])->name('update_jadwal_dokter');
        Route::post('tambah_antrean', [AntrianAntrianController::class, 'tambah_antrean'])->name('tambah_antrean');
        Route::post('tambah_antrean_farmasi', [AntrianAntrianController::class, 'tambah_antrean_farmasi'])->name('tambah_antrean_farmasi');
        Route::post('update_antrean', [AntrianAntrianController::class, 'update_antrean'])->name('update_antrean');
        Route::post('batal_antrean', [AntrianAntrianController::class, 'batal_antrean'])->name('batal_antrean');
        Route::post('taskid_antrean', [AntrianAntrianController::class, 'taskid_antrean'])->name('taskid_antrean');
        Route::get('dashboard_tanggal', [AntrianAntrianController::class, 'dashboard_tanggal'])->name('dashboard_tanggal');
        Route::get('dashboard_bulan', [AntrianAntrianController::class, 'dashboard_bulan'])->name('dashboard_bulan');
        Route::get('antrian_tanggal', [AntrianAntrianController::class, 'antrian_tanggal'])->name('antrian_tanggal');
        Route::get('antrian_kodebooking', [AntrianAntrianController::class, 'antrian_kodebooking'])->name('antrian_kodebooking');
        Route::get('antrian_pendaftaran', [AntrianAntrianController::class, 'antrian_pendaftaran'])->name('antrian_pendaftaran');
        Route::get('antrian_poliklinik', [AntrianAntrianController::class, 'antrian_poliklinik'])->name('antrian_poliklinik');
        // API SIMRS
        Route::get('token', [AntrianAntrianController::class, 'token'])->name('token');
        Route::post('status_antrian', [AntrianAntrianController::class, 'status_antrian'])->name('status_antrian');
        Route::post('ambil_antrian', [AntrianAntrianController::class, 'ambil_antrian'])->name('ambil_antrian');
        Route::post('sisa_antrian', [AntrianAntrianController::class, 'sisa_antrian'])->name('sisa_antrian');
        Route::post('batal_antrian', [AntrianAntrianController::class, 'batal_antrian'])->name('batal_antrian');
        Route::post('checkin_antrian', [AntrianAntrianController::class, 'checkin_antrian'])->name('checkin_antrian');
        Route::post('ambil_antrian_farmasi', [AntrianAntrianController::class, 'ambil_antrian_farmasi'])->name('ambil_antrian_farmasi');
        Route::post('status_antrian_farmasi', [AntrianAntrianController::class, 'status_antrian_farmasi'])->name('status_antrian_farmasi');
        Route::post('info_pasien_baru', [AntrianAntrianController::class, 'info_pasien_baru'])->name('info_pasien_baru');
        Route::post('jadwal_operasi_rs', [AntrianAntrianController::class, 'jadwal_operasi_rs'])->name('jadwal_operasi_rs');
        Route::post('jadwal_operasi_pasien', [AntrianAntrianController::class, 'jadwal_operasi_pasien'])->name('jadwal_operasi_pasien');
    });
    // VCLAIM
    Route::prefix('vclaim')->name('vclaim.')->group(function () {
        // MONITORING
        Route::get('monitoring_data_kunjungan', [VclaimVclaimController::class, 'monitoring_data_kunjungan'])->name('monitoring_data_kunjungan');
        Route::get('monitoring_data_klaim', [VclaimVclaimController::class, 'monitoring_data_klaim'])->name('monitoring_data_klaim');
        Route::get('monitoring_pelayanan_peserta', [VclaimVclaimController::class, 'monitoring_pelayanan_peserta'])->name('monitoring_pelayanan_peserta');
        Route::get('monitoring_klaim_jasaraharja', [VclaimVclaimController::class, 'monitoring_klaim_jasaraharja'])->name('monitoring_klaim_jasaraharja');
        // PESERTA
        Route::get('peserta_nomorkartu', [VclaimVclaimController::class, 'peserta_nomorkartu'])->name('peserta_nomorkartu');
        Route::get('peserta_nik', [VclaimVclaimController::class, 'peserta_nik'])->name('peserta_nik');
        // REFERENSI
        Route::get('ref_diagnosa', [VclaimVclaimController::class, 'ref_diagnosa'])->name('ref_diagnosa');
        Route::get('ref_poliklinik', [VclaimVclaimController::class, 'ref_poliklinik'])->name('ref_poliklinik');
        Route::get('ref_faskes', [VclaimVclaimController::class, 'ref_faskes'])->name('ref_faskes');
        Route::get('ref_dpjp', [VclaimVclaimController::class, 'ref_dpjp'])->name('ref_dpjp');
        Route::get('ref_provinsi', [VclaimVclaimController::class, 'ref_provinsi'])->name('ref_provinsi');
        Route::get('ref_kabupaten', [VclaimVclaimController::class, 'ref_kabupaten'])->name('ref_kabupaten');
        Route::get('ref_kecamatan', [VclaimVclaimController::class, 'ref_kecamatan'])->name('ref_kecamatan');
        // RENCANA KONTROL
        Route::post('suratkontrol_insert', [VclaimVclaimController::class, 'suratkontrol_insert'])->name('suratkontrol_insert');
        // Route::put('suratkontrol_update', [VclaimVclaimController::class, 'suratkontrol_update'])->name('suratkontrol_update');
        Route::delete('suratkontrol_delete', [VclaimVclaimController::class, 'suratkontrol_delete'])->name('suratkontrol_delete');
        // Route::post('spri_insert', [VclaimVclaimController::class, 'spri_insert'])->name('spri_insert');
        // Route::put('spri_update', [VclaimVclaimController::class, 'spri_update'])->name('spri_update');
        // Route::get('suratkontrol_sep', [VclaimVclaimController::class, 'suratkontrol_sep'])->name('suratkontrol_sep');
        Route::get('suratkontrol_nomor', [VclaimVclaimController::class, 'suratkontrol_nomor'])->name('suratkontrol_nomor');
        Route::get('suratkontrol_peserta', [VclaimVclaimController::class, 'suratkontrol_peserta'])->name('suratkontrol_peserta');
        Route::get('suratkontrol_tanggal', [VclaimVclaimController::class, 'suratkontrol_tanggal'])->name('suratkontrol_tanggal');
        Route::get('suratkontrol_poli', [VclaimVclaimController::class, 'suratkontrol_poli'])->name('suratkontrol_poli');
        Route::get('suratkontrol_dokter', [VclaimVclaimController::class, 'suratkontrol_dokter'])->name('suratkontrol_dokter');
        // RUJUKAN
        Route::get('rujukan_nomor', [VclaimVclaimController::class, 'rujukan_nomor'])->name('rujukan_nomor');
        Route::get('rujukan_peserta', [VclaimVclaimController::class, 'rujukan_peserta'])->name('rujukan_peserta');
        Route::get('rujukan_rs_nomor', [VclaimVclaimController::class, 'rujukan_rs_nomor'])->name('rujukan_rs_nomor');
        Route::get('rujukan_rs_peserta', [VclaimVclaimController::class, 'rujukan_rs_peserta'])->name('rujukan_rs_peserta');
        Route::get('rujukan_jumlah_sep', [VclaimVclaimController::class, 'rujukan_jumlah_sep'])->name('rujukan_jumlah_sep');
        // SEP
        Route::get('sep_nomor', [VclaimVclaimController::class, 'sep_nomor'])->name('sep_nomor');
        Route::delete('sep_delete', [VclaimVclaimController::class, 'sep_delete'])->name('sep_delete');
    });
});
// API SATU SEHAT
Route::prefix('satusehat')->name('api.satusehat.')->group(function () {
    Route::get('patient/', [PatientController::class, 'index'])->name('patient_index');
    Route::get('patient/nik/{nik}', [PatientController::class, 'patient_by_nik'])->name('patient_by_nik');
    Route::get('patient/id/{id}', [PatientController::class, 'patient_by_id'])->name('patient_by_id');
    Route::get('patient/name', [PatientController::class, 'patient_by_name'])->name('patient_by_name');

    Route::get('practitioner/', [PractitionerController::class, 'index'])->name('practitioner_index');
    Route::get('practitioner/nik/{nik}', [PractitionerController::class, 'practitioner_by_nik'])->name('practitioner_by_nik');
    Route::get('practitioner/id/{id}', [PractitionerController::class, 'practitioner_by_id'])->name('practitioner_by_id');
    Route::get('practitioner/name', [PractitionerController::class, 'practitioner_by_name'])->name('practitioner_by_name');

    Route::get('organization/', [OrganizationController::class, 'index'])->name('organization_index');
    Route::get('organization/{id}', [OrganizationController::class, 'organization_by_id'])->name('organization_by_id');
    Route::post('organization/store', [OrganizationController::class, 'organization_store_api'])->name('organization_store_api');
    Route::put('organization/update/{id}', [OrganizationController::class, 'organization_update_api'])->name('organization_update_api');

    Route::get('location/', [LocationController::class, 'index'])->name('location_index');
    // Route::get('location/show/{id}', [LocationController::class, 'edit'])->name('location_id');
    Route::post('location/store', [LocationController::class, 'location_store_api'])->name('location_store_api');
    Route::put('location/update/{id}', [LocationController::class, 'location_update_api'])->name('location_update_api');

    Route::get('encounter/', [EncounterController::class, 'index'])->name('encounter_index');
    Route::post('encounter/store', [EncounterController::class, 'encounter_store_api'])->name('encounter_store_api');
});
// PENUNJANG
Route::prefix('penunjang')->name('api.penunjang.')->group(function () {
    Route::get('cari_pasien', [PenunjangController::class, 'cari_pasien'])->name('cari_pasien');
    Route::get('cari_dokter', [PenunjangController::class, 'cari_dokter'])->name('cari_dokter');
    Route::get('get_tarif_laboratorium', [PenunjangController::class, 'get_tarif_laboratorium'])->name('get_tarif_laboratorium');
    Route::get('get_order_layanan', [PenunjangController::class, 'get_order_layanan'])->name('get_order_layanan');
    Route::get('get_kunjungan_pasien', [PenunjangController::class, 'get_kunjungan_pasien'])->name('get_kunjungan_pasien');
    Route::get('get_ris_order', [PenunjangController::class, 'get_ris_order'])->name('get_ris_order');
    Route::post('insert_layanan', [PenunjangController::class, 'insert_layanan'])->name('insert_layanan');
});
// RIS
Route::prefix('ris')->name('api.ris.')->group(function () {
    Route::get('pasien_get', [RISController::class, 'pasien_get'])->name('pasien_get');
    Route::post('pasien_add', [RISController::class, 'pasien_add'])->name('pasien_add');
    Route::get('dokter_get', [RISController::class, 'dokter_get'])->name('dokter_get');
    Route::get('asuransi_get', [RISController::class, 'asuransi_get'])->name('asuransi_get');
    Route::get('jenispemeriksaan_get', [RISController::class, 'jenispemeriksaan_get'])->name('jenispemeriksaan_get');
    Route::get('ruangan_get', [RISController::class, 'ruangan_get'])->name('ruangan_get');
    Route::get('order_get', [RISController::class, 'order_get'])->name('order_get');
});
// INACBG
Route::prefix('eclaim')->name('api.eclaim.')->group(function () {
    Route::get('search_diagnosis', [InacbgController::class, 'search_diagnosis'])->name('search_diagnosis');
    Route::get('search_procedures', [InacbgController::class, 'search_procedures'])->name('search_procedures');
    Route::get('search_diagnosis_inagrouper', [InacbgController::class, 'search_diagnosis_inagrouper'])->name('search_diagnosis_inagrouper');
    Route::get('search_procedures_inagrouper', [InacbgController::class, 'search_procedures_inagrouper'])->name('search_procedures_inagrouper');
    Route::post('new_claim', [InacbgController::class, 'new_claim'])->name('new_claim');
    Route::post('set_claim', [InacbgController::class, 'set_claim'])->name('set_claim');
    Route::post('set_claim_rajal', [InacbgController::class, 'set_claim_rajal'])->name('set_claim_rajal');
    Route::post('grouper', [InacbgController::class, 'grouper'])->name('grouper');
    Route::post('get_claim_data', [InacbgController::class, 'get_claim_data'])->name('get_claim_data');
    Route::post('get_claim_status', [InacbgController::class, 'get_claim_status'])->name('get_claim_status');



});
