@extends('layouts.app')

@push('style')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/toastr/toastr.min.css') }}">
    <style>
        .dataTable-selector {
            background-image: none !important;
        }

        #reader__dashboard_section_swaplink {
            display: none;
        }

        video {
            width: 100% !important;
            /* height: 50% !important; */
        }

    </style>
@endpush

@section('content')
    <!-- Default box -->

    <div class="content-wrapper">
        <!-- Content Header & bread crumb -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <ol class="breadcrumb" style="padding-top: 5px">
                                    <li class="breadcrumb-item active">Transaksi Kantin</li>
                                </ol>
                            </div>
                            <div class="col-sm-6">
                                <h1 class="float-sm-right"><i class="fas fa-cog"></i> Transaksi Kantin</h1>
                            </div>
                        </div>
                    </div>
                </div>

            </div><!-- /.container-fluid -->

        </section>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <button href="#" data-target="#modaltambah" data-toggle="modal" class="btn btn-sm btn-primary"><i
                                class="fas fa-plus"></i>Tambah Transaksi</button>

                        <div class="modal fade" id="modaltambah" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Scan QrCode</h5>
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ url('tambahtransaksikantin') }}" onSubmit="cek_inputan()"
                                        method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <video id="reader">

                                            </video>
                                            <div id="onsukses" class="d-none">
                                                <div class="form-group">
                                                    <label for="">Nama</label>
                                                    <input type="text" id="nama_siswa" class="form-control mt-1" readonly>
                                                    <input type="hidden" name="id_siswa" id="id_siswa">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">NIS</label>
                                                    <input type="text" class="form-control mt-1" readonly id="nis">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Kelas</label>
                                                    <input type="text" class="form-control mt-1" disabled id="kelas">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Saldo</label>
                                                    <input type="text" class="form-control mt-1" disabled id="saldo">
                                                </div>
                                                {{-- <div class="form-group">
                                                <label for="">Jenis Transaksi</label>
                                                <select name="jenis_transaksi" id="jenis_transaksi" class="form-control"
                                                    onchange="setbatasjajan()" required>
                                                    <option value="">pilih jenis transaksi</option>
                                                    <option value="0">Jajan Harian</option>
                                                    <option value="1">Kebutuhan Khusus</option>
                                                </select>
                                            </div> --}}
                                                <div class="form-group">
                                                    <label for="">Jajan Harian</label>
                                                    <input type="number" name="jajan_harian" class="form-control"
                                                        id="maksimal_jajan_harian">
                                                    <p style="font-size: 12px;" class="text-info mt-1">Isi dengang angka 0
                                                        atau kosongkan jika tidak ada transaksi</p>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Kebutuhan Khusus</label>
                                                    <input type="number" name="kebutuhan_khusus" class="form-control"
                                                        id="maksimal_kebutuhan_khusus">
                                                    <p style="font-size: 12px;" class="text-info mt-1">Isi dengang angka 0
                                                        atau kosongkan jika tidak ada transaksi</p>
                                                </div>

                                                {{-- <div class="form-group">
                                                <label for="">Jumlah Transaksi</label>
                                                <input type="number" name="jumlah" class="form-control" id="maksimal_transaksi"
                                                    min="1">
                                            </div> --}}
                                            </div>
                                            <div id="onfail" class="d-none">
                                                <p class="alert alert-danger">Maaf, data yang anda cari tidak ditemukan!</p>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" onclick="flipCamera()" id="flip"
                                                class="btn btn-secondary">
                                                <i class="fas fa-camera"></i>
                                            </button>
                                            <button type="button" class="btn btn-secondary" onclick="scanlagi()">Scan
                                                Lagi</button>
                                            <div id="submit" class="d-none">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                                <i class="fas fa-minus"></i></button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip"
                                title="Remove">
                                <i class="fas fa-times"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            &nbsp; Halaman ini hanya menampilkan transaksi di tanggal {{ date('d-m-y') }}. Klik <a
                                href="{{ url('laporankantin') }}">Halaman Laporan Kantin</a> untuk melihat history
                            transaksi sebelumnya
                        </div>
                        <div class="table-responsive">
                            <table width="100%" id="table-siswa" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th width="20px">No</th>
                                        <th>Tanggal</th>
                                        <th>NIS</th>
                                        <th>Nama Siswa</th>
                                        <th>Keterangan</th>
                                        <th>Jumlah Transaksi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@push('script')
    <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/toastr/toastr.min.js') }}"></script>
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <script>
        @if ($message = Session::get('sukses'))
            toastr.success("{{ $message }}")
        @elseif($message = Session::get('gagal'))
            toastr.error("{{ $message }}")
        @endif
    </script>
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> --}}
    <script>
        function scanlagi() {
            document.getElementById('onsukses').setAttribute('class', 'd-none')
            document.getElementById('reader').removeAttribute('class', 'd-none')
            document.getElementById('submit').setAttribute('class', 'd-none')
            document.getElementById('onfail').setAttribute('class', 'd-none')
        }

        var batas = 0;
        var limit_harian = 0;
        var camera = 0

        function isiotomatis(content) {
            $.ajax({
                url: "{{ url('carisiswa') }}/" + content
            }).done(function(data) {
                obj = JSON.parse(data);
                console.log(data)

                if (obj == null) {
                    document.getElementById('reader').setAttribute('class', 'd-none')
                    document.getElementById('onfail').removeAttribute('class', 'd-none')
                } else {
                    document.getElementById('reader').setAttribute('class', 'd-none')
                    document.getElementById('onsukses').removeAttribute('class', 'd-none')

                    document.getElementById('nama_siswa').value = obj.data1.nama_siswa
                    document.getElementById('id_siswa').value = obj.data1.id_siswa
                    document.getElementById('nis').value = obj.data1.nis
                    document.getElementById('kelas').value = obj.data1.kelas + ' ' + obj.data1.jenjang
                    document.getElementById('saldo').value = "Rp. " + Intl.NumberFormat().format(obj.jumlah_masuk -
                        obj.jumlah_keluar)

                    //maksimal jajan harian
                    document.getElementById('maksimal_jajan_harian').setAttribute('placeholder',
                        'batas maksimal adalah Rp. ' + Intl.NumberFormat().format(obj.data1.limit_jajan_harian))
                    document.getElementById('maksimal_jajan_harian').setAttribute('max', obj.data1
                        .limit_jajan_harian)

                    //maksimal kebutuhan khusus
                    document.getElementById('maksimal_kebutuhan_khusus').setAttribute('placeholder',
                        'batas maksimal adalah Rp. ' + Intl.NumberFormat().format(obj.jumlah_masuk - obj
                            .jumlah_keluar))
                    document.getElementById('maksimal_kebutuhan_khusus').setAttribute('max', obj.jumlah_masuk - obj
                        .jumlah_keluar)

                    // limit_harian = obj.limit_jajan_harian

                    document.getElementById('submit').removeAttribute('class', 'd-none')
                }
            }).fail(function(data, xhr) {
                document.getElementById('reader').setAttribute('class', 'd-none')
                document.getElementById('onfail').removeAttribute('class', 'd-none')
            })
        }

        let scanner = new Instascan.Scanner({
            video: document.getElementById('reader'),
            mirror: false
        });

        scanner.addListener('scan', function(content) {
            isiotomatis(content)
        });

        Instascan.Camera.getCameras().then(function(cameras) {

            if (cameras.length > 0) {
                scanner.start(cameras[0]);
            } else {
                console.error('No cameras found.');
            }


        }).catch(function(e) {

            console.error(e);

        });

        function flipCamera() {

            // if(cameras.length > 0){
                Instascan.Camera.getCameras().then(function(cameras) {

                    console.log(cameras);
                    
                    if (cameras.length > 1) {
    
                        if (camera == 0) {
                            camera = 1
                        } else if(camera == 1) {
                            camera = 0
                        }
    
                        scanner.start(cameras[camera]);
                    } else {
                        console.error('No cameras found.');
                    }
    
    
                }).catch(function(e) {
    
                    console.error(e);
    
                });
            // }

        }
    </script>
    <script>
        $('#table-siswa').DataTable({
            processing: true,
            serverSide: true,
            ordering: false,
            ajax: '{!! url()->current() !!}',
            columns: [{
                    data: 'id_siswa',
                    name: 'id_siswa',
                    render: function(data, type, row, meta) {
                        id = data
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'nis',
                    name: 'nis',
                    render: function(data) {
                        return nis = data
                    }
                },
                {
                    data: 'nama_siswa',
                    name: 'nama_siswa',
                    render: function(data) {
                        return nama = data
                    }
                },
                {
                    data: 'keterangan',
                    name: 'keterangan'
                },
                {
                    data: 'jumlah',
                    name: 'jumlah',
                    render: function(data) {
                        return "Rp. " + Intl.NumberFormat().format(data)
                    }
                }
            ]
        });
    </script>
@endpush
