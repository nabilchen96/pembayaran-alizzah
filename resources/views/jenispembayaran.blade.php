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
                                <li class="breadcrumb-item active">Jenis Pembayaran</li>
                            </ol>
                        </div>
                        <div class="col-sm-6">
                            <h1 class="float-sm-right"><i class="fas fa-cog"></i> Jenis Pembayaran</h1>
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
                    <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambahjenispembayaran"><i class="fas fa-plus"></i> Tambah</a>
                    <div class="modal fade" id="tambahjenispembayaran" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Tambah Jenis Pembayaran</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form id="formtambah" action="{{ url('tambahjenispembayaran') }}" method="post">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label class="col-form-label">Jenis pembayaran</label>
                                            <input type="text" class="form-control" name="nama_pembayaran" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Total Pembayaran Pertahun</label>
                                            <input type="number" class="form-control" name="total_pembayaran_pertahun" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Pembayaran Rutin</label>
                                            <select name="pembayaran_rutin" class="form-control">
                                                <option>non-rutin</option>
                                                <option>rutin</option>
                                            </select>
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
                    <table width="100%" id="table-jenispembayaran" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th width="20px">No</th>
                                <th>Nama Pembayaran</th>
                                <th>Total Pembayaran Pertahun</th>
                                <th>Pembayaran Rutin</th>
                                <th width="10px"></th>
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
        let id, namapembayaran, total_pembayaran, pembayaranrutin;
        $('#table-jenispembayaran').DataTable({
            processing: true,
            serverSide: true,
            ajax: 'jenispembayaran-json',
            columns: [
                { data: 'id_jenis_pembayaran', name:'id_jenis_pembayaran', render: function (data, type, row, meta) {
                    id = data
                    return meta.row + meta.settings._iDisplayStart + 1;
                }},
                { data: 'nama_pembayaran', name: 'nama_pembayaran', render: function(data){ return namapembayaran = data }},
                { data: 'total_pembayaran_pertahun', name: 'total_pembayaran_pertahun', render: function(data){ 
                    total_pembayaran = data
                    return data +' Kali/Pertahun' 
                }},
                { data: 'pembayaran_rutin', name: 'pembayaran_rutin', render: function(data){ return pembayaranrutin = data }},
                { name:'detail', render: function(data){
                    return '<a href="{{ url("setpembayarankelas") }}/'+id+'" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>'
                }},
                { name: 'edit', render: function (data) {
                    return `<button class="btn btn-success btn-sm" data-toggle="modal" data-target="#editjenispembayaran`+id+`"><i class="fas fa-edit"></i></button>
                    <div class="modal fade" id="editjenispembayaran`+id+`" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit Jenis Pembayaran</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form class="formedit" action="{{ url('editjenispembayaran') }}" method="post">
                                    @csrf
                                    <div class="modal-body">
                                        <input type="hidden" name="id_jenis_pembayaran" value="`+id+`">
                                        <div class="form-group">
                                            <label class="col-form-label">Jenis Pembayaran</label>
                                            <input type="text" class="form-control required" name="nama_pembayaran" value="` +namapembayaran+ `" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Jenis Pembayaran</label>
                                            <input type="text" class="form-control required" name="total_pembayaran_pertahun" value="` +total_pembayaran+ `" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Pembayaran Rutin</label>
                                            <select class="form-control" name="pembayaran_rutin">
                                                <option value="non-rutin" `+( pembayaranrutin == 'non-rutin' ? 'selected' : '')+`>non-rutin</option>
                                                <option value="rutin" `+( pembayaranrutin == 'rutin' ? 'selected' : '')+`>rutin</option>
                                            </select>
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
                { name:'hapus', render: function () {
                    return `<button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapusjenispembayaran`+id+`"><i class="fas fa-trash"></i></button>
                    <div class="modal fade" id="hapusjenispembayaran`+id+`" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Hapus jenis pembayaran</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Yakin Ingin Menghapus Data jenis pembayaran ?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <a href="{{ url('hapusjenispembayaran') }}/`+(id)+`" class="btn btn-danger">Hapus</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    `
                }},
            ]
        });
    });
</script>
@endpush