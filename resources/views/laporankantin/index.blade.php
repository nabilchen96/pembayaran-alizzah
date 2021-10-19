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
                                <li class="breadcrumb-item active">Laporan Kantin</li>
                            </ol>
                        </div>
                        <div class="col-sm-6">
                            <h1 class="float-sm-right"><i class="fas fa-cog"></i> Laporan Kantin</h1>
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
                    <form action="{{ url('laporankantin') }}" method="GET">
                        <div class="form-group">
                            <div class="form-group row">
                                <label for="" class="col-lg-2">Tanggal Awal</label>
                                <input type="date" value="{{ @$_GET['tgl_awal'] }}" name="tgl_awal" class="col-lg-3 form-control">
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-lg-2">Tanggal Akhir</label>
                                <input type="date" name="tgl_akhir" value="{{ @$_GET['tgl_akhir'] }}" class="col-lg-3 form-control">
                            </div>        
                            <div class="form-group row">
                                <label for="" class="col-lg-2"></label>
                                <button class="btn btn-sm btn-primary">
                                    <i class="fas fa-search"></i> &nbsp;
                                    Tampilkan
                                </button>&nbsp;
                                @if (@$_GET['tgl_awal'] && @$_GET['tgl_akhir'])                                    
                                    <a href="{{ url('laporankantin-export') }}/{{ @$_GET['tgl_awal'] }}/{{ @$_GET['tgl_akhir'] }}" class="btn btn-sm btn-success">
                                        <i class="fas fa-file-excel"></i> &nbsp;
                                        Export
                                    </a>
                                @endif
                            </div>                      
                        </div>
                    </form>
                    <br>
                    <div class="table-responsive">
                        <table width="100%" id="table-laporan" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="20px">No</th>
                                    <th>Tanggal</th>
                                    <th>NIS</th>
                                    <th>Nama Siswa</th>
                                    <th>Keterangan</th>
                                    <th>Jumlah Transaksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $k => $item)
                                    <tr>
                                        <td>{{ $k+1 }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>{{ $item->nis }}</td>
                                        <td>{{ $item->nama_siswa }}</td>
                                        <td>{{ $item->keterangan }}</td>
                                        <td>Rp. {{ number_format($item->jumlah) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
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
        $('#table-laporan').DataTable();
    });
</script>
@endpush