@extends('adminlte::master')

@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')

@section('title', 'Antrian QR Code')
@section('body')
    <div class="wrapper">
        <div class="row p-1">
            {{-- checkin --}}
            <div class="col-md-5">
                <x-adminlte-card title="Anjungan Checkin Antrian RSUD Waled" theme="primary" icon="fas fa-qrcode">
                    <div class="text-center">
                        <x-adminlte-input name="kodebooking" label="Silahkan scan QR Code Antrian atau masukan Kode Antrian"
                            placeholder="Masukan Kode Antrian untuk Checkin" igroup-size="lg">
                            <x-slot name="appendSlot">
                                <x-adminlte-button name="btn_checkin" id="btn_checkin" theme="success" label="Checkin!" />
                            </x-slot>
                            <x-slot name="prependSlot">
                                <div class="input-group-text text-success">
                                    <i class="fas fa-qrcode"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                        <i class="fas fa-qrcode fa-3x"></i>
                        <br>
                        <label>Status = <span id="status">-</span></label>
                    </div>
                </x-adminlte-card>
                <div class="row">
                    <div class="col-md-6">
                        <x-adminlte-info-box class="btnDaftarBPJS" text="Daftar Pasien BPJS" theme="success" />
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-info-box class="btnDaftarUmum" text="Daftar Pasien Umum" theme="success" />
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-button icon="fas fa-sync" class="withLoad reload" theme="warning" label="Reload" />
                        <a href="{{ route('antrian.cek_post') }}" class="btn btn-warning">Test Printer</a>
                    </div>
                </div>
            </div>
            {{-- ambil antrian offline --}}
            <div class="col-md-7">
                <p hidden>{{ setlocale(LC_ALL, 'IND') }}</p>
                <x-adminlte-card
                    title="Jadwal Dokter Poliklinik {{ \Carbon\Carbon::now()->formatLocalized('%A, %d %B %Y') }}"
                    theme="primary" icon="fas fa-qrcode">
                    <div class="row">
                        <div class="col-md-12">
                            @php
                                $heads = ['Poliklinik', 'Dokter', 'Jadwal', 'Kuota', 'Antrian'];
                                $config['order'] = ['5', 'asc'];
                            @endphp
                            <x-adminlte-datatable id="table1" class="nowrap text-xs" :heads="$heads" :config="$config"
                                striped bordered hoverable compressed>
                                @foreach ($poliklinik as $poli)
                                    @foreach ($poli->jadwals->where('hari', \Carbon\Carbon::now()->dayOfWeek)->where('kodesubspesialis', $poli->kodesubspesialis) as $jadwal)
                                        <tr
                                            class="text-left
                                            {{ $jadwal->libur == 1 ||$poli->antrians->where('tanggalperiksa', \Carbon\Carbon::now()->format('Y-m-d'))->where('taskid', '!=', 99)->where('kodedokter', $jadwal->kodedokter)->count() >= $jadwal->kapasitaspasien? ' text-danger': ' text-black' }}
                                           ">
                                            <td> {{ strtoupper($jadwal->namasubspesialis) }}</td>
                                            <td> {{ $jadwal->namadokter }} {{ $jadwal->libur ? '(TUTUP)' : '' }}</td>
                                            <td> {{ $jadwal->jadwal }}</td>
                                            <td> {{ $jadwal->kapasitaspasien }}</td>
                                            <td> {{ $poli->antrians->where('tanggalperiksa', \Carbon\Carbon::now()->format('Y-m-d'))->where('kodedokter', $jadwal->kodedokter)->where('taskid', '!=', 99)->count() }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </x-adminlte-datatable>
                        </div>
                        {{-- @foreach ($poliklinik as $poli)
                                <div class="col-md-3">
                                    <x-adminlte-info-box
                                        text="{{ $poli->antrians->where('tanggalperiksa', \Carbon\Carbon::now()->format('Y-m-d'))->where('taskid', '!=', 99)->count() }} / {{ $poli->jadwals->where('hari', \Carbon\Carbon::now()->dayOfWeek)->where('kodesubspesialis', $poli->kodesubspesialis)->sum('kapasitaspasien') }}"
                                        title="{{ $poli->namasubspesialis }} " class="tombolPoli"
                                        data-id="{{ $poli->kodesubspesialis }}"
                                        theme="{{ $poli->antrians->where('tanggalperiksa', \Carbon\Carbon::now()->format('Y-m-d'))->count() >=$poli->jadwals->where('hari', \Carbon\Carbon::now()->dayOfWeek)->where('kodesubspesialis', $poli->kodesubspesialis)->sum('kapasitaspasien')? 'danger': 'success' }}" />
                                </div>
                            @endforeach --}}
                    </div>
                </x-adminlte-card>
            </div>
        </div>
    </div>
    {{-- Daftar Pasien BPJS --}}
    <x-adminlte-modal id="modalBPJS" size="xl" title="Daftar Antrian Pasien BPJS" theme="success"
        icon="fas fa-user-plus">
        <div id="inputKartu">
            <x-adminlte-input name="nomorkartu" id="nomorkartu" label="Masukan Nomor BPJS Pasien"
                placeholder="Masukan Nomor BPJS Peserta" igroup-size="lg">
                <x-slot name="prependSlot">
                    <div class="input-group-text text-success">
                        <i class="fas fa-user"></i>
                    </div>
                </x-slot>
            </x-adminlte-input>
        </div>
        <div id="inputNIK">
            <x-adminlte-input name="nik" id="nik" label="Masukan NIK Pasien" placeholder="Masukan NIK Peserta"
                igroup-size="lg">
                <x-slot name="prependSlot">
                    <div class="input-group-text text-success">
                        <i class="fas fa-user"></i>
                    </div>
                </x-slot>
            </x-adminlte-input>
        </div>

        <br>
        <div class="form-group">
            <label>Silahkan pilih poliklinik BPJS di bawah ini</label>
            <div class="row">
                @foreach ($poliklinik as $item)
                    <div class="col-md-4">
                        <div class="custom-control custom-radio " style="scale: 100%">
                            <input class="custom-control-input btnPoliBPJS" type="radio"
                                data-id="{{ $item->kodesubspesialis }}" id="{{ $item->namasubspesialis }}"
                                value="{{ $item->kodesubspesialis }}" name="kodesubspesialis">
                            <label for="{{ $item->namasubspesialis }}" class="custom-control-label"
                                data-id="{{ $item->kodesubspesialis }}">{{ $item->namasubspesialis }} </label>
                        </div>
                    </div>
                    {{-- <x-adminlte-button class="btnPoliBPJS btn-lg m-2" theme="warning" label="{{ $item->namasubspesialis }}"
                    data-id="{{ $item->kodesubspesialis }}" /> --}}
                    {{-- <div class="form-check">
                    <input class="form-check-input" type="radio" name="flexRadioDefault"
                        id="{{ $item->namasubspesialis }}">
                    <label class="form-check-label" for="{{ $item->namasubspesialis }}">
                        Default radio
                    </label>
                </div> --}}
                @endforeach
            </div>
        </div>
        <br>
        <div class="form-group" id="daftarDokter">
            <label>Silahkan pilih dokter poliklinik di bawah ini</label>
            <div id="rowDokter"></div>
        </div>
        <x-slot name="footerSlot">
            <x-adminlte-button class="mr-auto withLoad" type="submit" theme="success" id="btnDaftarPoliBPJS"
                icon="fas fa-user-plus" label="Daftar BPJS" />
            <x-adminlte-button class="mr-auto withLoad" type="submit" theme="success" id="btnDaftarPoliUmum"
                icon="fas fa-user-plus" label="Daftar Umum" />
            {{-- <button type="submit" class="mr-auto btn btn-success" form="daftarbpjseiu">DAFTAR</button> --}}
            <x-adminlte-button theme="secondary" icon="fas fa-times" label="Kembali" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
@stop
@section('plugins.Sweetalert2', true)
{{-- @section('plugins.Datatables', true) --}}
@include('sweetalert::alert')
@section('adminlte_css')
    {{-- <script src="{{ asset('vendor/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}"></script> --}}
@endsection
@section('adminlte_js')
    <script src="{{ asset('vendor/moment/moment.min.js') }}"></script>
    <script src="{{ asset('vendor/loading-overlay/loadingoverlay.min.js') }}"></script>
    <script src="{{ asset('vendor/onscan.js/onscan.min.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.all.min.js') }}"></script>
    {{-- scan --}}
    {{-- <script>
        $(function() {
            onScan.attachTo(document, {
                onScan: function(sCode, iQty) {
                    $.LoadingOverlay("show", {
                        text: "Printing..."
                    });
                    var url = "{{ route('antrian.checkin_update') }}";
                    var formData = {
                        kodebooking: sCode,
                        waktu: "{{ \Carbon\Carbon::now()->timestamp * 1000 }}",
                    };
                    $('#kodebooking').val(sCode);
                    $.get(url, formData, function(data) {
                        console.log(data);
                        $.LoadingOverlay("hide");
                        if (data.metadata.code == 200) {
                            $('#status').html(data.metadata.message);
                            swal.fire(
                                'Sukses...',
                                data.metadata.message,
                                'success'
                            ).then(okay => {
                                if (okay) {
                                    $.LoadingOverlay("show", {
                                        text: "Reload..."
                                    });
                                    $('#status').html('-');
                                    location.reload();
                                }
                            });
                        } else {
                            $('#status').html(data.metadata.message);
                            swal.fire(
                                'Opss Error...',
                                data.metadata.message,
                                'error'
                            ).then(okay => {
                                if (okay) {
                                    $.LoadingOverlay("show", {
                                        text: "Reload..."
                                    });
                                    $('#status').html('-');
                                    location.reload();
                                }
                            });
                        }
                    });
                },
            });
        });
    </script> --}}
    {{-- btn chekin --}}
    <script>
        $(function() {
            $('#btn_checkin').click(function() {
                var kodebooking = $('#kodebooking').val();
                $.LoadingOverlay("show", {
                    text: "Printing..."
                });
                var url = "{{ route('antrian.checkin_update') }}";
                var formData = {
                    kodebooking: kodebooking,
                    waktu: "{{ \Carbon\Carbon::now()->timestamp * 1000 }}",
                };
                $('#kodebooking').val(kodebooking);
                $.get(url, formData, function(data) {
                    console.log(data);
                    $.LoadingOverlay("hide");
                    if (data.metadata.code == 200) {
                        $('#status').html(data.metadata.message);
                        swal.fire(
                            'Sukses...',
                            data.metadata.message,
                            'success'
                        ).then(okay => {
                            if (okay) {
                                $.LoadingOverlay("show", {
                                    text: "Reload..."
                                });
                                $('#status').html('-');
                                location.reload();
                            }
                        });
                    } else {
                        $('#status').html(data.metadata.message);
                        swal.fire(
                            'Opss Error...',
                            data.metadata.message,
                            'error'
                        ).then(okay => {
                            if (okay) {
                                $.LoadingOverlay("show", {
                                    text: "Reload..."
                                });
                                $('#status').html('-');
                                location.reload();
                            }
                        });
                    }
                });
            });
        });
    </script>
    {{-- btn daftar --}}
    <script>
        $(function() {
            $(document).ready(function() {
                $('#daftarDokter').hide();
                setTimeout(function() {
                    $('#kodebooking').focus();
                }, 500);
            });
            $('.btnDaftarBPJS').click(function() {
                $('#modalBPJS').modal('show');
                $('#inputNIK').show();
                $('#btnDaftarPoliUmum').hide();
                $('#btnDaftarPoliBPJS').show();
                $('#inputKartu').show();
                setTimeout(function() {
                    $('#nomorkartu').focus();
                }, 500);

            });
            $('.btnDaftarUmum').click(function() {
                $('#modalBPJS').modal('show');
                $('#inputNIK').show();
                $('#inputKartu').hide();
                $('#btnDaftarPoliUmum').show();
                $('#btnDaftarPoliBPJS').hide();
                setTimeout(function() {
                    $('#nik').focus();
                }, 500);

            });
            $('.btnPoliBPJS').click(function() {
                $('div#rowDokter').children().remove();
                var id = $(this).data('id');
                var hari = "{{ now()->dayOfWeek }}"
                $.LoadingOverlay("show");
                var url = "{{ route('antrian.jadwaldokter_poli') }}/?kodesubspesialis=" + id + "&hari=" +
                    hari;
                $.get(url, function(data) {
                    $('#daftarDokter').show();
                    $.each(data, function(i, item) {
                        console.log(item.kodedokter);
                        var bigString = [
                            '<div class="custom-control custom-radio " >',
                            '<input class="custom-control-input btnPoliBPJS" type="radio"',
                            'data-id="' + item.kodedokter + '" id="' + item.kodedokter +
                            '"',
                            'value="' + item.kodedokter + '" name="kodedokter">',
                            '<label for="' + item.kodedokter +
                            '" class="custom-control-label"',
                            'data-id="' + item.kodedokter + '">' + item.namadokter +
                            ' </label>',
                            ' </div>',
                        ];
                        $('#rowDokter').append(bigString.join(''));
                    });
                    $.LoadingOverlay("hide", true);
                });
            });
            $('#btnDaftarPoliBPJS').click(function() {
                var nomorkartu = $('#nomorkartu').val();
                var nik = $('#nik').val();
                var kodesubspesialis = $("input[name=kodesubspesialis]:checked").val();
                var kodedokter = $("input[name=kodedokter]:checked").val();
                var url = "{{ route('antrian.daftar_pasien_bpjs_offline') }}" + "?nomorkartu=" +
                    nomorkartu + "&kodesubspesialis=" + kodesubspesialis + "&kodedokter=" + kodedokter+"&nik=" + nik;
                window.location.href = url;
            });
            $('#btnDaftarPoliUmum').click(function() {
                var nik = $('#nik').val();
                var kodesubspesialis = $("input[name=kodesubspesialis]:checked").val();
                var kodedokter = $("input[name=kodedokter]:checked").val();
                var url = "{{ route('antrian.daftar_pasien_umum_offline') }}" + "?nik=" +
                    nik + "&kodesubspesialis=" + kodesubspesialis + "&kodedokter=" + kodedokter;
                window.location.href = url;
            });

        });
    </script>
    <script>
        $(function() {
            $('.kodedokter').hide();
            $('.datapasien').hide();
            $('.nik').hide();
            $('.nomorkartu').hide();
            $('.nama').hide();
            $('.norm').hide();
            $('.nohp').hide();
            $('#btnSubmitDaftar').hide();
            $('.nomorreferensi').hide();
            $('#pilihkodepoli').change(function() {
                var tanggalperiksa = $('#tanggalperiksa').val();
                var kodepoli = $('#pilihkodepoli').find('option:selected').val();
                $('#kodepoli').val(kodepoli);
                if (kodepoli != 0) {
                    var url =
                        "{{ route('antrian.index') }}" + "/console_jadwaldokter/" + kodepoli +
                        "/" + tanggalperiksa;
                    $.LoadingOverlay("show");
                    $.get(url, function(data) {
                        $('#kodedokter').find('option').remove();
                        $('.kodedokter').show();
                        if (data.length != 0) {
                            $('#kodedokter').append($(
                                "<option value='0'>PILIH DOKTER</option>"));
                            $.each(data, function(value) {
                                if (data[value].libur == "1") {
                                    var libur = "LIBUR " +
                                        data[value].jadwal;
                                    var disablee = "disabled";
                                } else {
                                    var libur = "" +
                                        data[value].jadwal;
                                    var disablee = "";
                                }
                                $('#kodedokter').append($(
                                    "<option value='" + data[value].kodedokter +
                                    "' " + disablee + " > " + libur +
                                    " " + data[value]
                                    .namadokter + "</option>"));
                                $.LoadingOverlay("hide", true);
                            });
                        } else {
                            $.LoadingOverlay("hide", true);
                            swal.fire(
                                'Error',
                                "Tidak Ada Jadwal Dokter Poliklinik " + kodepoli +
                                " di Tanggal " +
                                tanggalperiksa,
                                'error'
                            );
                        }
                    }).fail(function(error) {
                        alert(error);
                    });
                } else {
                    $('#kodedokter').find('option').remove();
                    $('.kodedokter').hide();
                }
            });
            $('#kodedokter').change(function() {
                var tanggalperiksa = $('#tanggalperiksa').val();
                var kodepoli = $('#kodepoli').val();
                $('#pilihkodepoli').prop('disabled', 'disabled');
                var kodedokter = $('#kodedokter').find('option:selected').val();
                if (kodedokter != 0) {
                    var url = "{{ route('api.status_antrean') }}";
                    var formData = {
                        tanggalperiksa: tanggalperiksa,
                        kodepoli: kodepoli,
                        kodedokter: kodedokter,
                    };
                    $.LoadingOverlay("show");
                    $.get(url, formData, function(data) {
                        $.LoadingOverlay("hide");
                        if (data.metadata.code == 200) {
                            if (data.response.sisaantrean <= 0) {
                                $.LoadingOverlay("hide");
                                $('.datapasien').hide();
                                swal.fire(
                                    'Error',
                                    "Mohon maaf kuota jadwal dokter sudah penuh",
                                    'error'
                                );
                            } else {
                                $.LoadingOverlay("hide");
                                $('.datapasien').show();
                                swal.fire(
                                    'Success',
                                    "Dokter " + kodedokter + " telah dipilih. Sisa kuota " +
                                    data
                                    .response
                                    .sisaantrean + " pasien.",
                                    'success'
                                );
                            }

                        } else {
                            $.LoadingOverlay("hide");
                            swal.fire(
                                'Error',
                                data.metadata.message,
                                'error'
                            );
                        }
                    }).fail(function(error) {
                        alert(error);
                    });
                } else {
                    $('.datapasien').hide();
                }
            });
            $('#pilihjeniskunjungan').change(function() {
                var jeniskunjungan = $('#pilihjeniskunjungan').find('option:selected').val();
                $('#jeniskunjungan').val(jeniskunjungan);
                if (1 >= jeniskunjungan <= 4) {
                    $('.nik').hide();
                    $('.nomorkartu').show();
                }
                if (jeniskunjungan == 5) {
                    $('.nik').show();
                    $('.nomorkartu').hide();
                }
                if (jeniskunjungan == 0) {
                    $('.nik').hide();
                    $('.nomorkartu').hide();
                }
            });
            $('#btn_check_nomorkartu').click(function() {
                var nomorkartu = $('#nomorkartu').val();
                var jeniskunjungan = $('#jeniskunjungan').val();
                var tanggalperiksa = $('#tanggalperiksa').val();
                $('#pilihjeniskunjungan').prop('disabled', 'disabled');
                var url = "{{ route('api.cek_nomorkartu') }}";
                $.LoadingOverlay("show");
                var formData = {
                    nomorkartu: nomorkartu,
                };
                $.get(url, formData, function(data) {
                    if (data.metaData.code == 200) {
                        $('#nik').val(data.response.peserta
                            .nik).attr('readonly', true);
                        $('#nama').val(data.response.peserta
                            .nama).attr('readonly', true);
                        $('#norm').val(data.response.peserta
                            .mr.noMR).attr('readonly', true);
                        $('#nohp').val(data.response.peserta
                            .mr.noTelepon);
                        $('#nomorkartu').attr('readonly', true);
                        $('.nik').show();
                        $('.nama').show();
                        $('.norm').show();
                        $('.nohp').show();
                        if (jeniskunjungan == 1) {
                            var url = "{{ route('api.rujukan_peserta') }}";
                            var formData = {
                                nomorkartu: nomorkartu,
                            };
                            $('#nomorreferensi').find('option')
                                .remove();
                            $('#nomorreferensi').append($(
                                "<option value='0' selected>PILIH NOMOR REFERENSI</option>"
                            ));
                            $.get(url, formData, function(rujukan) {
                                if (rujukan.metaData.code == 200) {
                                    $.each(rujukan.response.rujukan, function(value) {
                                        var tanggalkunjungan = rujukan.response
                                            .rujukan[value].tglKunjungan;
                                        var date3bulan = moment(tanggalkunjungan,
                                                "YYYY-MM-DD").add(3, 'months')
                                            .format('YYYY-MM-DD');
                                        var today = moment().format('YYYY-MM-DD');
                                        if (date3bulan > today) {
                                            var time = "";
                                            var disablee = "";
                                        } else {
                                            var time = "EXPIRED ";
                                            var disablee = "disabled";
                                        }
                                        $('#nomorreferensi').append($(
                                            "<option value='" + rujukan
                                            .response.rujukan[
                                                value].noKunjungan + "' " +
                                            disablee + " >" + time +
                                            rujukan
                                            .response.rujukan[
                                                value].noKunjungan + " " +
                                            rujukan
                                            .response.rujukan[
                                                value].pelayanan.nama +
                                            " POLI " +
                                            rujukan
                                            .response.rujukan[
                                                value].poliRujukan.nama +
                                            "</option>"
                                        ));
                                    });
                                    $('.nomorreferensi').show();
                                    $.LoadingOverlay("hide");
                                    swal.fire(
                                        'Success',
                                        "Nomor Kartu " + nomorkartu + " Atas Nama " +
                                        data
                                        .response.peserta.nama +
                                        " Data Rujukan Ditemukan",
                                        'success'
                                    );
                                } else {
                                    $.LoadingOverlay("hide");
                                    swal.fire(
                                        'Error',
                                        data.metaData.message,
                                        'error'
                                    );
                                }
                            }).fail(function(error) {
                                alert(error);
                            });
                        }
                        if (jeniskunjungan == 2) {
                            alert('2')
                            $.LoadingOverlay("hide");
                        }
                        if (jeniskunjungan == 3) {
                            var url = "{{ route('api.surat_kontrol_peserta') }}";
                            var formData = {
                                nomorkartu: nomorkartu,
                                tanggalperiksa: tanggalperiksa,
                                formatfilter: 2,
                            };
                            $('#nomorreferensi').find('option')
                                .remove();
                            $('#nomorreferensi').append($(
                                "<option value='0' selected>PILIH NOMOR REFERENSI</option>"
                            ));
                            $.get(url, formData, function(suratkontrols) {
                                if (suratkontrols.metaData.code == 200) {
                                    $.each(suratkontrols.response.list, function(value) {
                                        console.log(suratkontrols);
                                        $('#nomorreferensi').append($(
                                            "<option value='" +
                                            suratkontrols
                                            .response.list[
                                                value].noSuratKontrol +
                                            "' >" +
                                            suratkontrols
                                            .response.list[
                                                value].noSuratKontrol +
                                            " " +
                                            suratkontrols
                                            .response.list[
                                                value].tglRencanaKontrol +
                                            " POLI " +
                                            suratkontrols
                                            .response.list[
                                                value].namaPoliTujuan +
                                            " " + suratkontrols
                                            .response.list[
                                                value].namaDokter +
                                            "</option>"
                                        ));
                                    });
                                    $('.nomorreferensi').show();
                                    $.LoadingOverlay("hide");
                                    swal.fire(
                                        'Success',
                                        "Nomor Kartu " + nomorkartu + " Atas Nama " +
                                        data
                                        .response.peserta.nama +
                                        " Data Surat Kontrol Ditemukan",
                                        'success'
                                    );
                                } else {
                                    $('.nomorreferensi').hide();
                                    $.LoadingOverlay("hide");
                                    swal.fire(
                                        'Error (3)',
                                        suratkontrols.metaData.message,
                                        'error'
                                    );
                                }
                            }).fail(function(error) {
                                alert(error);
                            });
                        }
                        if (jeniskunjungan == 4) {
                            alert('4')
                            $.LoadingOverlay("hide");
                        }
                    } else {
                        $.LoadingOverlay("hide");
                        swal.fire(
                            'Error',
                            data.metaData.message,
                            'error'
                        );
                    }
                }).fail(function(error) {
                    alert(error);
                });
            });
            $('#btn_check_nik').click(function() {
                var nik = $('#nik').val();
                var url = "{{ route('api.cek_nik') }}";
                $('#pilihjeniskunjungan').prop('disabled', 'disabled');
                $.LoadingOverlay("show");
                var formData = {
                    nik: nik,
                };
                $.get(url, formData, function(data) {
                    if (data.metaData.code == 200) {
                        $('#nik').val(data.response.peserta
                            .nik).attr('readonly', true);
                        $('#nama').val(data.response.peserta
                            .nama).attr('readonly', true);
                        $('#norm').val(data.response.peserta
                            .mr.noMR).attr('readonly', true);
                        $('#nohp').val(data.response.peserta
                            .mr.noTelepon);
                        $('#nomorkartu').val(data.response.peserta
                            .noKartu).attr('readonly', true);
                        $('.nomorkartu').show();
                        $('.nik').show();
                        $('.nama').show();
                        $('.norm').show();
                        $('.nohp').show();
                        $.LoadingOverlay("hide");
                        swal.fire(
                            'Success',
                            "Nomor NIK/KTP " + nik + " atas nama " + data.response.peserta
                            .nama,
                            'success'
                        );
                    } else {
                        $.LoadingOverlay("hide");
                        swal.fire(
                            'Error',
                            data.metaData.message,
                            'error'
                        );

                    }
                }).fail(function(error) {
                    alert(error);
                });
            });
            $('#nomorreferensi').change(function() {
                var nomorreferensi = $('#nomorreferensi').find('option:selected').val();
                var kodedokter = $('#kodedokter').find('option:selected').val();
                var kodepoli = $('#kodepoli').val();
                var tanggalperiksa = $('#tanggalperiksa').val();
                var jeniskunjungan = $('#jeniskunjungan').val();
                if (nomorreferensi != 0) {
                    if (jeniskunjungan == 1) {
                        var formData = {
                            nomorreferensi: nomorreferensi,
                            jenisrujukan: 1,
                        }
                        $.LoadingOverlay("show");
                        var url = "{{ route('api.rujukan_nomor') }}";
                        $.get(url, formData, function(data) {
                            if (data.metaData.code == 200) {
                                if (data.response.rujukan.poliRujukan.kode == kodepoli) {
                                    var url = "{{ route('api.rujukan_jumlah_sep') }}";
                                    $.get(url, formData, function(data) {
                                        if (data.metaData.code == 200) {
                                            if (data.response.jumlahSEP == 0) {
                                                $.LoadingOverlay("hide");
                                                swal.fire(
                                                    'Success',
                                                    data.metaData.message,
                                                    'success'
                                                );
                                            } else {
                                                $.LoadingOverlay("hide");
                                                swal.fire({
                                                    icon: 'error',
                                                    title: 'Error!',
                                                    text: "Nomor Rujukan " +
                                                        nomorreferensi +
                                                        " anda telah digunakan untuk kunjungan pertama, silahkan klik 'Reset' dan pilih jenis kunjungan lainnya.",
                                                    allowOutsideClick: false,
                                                    allowEscapeKey: false
                                                });
                                            }
                                        } else {
                                            $.LoadingOverlay("hide");
                                            swal.fire(
                                                'Error',
                                                data.metaData.message,
                                                'error'
                                            );
                                        }
                                    }).fail(function(error) {
                                        alert(error);
                                    });
                                } else {
                                    $.LoadingOverlay("hide");
                                    swal.fire({
                                        icon: 'error',
                                        title: 'Error!',
                                        text: "Tujuan Nomor Rujukan " + nomorreferensi +
                                            " ke POLI " + data.response.rujukan.poliRujukan
                                            .kode + " berbeda dengan POLI " + kodepoli +
                                            " tujuan anda.",
                                        allowOutsideClick: false,
                                        allowEscapeKey: false
                                    });
                                }
                            } else {
                                $.LoadingOverlay("hide");
                                swal.fire(
                                    'Error',
                                    data.metaData.message,
                                    'error'
                                );
                            }
                        }).fail(function(error) {
                            alert(error);
                        });
                    }
                    if (jeniskunjungan == 3) {
                        var formData = {
                            nomorreferensi: nomorreferensi,
                        }
                        $.LoadingOverlay("show");
                        var url = "{{ route('api.surat_kontrol_nomor') }}";
                        $.get(url, formData, function(data) {
                            console.log(data);
                            if (data.metaData.code == 200) {
                                if (data.response.tglRencanaKontrol != tanggalperiksa) {
                                    console.log('tanggal periksa berbeda');
                                    $.LoadingOverlay("hide");
                                    swal.fire(
                                        'Error',
                                        "Maaf tanggal periksa (" + tanggalperiksa +
                                        ") anda berbeda dengan tanggal periksa yang terdaftar di Surat Kontrol (" +
                                        data.response.tglRencanaKontrol +
                                        "). Silahkan 'Reset Jadwal' pilihan jadwal anda sesuaikan dengan surat kontrol.",
                                        'error'
                                    );
                                } else if (data.response.poliTujuan != kodepoli) {
                                    console.log('poli berbeda');
                                    $.LoadingOverlay("hide");
                                    swal.fire(
                                        'Error',
                                        "Maaf poli tujuan (" + kodepoli +
                                        ") anda berbeda dengan poli tujuan yang terdaftar di Surat Kontrol (" +
                                        data.response.poliTujuan +
                                        "). Silahkan 'Reset Jadwal' pilihan jadwal anda sesuaikan dengan surat kontrol.",
                                        'error'
                                    );
                                } else if (data.response.kodeDokter != kodedokter) {
                                    console.log('dokter berbeda');
                                    $.LoadingOverlay("hide");
                                    swal.fire(
                                        'Error',
                                        "Maaf dokter tujuan (" + kodedokter +
                                        ") anda berbeda dengan dokter tujuan yang terdaftar di Surat Kontrol (" +
                                        data.response.kodeDokter +
                                        "). Silahkan 'Reset Jadwal' pilihan jadwal anda sesuaikan dengan surat kontrol.",
                                        'error'
                                    );
                                } else {
                                    $.LoadingOverlay("hide");
                                    swal.fire(
                                        'Success',
                                        data.metaData.message,
                                        'success'
                                    );
                                }
                            } else {
                                $.LoadingOverlay("hide");
                                swal.fire(
                                    'Error',
                                    data.metaData.message,
                                    'error'
                                );
                            }
                        }).fail(function(error) {
                            alert(error);
                        });
                    }
                }
            });
            $('#reset').click(function() {
                $('.nik').hide();
                $('.nomorkartu').hide();
                $('.nama').hide();
                $('.norm').hide();
                $('.nohp').hide();
                $('.nomorreferensi').hide();
                $('#nama').val('');
                $('#norm').val('');
                $('#nohp').val('');
                $('#nik').val('').attr('readonly', false);
                $('#nomorkartu').val('').attr('readonly', false);
                $('#nomorreferensi').val(0).change();
                $('#pilihjeniskunjungan').prop('disabled', false).val(0).change();
            });
            $('#reset_jadwal').click(function() {
                $('.nik').hide();
                $('.nomorkartu').hide();
                $('.nama').hide();
                $('.norm').hide();
                $('.nohp').hide();
                $('.datapasien').hide();
                $('.kodedokter').hide();
                $('.nomorreferensi').hide();
                $('#nama').val('');
                $('#norm').val('');
                $('#nohp').val('');
                $('#nik').val('').attr('readonly', false);
                $('#nomorkartu').val('').attr('readonly', false);
                $('#nomorreferensi').val(0).change();
                $('#kodedokter').find('option').remove();
                $('#kodepoli').val(0).change();
                $('#pilihjeniskunjungan').prop('disabled', false).val(0).change();
                $('#pilihkodepoli').prop('disabled', false).val(0).change();
            });
        });
    </script>
    {{-- withLoad --}}
    <script>
        $(function() {
            $(".withLoad").click(function() {
                $.LoadingOverlay("show");
            });
        })
        $('.reload').click(function() {
            location.reload();
        });
    </script>
@stop
