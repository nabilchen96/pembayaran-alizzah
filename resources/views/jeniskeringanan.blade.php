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
                                <li class="breadcrumb-item active">Jenis Keringanan</li>
                            </ol>
                        </div>
                        <div class="col-sm-6">
                            <h1 class="float-sm-right"><i class="fas fa-cog"></i> Jenis Keringanan</h1>
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
                    <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambahkeringanan"><i class="fas fa-plus"></i> Tambah</a>
                    <div class="modal fade" id="tambahkeringanan" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Tambah keringanan</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form id="formtambah" action="{{ url('tambahkeringanan') }}" method="post">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">keringanan</label>
                                            <input type="text" class="form-control @error('keringanan') is-invalid @enderror" name="keringanan" required>
                                            @error('keringanan')
                                                <p class="text-red">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Untuk Pembayaran</label>
                                            <select name="id_jenis_pembayaran" class="form-control">
                                                @foreach ($pembayaran as $item)
                                                    <option value="{{ $item->id_jenis_pembayaran }}">{{ $item->nama_pembayaran }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Besaran Keringanan</label>
                                            <input type="number" class="form-control @error('besaran_keringanan') is-invalid @enderror" name="besaran_keringanan" required>
                                            @error('besaran_keringanan')
                                                <p class="text-red">{{ $message }}</p>
                                            @enderror
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
                    <table width="100%" id="table-keringanan" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th width="20px">No</th>
                                <th>Keringanan</th>
                                <th>Besaran Keringanan</th>
                                <th>Untuk Pembayaran</th>
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
        let id, keringanan, besaran_keringanan, pembayaran;
        $('#table-keringanan').DataTable({
            processing: true,
            serverSide: true,
            ajax: 'jeniskeringanan-json',
            columns: [
                { data: 'id_keringanan', name:'id_keringanan', render: function (data, type, row, meta) {
                    id = data
                    return meta.row + meta.settings._iDisplayStart + 1;
                }},
                { data: 'keringanan', name: 'keringanan', render: function(data){ return keringanan = data }},
                { data: 'besaran_keringanan', name: 'besaran_keringanan', render: function(data){ 
                    besaran_keringanan = data 
                    return 'Rp. '+Intl.NumberFormat().format(besaran_keringanan)
                }},
                { data: 'nama_pembayaran', name: 'nama_pembayaran'},
                { name: 'edit', render: function () {
                    return `<button class="btn btn-success btn-sm" data-toggle="modal" data-target="#editkeringanan`+id+`"><i class="fas fa-edit"></i></button>
                    <div class="modal fade" id="editkeringanan`+id+`" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit keringanan</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form class="formedit" action="{{ url('editkeringanan') }}" method="post">
                                    @csrf
                                    <div class="modal-body">
                                        <input type="hidden" name="id_keringanan" value="`+id+`">
                                        <div class="form-group">
                                            <label class="col-form-label">keringanan</label>
                                            <input type="text" class="form-control required" name="keringanan" value="` +keringanan+ `" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Besaran Keringanan</label>
                                            <input type="text" class="form-control required" name="besaran_keringanan" value="` +besaran_keringanan+ `" required>
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
                    return `<button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapuskeringanan`+id+`"><i class="fas fa-trash"></i></button>
                    <div class="modal fade" id="hapuskeringanan`+id+`" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Hapus keringanan</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Yakin Ingin Menghapus Data keringanan ?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <a href="{{ url('hapuskeringanan') }}/`+(id)+`" class="btn btn-danger">Hapus</a>
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