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
                                <li class="breadcrumb-item">Dashboard</li>
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
                    <a href="{{ url('siswa-export') }}" class="btn btn-sm btn-success"><i class="fas fa-file-excel"></i>
                        Export</a>

                    <button href="#" data-target="#modaltambah" data-toggle="modal" class="btn btn-sm btn-primary"><i
                            class="fas fa-plus"></i>Tambah Transaksi</button>

                    <div class="modal fade" id="modaltambah" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Scan QrCode</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <video id="reader">

                                    </video>
                                    <div id="onsukses" class="d-none">
                                        <form action="">
                                            <div class="form-group">
                                                <label for="">Nama</label>
                                                <input type="text" id="nama_siswa" class="form-control mt-1" readonly>
                                                <input type="hidden" name="id_siswa">
                                            </div>
                                            <div class="form-group">
                                                <label for="">NIS</label>
                                                <input type="text" class="form-control mt-1" readonly id="nis">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Kelas</label>
                                                <input type="text" class="form-control mt-1" disabled>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Saldo</label>
                                                <input type="text" class="form-control mt-1" disabled>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Jumlah Transaksi</label>
                                                <input type="number" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Keterangan</label>
                                                <textarea name="keterangan" id="" cols="30" rows="3"
                                                    class="form-control"></textarea>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" onclick="scanlagi()">Scan
                                        Lagi</button>
                                    <div id="submit" class="d-none">
                                        <button type="button" onclick="isiotomatis()"
                                            class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
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
                                    <th width="10px"></th>
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
    @if($message = Session::get('sukses'))
        toastr.success("{{ $message }}")
    @elseif($message = Session::get('gagal'))
        toastr.error("{{ $message }}")
    @endif
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>
    function scanlagi(){
        document.getElementById('onsukses').setAttribute('class', 'd-none')
        document.getElementById('reader').removeAttribute('class', 'd-none')
        document.getElementById('submit').setAttribute('class', 'd-none')
    }

    function isiotomatis(){
        $.ajax({
            url: "{{ url('siswa') }}/"+12
        }).success(function(data){

            obj = JSON.parse(data);

            document.getElementById('nama_siswa').value = obj.nama_siswa
            document.getElementById('nis').value = obj.nis
            
            document.getElementById('submit').removeAttribute('class', 'd-none')
        }) 
    }

    let scanner = new Instascan.Scanner({ 
        video: document.getElementById('reader'),
        mirror: false 
    });

    scanner.addListener('scan', function (content) {
        document.getElementById('reader').setAttribute('class', 'd-none')
        document.getElementById('onsukses').removeAttribute('class', 'd-none')

        // isiotomatis()
    });

    Instascan.Camera.getCameras().then(function (cameras) {

        scanner.start(cameras[0]);

    }).catch(function (e) {

      console.error(e);

    });
</script>
@endpush