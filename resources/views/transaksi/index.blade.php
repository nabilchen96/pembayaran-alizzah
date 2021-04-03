@extends('layouts.app')

@push('style')

<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('adminlte/plugins/toastr/toastr.min.css') }}">
@endpush

@push('transaksi')
    active  
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
                                <li class="breadcrumb-item active">Transaksi</li>
                            </ol>
                        </div>
                        <div class="col-sm-6">
                            <h1 class="float-sm-right"><i class="fas fa-cog"></i> Transaksi</h1>
                        </div>
                    </div>
                </div>
            </div>

        </div><!-- /.container-fluid -->

    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h4>Rp. {{ number_format($harian) }}</h4>

                            <p>Pendapatan Hari Ini</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-coins"></i>
                        </div>
                        <a href="#" class="small-box-footer"></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h4>Rp. {{ number_format($bulanan) }}</h4>

                            <p>Pendapatan Bulan Ini</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-coins"></i>
                        </div>
                        <a href="#" class="small-box-footer"></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h4>Rp. {{ number_format($tahunan) }}</h4>

                            <p>Pendapatan Tahun Ini</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-coins"></i>
                        </div>
                        <a href="#" class="small-box-footer"></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h4>{{ $totals }} Transaksi</h4>

                            <p>Total Transaksi</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-coins"></i>
                        </div>
                        <a href="#" class="small-box-footer"></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <div class="card">
                <div class="card-header">
                    <a href="{{ url('tambah-transaksi') }}" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> Tambah</a>

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
                                <th width="100px">Total Bayar</th>
                                <th>Pembayar</th>
                                <th>Keterangan</th>
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
        let id, tgl_transaksi, pembayaran, jumlah_bayar, nama_pembayar, untuk_siswa;
        $('#table-tahun').DataTable({
            order: [[2, 'DESC']],
            processing: true,
            serverSide: true,
            ajax: 'transaksi-json',
            columns: [
                { data: 'id_transaksi', name:'id_transaksi', render: function (data, type, row, meta) {
                    id = data
                    return meta.row + meta.settings._iDisplayStart + 1;
                }},
                { data: 'kd_nota', name: 'kd_nota' },
                { data: 'tgl_transaksi', name: 'tgl_transaksi' },
                { data: 'total_pembayaran', name: 'total_pembayaran', render: function(data){
                    return "Rp. "+Intl.NumberFormat().format(data)
                } },
                { data: 'nama_pembayar', name: 'nama_pembayar' },
                { data: 'keterangan', name: 'keterangan' },
                { name: 'edit', render: function(data, type, row, meta){
                    return '<a href="{{ url("detail-transaksi") }}/'+row.kd_nota+'" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></a>'
                }},
                {
                    data: null, name: 'cetak', render: function(data, type, row, meta){
                        return `<a href="{{ url('nota') }}/`+row.kd_nota+`" class="btn btn-sm btn-info"><i class="fas fa-print"></i></a>`
                    }
                }
            ]
        });
    });
</script>
@endpush