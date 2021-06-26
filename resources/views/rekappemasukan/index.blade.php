@extends('layouts.app')

@push('style')

<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('adminlte/plugins/toastr/toastr.min.css') }}">
@endpush

@push('laporan') menu-open @endpush
@push('rekappemasukan') active @endpush

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
                                <li class="breadcrumb-item active">Rekap Pemasukan</li>
                            </ol>
                        </div>
                        <div class="col-sm-6">
                            <h1 class="float-sm-right"><i class="fas fa-cog"></i> Rekap Pemasukan</h1>
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
                    <a href="{{ url('tambah-transaksi') }}" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i>
                        Tambah</a>
                    <a href="#" data-toggle="modal" data-target="#tambah" class="btn btn-sm btn-success"><i
                            class="fas fa-file-excel"></i> Export</a>

                    <div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Export Pengeluaran</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ url('rekaptransaksi-export') }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label class="col-form-label">Jenis Export</label>
                                            <select id="jenis_export" name="jenis_export" class="form-control" onchange="jenisexport()">
                                                <option value="">--Pilih Jenis Export--</option>
                                                <option value="1">Pertanggal</option>
                                                <option value="2">Transaksi Hari Ini</option>
                                                <option value="3">Transaksi Bulan Ini</option>
                                                <option value="4">Transaksi Tahun Ini</option>
                                            </select>
                                        </div>
                                        <div class="d-none" id="form_tgl">
                                            <div class="form-group">
                                                <label class="col-form-label">Pilih Tanggal Awal</label>
                                                <input type="date" class="form-control" name="tgl_awal">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Pilih Tanggal Akhir</label>
                                                <input type="date" class="form-control" name="tgl_akhir">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Pilih</button>
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
                                    <th>No Nota</th>
                                    <th>Tanggal</th>
                                    <th>Pembayaran</th>
                                    <th>Pembayar</th>
                                    <th>Jumlah Bayar</th>
                                    <th>Untuk Siswa</th>
                                    <th width="100px">Keterangan</th>
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
        $('#table-tahun').DataTable({
            processing: true,
            serverSide: true,
            ajax: 'rekappemasukan-json',
            order: [[0,"desc"]],
            columns: [
                { data: 'id_transaksi', name:'id_transaksi', render: function (data, type, row, meta) {
                    id = data
                    return meta.row + meta.settings._iDisplayStart + 1;
                }},
                { data: 'kd_nota', name: 'kd_nota'},
                { data: 'tgl_transaksi', name: 'tgl_transaksi'},
                { data: 'nama_pembayaran', name: 'nama_pembayaran'},
                { data: 'nama_pembayar', name: 'nama_pembayar'},
                { data: 'jumlah_bayar', name: 'jumlah_bayar', render: function(data){
                    return "Rp. "+Intl.NumberFormat().format(data)
                }},
                { data: 'nama_siswa', name: 'nama_siswa', render: function(data, type, row, meta){
                    return data == null ? '-' : row.nis+'<br>'+row.nama_siswa
                }},
                { data: 'keterangan', name: 'keterangan'}
            ]
        });
    });
</script>
<script>
    function jenisexport(){
        var jenis_export = document.getElementById('jenis_export').value

        if(jenis_export == 1){
            document.getElementById('form_tgl').removeAttribute('class')
        }else{
            document.getElementById('form_tgl').setAttribute('class', 'd-none')
        }
    }
</script>
@endpush