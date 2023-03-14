@extends('adminlte::print')
@section('title', 'Disposisi ' . $surat->asal_surat)
@section('content_header')
    <h1>Disposisi {{ $surat->asal_surat }}</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div id="printMe">
                <section class="invoice p-3 mb-1">
                    <div class="row">
                        <img src="{{ asset('vendor/adminlte/dist/img/rswaledico.png') }}" style="width: 100px">
                        <div class="col">
                            <b>RUMAH SAKIT UMUM DAERAH WALED KABUPATEN CIREBON</b><br>
                            Jl. Prabu Kiansantang No.4 Desa Waled Kota Kec. Waled Kab. Cirebon 45187
                            <br>
                            www.rsudwaled.id - brsud.waled@gmail.com - Whatasapp 0895 4000 60700 - Call Center (0231) 661126
                        </div>
                        <hr width="100%" hight="20px" class="m-1 " color="black" size="50px" />
                    </div>
                    <div class="row invoice-info">
                        <div class="col-sm-12 invoice-col text-center">
                            <b class="text-xl">LEMBAR DISPOSISI</b> <br>
                            <br>
                        </div>
                        {{-- <div class="col-sm-6 invoice-col">
                            <dl class="row">
                                <dt class="col-sm-4 m-0">Surat Dari </dt>
                                <dd class="col-sm-8 m-0">: </b></dd>
                                <dt class="col-sm-4 m-0">No Surat </dt>
                                <dd class="col-sm-8 m-0">: </b></dd>
                                <dt class="col-sm-4 m-0">Tanggal Surat </dt>
                                <dd class="col-sm-8 m-0">: </b></dd>
                            </dl>

                        </div>
                        <div class="col-sm-6 invoice-col">
                            <dl class="row">
                                <dt class="col-sm-4 m-0">Diterima Tgl. </dt>
                                <dd class="col-sm-8 m-0">: </b></dd>
                                <dt class="col-sm-4 m-0">No. Agenda</dt>
                                <dd class="col-sm-8 m-0">: </b></dd>
                                <dt class="col-sm-4 m-0">Sifat </dt>
                                <dd class="col-sm-8 m-0">: </b></dd>
                            </dl>
                        </div> --}}
                    </div>

                    <div class="col-12 table-responsive">
                        <table class="table table-sm">
                            <tbody>
                                <tr>
                                    <td style="width: 450px">
                                        <dl class="row">
                                            <dt class="col-sm-4 ">Surat Dari </dt>
                                            <dd class="col-sm-8 ">: {{ $surat->asal_surat }}</b></dd>
                                            <dt class="col-sm-4 ">No Surat </dt>
                                            <dd class="col-sm-8 ">: {{ $surat->no_surat }}</b></dd>
                                            <dt class="col-sm-4 ">Tanggal Surat </dt>
                                            <dd class="col-sm-8 ">:
                                                {{ Carbon\Carbon::parse($surat->tgl_surat)->translatedFormat('l, d F Y') }}</b>
                                            </dd>
                                        </dl>
                                    </td>
                                    <td>
                                        <dl class="row">
                                            <dt class="col-sm-4 ">Diterima Tgl. </dt>
                                            <dd class="col-sm-8 ">:
                                                {{ Carbon\Carbon::parse($surat->tgl_input)->translatedFormat('l, d F Y') }}
                                                </b></dd>
                                            <dt class="col-sm-4 ">No. Agenda</dt>
                                            <dd class="col-sm-8 ">: {{ $surat->no_urut }}</dd>
                                        </dl>
                                        <div class="row">
                                            <dt class="col-sm-4 ">Sifat </dt>
                                            <dd class="col-sm-8 ">: </b></dd>
                                            <div class="col-md-4">
                                                <input type="checkbox">
                                                Sangat Segera
                                                {{-- <label>
                                                    Sangat Segera
                                                </label> --}}
                                            </div>
                                            <div class="col-md-4">
                                                <input type="checkbox">
                                                Segera
                                                {{-- <label>
                                                    Segera
                                                </label> --}}
                                            </div>
                                            <div class="col-md-4">
                                                <input type="checkbox">
                                                Rahasia
                                                {{-- <label>
                                                    Rahasia
                                                </label> --}}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="height: 100px"><b>Hal : </b>
                                        <br>
                                        {{ $surat->perihal }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Diteruskan kepada Sdr. : </b></td>
                                    <td><b>Dengan harap hormat : </b></td>
                                </tr>
                                <tr>
                                    <td rowspan="2" style="vertical-align:bottom;">
                                        {{ $surat->pengolah }} <br>
                                    </td>
                                    <td>
                                        <div>
                                            <input type="checkbox">
                                            Untuk ditindaklanjuti
                                            {{-- <label>
                                                Untuk ditindaklanjuti
                                            </label> --}}
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div>
                                            <input type="checkbox">
                                            Proses sesuai ketentuan / peraturan yang berlaku
                                            {{-- <label>
                                                Proses sesuai ketentuan / peraturan yang berlaku
                                            </label> --}}
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td rowspan="2" style="vertical-align:bottom;">
                                        .........................................................</td>
                                    <td>
                                        <div>
                                            <input type="checkbox">
                                            Koordinasikan / konfirmasi dengan ybs / instansi terkait
                                            {{-- <label>
                                                Koordinasikan / konfirmasi dengan ybs / instansi terkait
                                            </label> --}}
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div>
                                            <input type="checkbox">
                                            Untuk dibantu / difasilitasi / dipenuhi sesuai kebutuhan
                                            {{-- <label>
                                                Untuk dibantu / difasilitasi / dipenuhi sesuai kebutuhan
                                            </label> --}}
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td rowspan="2" style="vertical-align:bottom;">
                                        .........................................................</td>
                                    <td>
                                        <div>
                                            <input type="checkbox">
                                            Pelajari / telaah / sarannya
                                            {{-- <label>
                                                Pelajari / telaah / sarannya
                                            </label> --}}
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div>
                                            <input type="checkbox">
                                            Wakili / hadiri / terima / laporkan hasilnya
                                            {{-- <label>
                                                Wakili / hadiri / terima / laporkan hasilnya
                                            </label> --}}
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td rowspan="2" style="vertical-align:bottom;">
                                        .........................................................</td>
                                    <td>
                                        <div>
                                            <input type="checkbox">
                                            Agendakan / persiapkan / koordinasikan
                                            {{-- <label>
                                                Agendakan / persiapkan / koordinasikan
                                            </label> --}}
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div>
                                            <input type="checkbox">
                                            Jadwalkan ingatkan waktunya

                                            {{-- <label>
                                                Jadwalkan ingatkan waktunya
                                            </label> --}}
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td rowspan="2" style="vertical-align:bottom;">
                                        .........................................................</td>
                                    <td>
                                        <div>
                                            <input type="checkbox">
                                            Siapkan pointer / sambutan / bahan
                                            {{-- <label>
                                                Siapkan pointer / sambutan / bahan
                                            </label> --}}
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div>
                                            <input type="checkbox">
                                            <label>
                                                ..........................................
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2"><b>Catatan : </b><br><br><br><br><br><br><br><br></td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <div class="row">
                                            <div class="col-md-6 text-center">

                                            </div>
                                            <div class="col-md-6 text-center">
                                                <b>Penerima Surat</b>
                                                <br>{{ Carbon\Carbon::parse($surat->tgl_terima_surat)->translatedFormat('l, d F Y') }}
                                                <br><br><br>
                                                {{ $surat->tanda_terima }}
                                                <br>
                                                <br>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="footer-space">&nbsp;</div>
                    <div class="footer">SIPAS RSUD WALED V.2</div>
                </section>
            </div>
            <button class="btn btn-success btnPrint" onclick="printDiv('printMe')"><i class="fas fa-print"> Print
                    Laporan</i>
        </div>
    </div>
@stop

@section('plugins.Datatables', true)
@section('plugins.DateRangePicker', true)
@section('plugins.Select2', true)
@section('css')
    <style type="text/css" media="print">
        hr {
            color: #333333 !important;
            border: 1px solid #333333 !important;
            line-height: 1.5;
        }

        .main-footer {
            display: none !important;
        }

        .btnPrint {
            display: none !important;
        }

        .footer {
            position: fixed;
            bottom: 0;
        }

        .footer-space {
            height: 100px;
        }
    </style>
    <style type="text/css">
        hr {
            color: #333333 !important;
            border: 1px solid #333333 !important;
            line-height: 1.5;
        }

        table,
        th,
        td {
            border: 1px solid #333333 !important;
            font-size: 15px !important;
            padding: 3px !important;
        }
    </style>

@endsection
@section('js')
    <script>
        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
            tampilan_print = document.body.innerHTML = printContents;
            setTimeout('window.addEventListener("load", window.print());', 1000);
        }
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            window.print();
        });
    </script>
@endsection
