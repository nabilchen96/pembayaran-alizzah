@extends('layouts.app')

@push('style')

<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('adminlte/plugins/toastr/toastr.min.css') }}">
@endpush

@push('uangsaku')
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
                                <li class="breadcrumb-item">Uang Saku Siswa</li>
                                <li class="breadcrumb-item">Uang Saku</li>
                                <li class="breadcrumb-item active">History Transaksi Uang Saku</li>
                            </ol>
                        </div>
                        <div class="col-sm-6">
                            <h1 class="float-sm-right"><i class="fas fa-cog"></i> History Transaksi Uang Saku</h1>
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
                    {{-- <a href="{{ url('siswa-export') }}" class="btn btn-sm btn-success"><i
                            class="fas fa-file-excel"></i>Export</a> --}}

                    <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambahtahun"><i
                            class="fas fa-plus"></i> Tambah</a>
                    <div class="modal fade" id="tambahtahun" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Tambah Transaksi Uang Saku</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form id="formtambah" action="{{ url('tambahtransaksiuangsaku') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="id_siswa" value="{{ request()->route('id') }}">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Keterangan</label>
                                            <textarea name="keterangan" class="form-control" rows="5"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Jenis Transaksi</label>
                                            <select name="jenis_transaksi" class="form-control">
                                                <option value="masuk">Masuk</option>
                                                <option value="keluar">Keluar</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Jumlah</label>
                                            <input type="number" class="form-control" name="jumlah">
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
                                    <th>Tanggal Transaksi</th>
                                    <th>Keterangan</th>
                                    <th>Masuk</th>
                                    <th>Keluar</th>
                                    <th>Saldo</th>
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
    var pengeluaran = 0;
    var pemasukan   = 0;
    var total       = 0;
    $('#table-siswa').DataTable({
            processing: true,
            serverSide: true,
            ordering: false,
            ajax: '{!! url()->current() !!}',
            columns: [
                { data: 'id_siswa',     name:'id_siswa',    render: function (data, type, row, meta) {
                    id = data
                    return meta.row + meta.settings._iDisplayStart + 1;
                }},
                { data: 'created_at',   name: 'created_at' },
                { data: 'keterangan',   name: 'keterangan' },
                { data: 'jenis_transaksi', name: 'masuk', render: function(data, type, row, meta){
                    if(data == 'masuk'){
                        pemasukan = row.jumlah + pemasukan
                    }   
                    return data == 'masuk' ? "Rp. "+Intl.NumberFormat().format(row.jumlah) : '-'
                }},
                { data: 'jenis_transaksi', name: 'keluar', render: function(data, type, row, meta){
                    if(data == 'keluar'){
                        pengeluaran = row.jumlah + pengeluaran
                    }
                    return data == 'keluar' ? "Rp. "+Intl.NumberFormat().format(row.jumlah) : '-'
                }},
                { data: 'jenis_transaksi', name: 'saldo', render: function(data, type, row, meta){
                    total = pemasukan - pengeluaran
                    return "Rp. "+Intl.NumberFormat().format(total)
                }}
            ]
        });
        total
</script>
@endpush