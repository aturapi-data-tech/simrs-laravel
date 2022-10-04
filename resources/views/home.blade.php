@extends('adminlte::page')

@section('title', 'SIM RSUD Waled')

@section('content_header')
    <h1 class="m-0 text-dark">Dashboard</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <p class="mb-0">You are logged in!</p>
                </div>
            </div>
            <div class="row">
                {{-- <div class="col-md-3">
                    <x-adminlte-small-box title="{{ $peserta->metaData->code == 200 ? 'ON' : 'OFF' }}"
                        text="Bridging Vclaim BPJS" theme="{{ $peserta->metaData->code == 200 ? 'success' : 'danger' }}"
                        icon="fas {{ $peserta->metaData->code == 200 ? 'fa-check' : 'fa-times' }}" />
                </div> --}}
                {{-- <div class="col-md-3">
                    <x-adminlte-small-box title="{{ $poli->metadata->code == 1 ? 'ON' : 'OFF' }}"
                        text="Bridging Antrian BPJS" theme="{{ $poli->metadata->code == 1 ? 'success' : 'danger' }}"
                        icon="fas {{ $poli->metadata->code == 1 ? 'fa-check' : 'fa-times' }}" />
                </div> --}}
                {{-- <div class="col-md-3">
                    <x-adminlte-small-box title="{{ $kunjungans->count() }}" text="Total Kunjungan Pasien" theme="warning"
                        icon="fas fa-users" />
                </div>
                <div class="col-md-3">
                    <x-adminlte-small-box title="{{ round(($antrians->count() / $kunjungans->count()) * 100) }} % "
                        text="Persentase Pemutakhir Data" theme="primary" icon="fas fa-users" />
                </div> --}}
            </div>
        </div>
    </div>
@stop
