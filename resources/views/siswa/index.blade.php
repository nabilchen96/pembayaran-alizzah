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
                                <li class="breadcrumb-item active">Siswa</li>
                            </ol>
                        </div>
                        <div class="col-sm-6">
                            <h1 class="float-sm-right"><i class="fas fa-cog"></i> Siswa</h1>
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
                    <a href="{{ url('tambahsiswa') }}" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i>
                        Tambah</a>
                    <a href="{{ url('siswa-export') }}" class="btn btn-sm btn-success"><i class="fas fa-file-excel"></i>
                        Export</a>
                    <a href="#" class="btn btn-sm btn-success" data-toggle="modal" data-target="#importsiswa"><i
                            class="fas fa-file-excel"></i> Import</a>
                    <a href="{{ url('cetakqrcode-allsiswa') }}" class="btn btn-sm btn-success"><i
                            class="fas fa-print"></i> Cetak QrCode</a>
                    <div class="modal fade" id="importsiswa" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Import Siswa</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ url('siswa-import') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">

                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Import Siswa</label>
                                            <input type="file" class="form-control" name="file" required>
                                            <p class="mt-2">Gunakan format xlsx berikut ini untuk mengimport data <br>
                                                <a class="mt-2" href="{{ asset('siswa-format-import.xlsx') }}">Download
                                                    Format Import Excel</a></p>
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
                        <table width="100%" id="table-siswa" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="20px">No</th>
                                    <th>NIS</th>
                                    <th>Nama Siswa</th>
                                    <th>Akun</th>
                                    <th>Jenis Kelamin</th>
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
        let id, nis, nama, jk, no_telp, nama_ayah, nama_ibu, alamat;
        $('#table-siswa').DataTable({
            processing: true,
            serverSide: true,
            ajax: 'siswa-json',
            columns: [
                { data: 'id_siswa',     name:'id_siswa',    render: function (data, type, row, meta) {
                    id = data
                    return meta.row + meta.settings._iDisplayStart + 1;
                }},
                { data: 'nis',          name: 'nis',        render: function(data){ return nis = data }},
                { data: 'nama_siswa',   name: 'nama_siswa', render: function(data){ return nama = data }},
                { data: 'akun', name: 'akun', render: function(data){
                    return data == null ? '<span class="badge badge-danger text-left">Akun Belum Dibuat</span>' : '<span class="badge badge-success">Akun Sudah Dibuat</span>'
                }},
                { data: 'jk',           name: 'jk',         render: function(data){ 
                    jk = data 
                    return data == 1 ? 'Laki-laki' : 'Perempuan' 
                }},
                { data: 'status', name: 'status', render: function(data){
                    return data == 'Aktif' ? '<span class="badge badge-success">'+data+'</span>' : '<span class="badge badge-danger">'+data+'</span>' 
                }},
                { name: 'edit',         render: function(data){ 
                    return `<a href="{{ url('editsiswa') }}/`+(id)+`" class="btn btn-success btn-sm"><i class="fas fa-edit"></i></a>`
                }},
                { name: 'hapus',        render: function(data){ 
                    return `<button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapussiswa`+id+`"><i class="fas fa-trash"></i></button>
                    <div class="modal fade" id="hapussiswa`+id+`" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Hapus Siswa</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Yakin Ingin Menghapus Data Siswa ini ?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <a href="{{ url('hapussiswa') }}/`+(id)+`" class="btn btn-danger">Hapus</a>
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