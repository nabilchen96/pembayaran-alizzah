@extends('layouts.app')

@push('style')

<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('adminlte/plugins/toastr/toastr.min.css') }}">
@endpush

@push('master')
menu-open
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
                                <li class="breadcrumb-item active">Data Master</li>
                                <li class="breadcrumb-item active">Tahun Ajaran</li>
                            </ol>
                        </div>
                        <div class="col-sm-6">
                            <h1 class="float-sm-right"><i class="fas fa-cog"></i> Tahun Ajaran</h1>
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
                    <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambahtahun"><i
                            class="fas fa-plus"></i> Tambah</a>
                    <div class="modal fade" id="tambahtahun" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Tambah Tahun Ajaran</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form onsubmit="return false;" id="formtambah" action="{{ url('tambahtahun') }}" method="post">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Tahun Ajaran</label>
                                            <input type="text" class="form-control @error('tahun') is-invalid @enderror"
                                                name="tahun" required>
                                            @error('tahun')
                                            <p class="text-red">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <input type="date" name="tgl_mulai" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="date" name="tgl_akhir" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Tambah</button>
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
                    <div class="table-responsive">
                        <table width="100%" id="table-tahun" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="20px">No</th>
                                    <th>Tahun</th>
                                    <th>Bulan Awal</th>
                                    <th>Bulan Akhir</th>
                                    <th>Status</th>
                                    <th width="10px"></th>
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
<script>
    @if($message = Session::get('sukses'))
        toastr.success("{{ $message }}")
    @elseif($message = Session::get('gagal'))
        toastr.error("{{ $message }}")
    @endif
</script>
<script>
    $(function() {
        let id, tahun, status;
        $('#table-tahun').DataTable({
            processing: true,
            serverSide: true,
            ajax: 'tahun-json',
            columns: [
                { data: 'id_tahun', name:'id_tahun', render: function (data, type, row, meta) {
                    id = data
                    return meta.row + meta.settings._iDisplayStart + 1;
                }},
                { data: 'tahun', name: 'tahun', render: function(data){ return tahun = data }},
                { data: 'tgl_mulai', name: 'tgl_awal' },
                { data: 'tgl_akhir', name: 'tgl_akhir' },
                { data: 'status_aktif', name:'status_aktif', render: function (data) {
                    status = data
                    return data == 1 ? '<span class="badge badge-success">Aktif</span>' : '<span class="badge badge-danger">Tidak Aktif</span>'
                }},
                { name:'edit', render: function (data, type, row, meta) {
                    return `<button class="btn btn-success btn-sm" data-toggle="modal" data-target="#edittahun`+id+`"><i class="fas fa-edit"></i></button>
                    <div class="modal fade" id="edittahun`+id+`" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit Tahun Ajaran</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form class="formedit" action="{{ url('edittahun') }}" method="post">
                                    @csrf
                                    <div class="modal-body">
                                        <input type="hidden" name="id_tahun" value="`+id+`">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Tahun Ajaran</label>
                                        <input type="text" class="form-control required" name="tahun" value="` +tahun+ `" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="date" name="tgl_mulai" value=`+row.tgl_mulai+` required class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input type="date" name="tgl_akhir" value=`+row.tgl_akhir+` required class="form-control">
                                    </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Edit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    `
                }},
                { name:'aktivasi', render: function () {
                    return status == 1 ? `<a href="{{ url("editstatustahun") }}/`+(id)+`" class="btn btn-sm btn-primary"><i class="fas fa-unlock"></i></a>`:
                    `<a href="{{ url("editstatustahun") }}/`+(id)+`" class="btn btn-sm btn-danger"><i class="fas fa-lock"></i></a>`
                }},
            ]
        });
    });
</script>
@endpush