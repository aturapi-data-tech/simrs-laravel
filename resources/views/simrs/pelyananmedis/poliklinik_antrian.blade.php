@extends('adminlte::page')
@section('title', 'Poliklinik - Antrian BPJS')
@section('content_header')
    <h1 class="m-0 text-dark">Poliklinik Antrian BPJS</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card title="Referensi Poliklinik Antrian BPJS" theme="secondary" collapsible>
                @php
                    $heads = ['No', 'Nama Subspesialis', 'Kode Subspesialis', 'Nama Poli', 'Kode Poli', 'Action'];
                @endphp
                <x-adminlte-datatable id="table1" class="text-xs" :heads="$heads" hoverable bordered compressed>
                    @foreach ($polikliniks as $poliklinik)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $poliklinik->namaSubspesialis }}</td>
                            <td>{{ $poliklinik->kodeSubspesialis }}</td>
                            <td>{{ $poliklinik->namaPoli }}</td>
                            <td>{{ $poliklinik->kodePoli }}</td>
                            <td></td>
                        </tr>
                    @endforeach
                </x-adminlte-datatable>
                <a href="{{ route('pelayanan-medis.poliklinik_antrian_refresh') }}" class="btn btn-success">Refresh
                    Poliklinik</a>
            </x-adminlte-card>
        </div>
    </div>
@stop

@section('plugins.Datatables', true)