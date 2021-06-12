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
                                <li class="breadcrumb-item active">Kelas</li>
                            </ol>
                        </div>
                        <div class="col-sm-6">
                            <h1 class="float-sm-right"><i class="fas fa-cog"></i> Kelas</h1>
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
                    <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambahkelas"><i class="fas fa-plus"></i> Tambah</a>
                    <div class="modal fade" id="tambahkelas" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Tambah Kelas</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form id="formtambah" action="{{ url('tambahkelas') }}" method="post">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Kelas</label>
                                            <input type="text" class="form-control @error('kelas') is-invalid @enderror" name="kelas" required>
                                            @error('kelas')
                                                <p class="text-red">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Jenjang</label>
                                            <select class="form-control" name="jenjang">
                                                <option>Setingkat TK/RA</option>
                                                <option>Setingkat SD/MI/Ula</option>
                                                <option>Setingkat SMP/MTA/Wustha</option>
                                                <option>Setingakt SMA/MA/Ulya</option>
                                                <option>Progam Lainnya</option>
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
                    <table width="100%" id="table-kelas" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th width="20px">No</th>
                                <th>Kelas</th>
                                <th>Jenjang</th>
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
    $(document).ready(function() {
        let id, kelas, jenjang;
        $('#table-kelas').DataTable({
            processing: true,
            serverSide: true,
            ajax: 'kelas-json',
            columns: [
                { data: 'id_kelas', name:'id_kelas', render: function (data, type, row, meta) {
                    id = data
                    return meta.row + meta.settings._iDisplayStart + 1;
                }},
                { data: 'kelas', name: 'kelas', render: function(data){ return kelas = data }},
                { data: 'jenjang', name: 'jenjang', render: function(data){ return jenjang = data }},
                { name: 'edit', render: function () {
                    return `<button class="btn btn-success btn-sm" data-toggle="modal" data-target="#editkelas`+id+`"><i class="fas fa-edit"></i></button>
                    <div class="modal fade" id="editkelas`+id+`" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit Kelas</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form class="formedit" action="{{ url('editkelas') }}" method="post">
                                    @csrf
                                    <div class="modal-body">
                                        <input type="hidden" name="id_kelas" value="`+id+`">
                                        <div class="form-group">
                                            <label class="col-form-label">Kelas</label>
                                            <input type="text" class="form-control required" name="kelas" value="` +kelas+ `" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Jenjang</label>
                                            <select class="form-control" name="jenjang">
                                                <option `+( jenjang == 'Setingkat TK/RA' ? 'selected':'' )+`>Setingkat TK/RA</option>
                                                <option `+( jenjang == 'Setingkat SD/MI/Ula' ? 'selected':'' )+`>Setingkat SD/MI/Ula</option>
                                                <option `+( jenjang == 'Setingkat SMP/MTA/Wustha' ? 'selected':'' )+`>Setingkat SMP/MTA/Wustha</option>
                                                <option `+( jenjang == 'Setingakt SMA/MA/Ulya' ? 'selected':'' )+`>Setingakt SMA/MA/Ulya</option>
                                                <option `+( jenjang == 'Progam Lainnya' ? 'selected':'' )+`>Progam Lainnya</option>
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
                    return `<button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapuskelas`+id+`"><i class="fas fa-trash"></i></button>
                    <div class="modal fade" id="hapuskelas`+id+`" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Hapus Kelas</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Yakin Ingin Menghapus Data Kelas ?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <a href="{{ url('hapuskelas') }}/`+(id)+`" class="btn btn-danger">Hapus</a>
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