@extends('layouts.app')

@push('style')

<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('adminlte/plugins/toastr/toastr.min.css') }}">
<link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

@endpush

@push('laporan')
menu-open
@endpush
@push('laporantunggakan')
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
                                <li class="breadcrumb-item">Laporan</li>
                                <li class="breadcrumb-item active">Laporan Persiswa</li>
                            </ol>
                        </div>
                        <div class="col-sm-6">
                            <h1 class="float-sm-right"><i class="fas fa-cog"></i> Laporan Persiswa</h1>
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

                    <a id="export" href="@if( @$data_siswa->id_siswa != null) {{ url('laporanpersiswa-export') }}/{{ $data_siswa->id_siswa }}@else # @endif" class="btn btn-sm btn-success">
                        <i class="fas fa-file-excel"></i> 
                    Export</a>

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
                    <div class="col-lg-12">
                        <form action="{{ url('laporanpersiswa') }}" method="get">
                            <div class="form-group row">
                                <label for="" class="col-lg-2">Cari Siswa</label>
                                <select name="id_siswa" id="carisiswa" class="col-lg-3 form-control" required>
                                    <option value="">Cari Siswa</option>
                                    @foreach ($siswa as $item)
                                        <option value="{{ $item->id_siswa }}">{{ $item->nama_siswa }}</option>
                                    @endforeach
                                </select>
                                <button class="col-lg-1 btn btn-sm btn-success ml-1">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                        <hr>
                        <div class="form-group row">
                            <label for="" class="col-lg-2">Nama Siswa</label>
                            <input type="text" class="col-lg-4 form-control" value="{{ @$data_siswa->nama_siswa }}" disabled>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-lg-2">NIS</label>
                            <input type="text" class="col-lg-4 form-control" value="{{ @$data_siswa->nis }}" disabled>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-lg-2">Kelas</label>
                            <input type="text" class="col-lg-4 form-control" value="{{ @$data_siswa->kelas }} / {{ @$data_siswa->jenjang }}" disabled>
                        </div>
                    </div>
                    <br>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                                aria-controls="home" style="color: black !important;" aria-selected="true">Histori
                                Pembayaran</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <br>
                            <div class="table-responsive">
                                <table width="100%" id="table-tahun" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="20px">No</th>
                                            <th>No Nota</th>
                                            <th>Tanggal Transaksi</th>
                                            <th>Pembayaran</th>
                                            <th>Jumlah Bayar</th>
                                            {{-- <th></th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pembayaran as $k => $item)
                                            <tr>
                                                <td>{{ $k+1 }}</td>
                                                <td>{{ $item->kd_nota }}</td>
                                                <td>{{ date('d-m-Y', strtotime($item->tgl_transaksi)) }}</td>
                                                <td>{{ $item->nama_pembayaran }}</td>
                                                <td>Rp. {{ number_format($item->jumlah_bayar) }}</td>
                                                {{-- <th></th> --}}
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <br>
                            <div class="table-responsive">
                                <table width="100%" id="table-tahun" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="20px">No</th>
                                            <th>Tahun Ajaran</th>
                                            <th>Tunggakan Tahunan</th>
                                            <th>Tunggakan Bulanan</th>
                                            <th>Total Tunggakan</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @foreach ($data as $k => $item)
                                            <tr>
                                                <td>{{ $k+1 }}</td>
                                                <td>{{ $item->tahun_ajaran }}</td>
                                                <td>{{ $item->tunggakan_bulanan }}</td>
                                                <td>{{ $item->tungakan_tahunan }}</td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        @endforeach --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
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
<script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
<script>
    @if($message = Session::get('sukses'))
        toastr.success("{{ $message }}")
    @elseif($message = Session::get('gagal'))
        toastr.error("{{ $message }}")
    @endif
</script>
<script>
    $(document).ready(function() {
        $('#carisiswa').select2({
            theme: 'bootstrap4'
        })
    })
</script>
@endpush