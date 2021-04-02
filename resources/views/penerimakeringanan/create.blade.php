@extends('layouts.app')

@push('style')

<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('adminlte/plugins/toastr/toastr.min.css') }}">
@endpush

@push('penerimakeringanan')
    active
@endpush

@section('content')

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
                                <li class="breadcrumb-item active">Keringanan</li>
                                <li class="breadcrumb-item active">Tambah Penerima Keringanan</li>
                            </ol>
                        </div>
                        <div class="col-sm-6">
                            <h1 class="float-sm-right"><i class="fas fa-cog"></i> Tambah Penerima Keringanan</h1>
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
                    <a href="{{ url('detailpenerimakeringanan') }}?id_keringanan={{ $keringanan->id_keringanan }}" class="btn btn-sm btn-primary"><i class="fas fa-arrow-left"></i> Kembali</a>
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
                    <form action="{{ url('simpanpenerimakeringanan') }}" enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Keringanan<sup class="text-red">*</sup></label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" value="{{ $keringanan->keringanan }}" disabled>
                                <input type="hidden" name="id_keringanan" value="{{ $keringanan->id_keringanan }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">NIS<sup class="text-red">*</sup></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="nis" disabled>
                                <input type="hidden" name="id_siswa" id="id_siswa">
                            </div>
                            <div class="col-sm-1">
                                <a href="#" class="btn btn-block btn-primary" data-toggle="modal" data-target="#carisiswa"><i class="fas fa-search"></i></a>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nama Siswa<sup class="text-red">*</sup></label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="nama_siswa" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Status Penerima<sup class="text-red">*</sup></label>
                            <div class="col-sm-7">
                                <select class="form-control" name="status_penerima">
                                    <option value="1">Aktif</option>
                                    <option value="0">Tidak Aktif</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Berkas Keringanan<sup class="text-red">*</sup></label>
                            <div class="col-sm-7">
                                <input type="file" class="form-control" name="berkas_keringanan">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Alasan Keringanan</label>
                            <div class="col-sm-7">
                                <textarea name="alasan_keringanan" class="form-control" rows="10"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label"></label>
                            <div class="col-sm-7">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="carisiswa" tabindex="-1" role="dialog"aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Penerima Keringanan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table width="100%" id="table-siswa" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th width="20px">No</th>
                            <th>NIS</th>
                            <th>Nama Siswa</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"
                    data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
<script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/toastr/toastr.min.js') }}"></script>

<script>
    @if($message = Session::get('gagal'))
        toastr.error("{{ $message }}")
    @endif
</script>

<script>
$(document).ready(function() {
        let id, nis, nama
        var table = $('#table-siswa').DataTable({
            processing: true,
            serverSide: true,
            ajax: 'siswa-json',
            columns: [
                { data: 'id_siswa', name:'id_siswa',    render: function (data, type, row, meta) {
                    id = data
                    return meta.row + meta.settings._iDisplayStart + 1;
                }},
                { data: 'nis', name: 'nis', render: function(data){ return nis = data }},
                { data: 'nama_siswa', name: 'nama_siswa', render: function(data){ return nama = data }},
                { data: null, targets: -1, defaultContent:  
                    '<button class="btn btn-sm btn-primary" data-dismiss="modal"><i class="fas fa-plus"></i></button>', 
                }
            ]
        });
        $('#table-siswa tbody').on('click', 'button', function (e) {
            var data = table.row( $(this).parents('tr') ).data();

            document.getElementById('nis').value = data['nis']
            document.getElementById('id_siswa').value = data['id_siswa']
            document.getElementById('nama_siswa').value = data['nama_siswa']
        });
    });
</script>
@endpush