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
                                <li class="breadcrumb-item">Laporan</li>
                                <li class="breadcrumb-item active">Laporan Bayar Bulanan</li>
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

                    {{-- <a id="export"
                        href="@if( @$data_siswa->id_siswa != null) {{ url('laporanpersiswa-export') }}/{{ $data_siswa->id_siswa }}@else
                    # @endif"
                    class="btn btn-sm btn-success">
                    <i class="fas fa-file-excel"></i>
                    Export</a> --}}

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
                        <form action="{{ url('laporanbayarbulanan') }}" method="GET">
                            <div class="form-group row">
                                <label for="" class="col-lg-2">Kelas</label>
                                <select name="id_kelas" class="form-control col-lg-3" required>
                                    <option value="">Pilih Kelas</option>
                                    @foreach ($kelas as $kelas)
                                    <option {{ @$_GET['id_kelas'] == $kelas->id_kelas ? 'selected' : '' }}
                                        value="{{ $kelas->id_kelas }}">{{ $kelas->kelas }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-lg-2">Bulan</label>
                                <select name="bulan" class="form-control col-lg-3" required>
                                    <option value="">Pilih Bulan</option>
                                    <option {{ @$_GET['bulan'] == "1" ? 'selected' : '' }} value="1">Januari</option>
                                    <option {{ @$_GET['bulan'] == "2" ? 'selected' : '' }} value="2">Februari</option>
                                    <option {{ @$_GET['bulan'] == "3" ? 'selected' : '' }} value="3">Maret</option>
                                    <option {{ @$_GET['bulan'] == "4" ? 'selected' : '' }} value="4">April</option>
                                    <option {{ @$_GET['bulan'] == "5" ? 'selected' : '' }} value="5">Mei</option>
                                    <option {{ @$_GET['bulan'] == "6" ? 'selected' : '' }} value="6">Juni</option>
                                    <option {{ @$_GET['bulan'] == "7" ? 'selected' : '' }} value="7">Juli</option>
                                    <option {{ @$_GET['bulan'] == "8" ? 'selected' : '' }} value="8">Agustus</option>
                                    <option {{ @$_GET['bulan'] == "9" ? 'selected' : '' }} value="9">September</option>
                                    <option {{ @$_GET['bulan'] == "10" ? 'selected' : '' }} value="10">Oktober</option>
                                    <option {{ @$_GET['bulan'] == "11" ? 'selected' : '' }} value="11">November</option>
                                    <option {{ @$_GET['bulan'] == "12" ? 'selected' : '' }} value="12">Desember</option>
                                </select>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-lg-2"></label>
                                <button class="btn btn-success" type="submit"><i class="fas fa-search"></i>
                                    Cari</button>
                            </div>
                        </form>
                    </div>
                    <br>
                    <div class="table-responsive">
                        <table width="100%" id="table-siswa" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="20px">No</th>
                                    <th>NIS</th>
                                    <th>Nama Siswa</th>
                                    <th>Transkasi Terakhir</th>
                                    <th>Biaya Bulanan</th>
                                    <th>Status Pembayaran</th>
                                    <th width="20px">History</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data_array as $k => $item)
                                <tr>
                                    <td>{{ $k+1 }}</td>
                                    <td>{{ @$item['nis'] }}</td>
                                    <td>{{ @$item['nama_siswa'] }}</td>
                                    <td>{{ @$item['tgl_transaksi'] != null ? date('d-m-Y', strtotime($item['tgl_transaksi'])) : '' }}
                                    </td>
                                    <td>Rp. {{ @number_format($item['biaya_bulanan']) }}</td>
                                    <td>
                                        @if (@$item['status'] == 'Sudah Dibayar')
                                            <span class="badge badge-success">Sudah Dibayar</span>
                                        @else
                                            <span class="badge badge-danger">Belum Dibayar</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a target="_blank"
                                            href="{{ url('laporanpersiswa') }}?id_siswa={{ @$item['id_siswa'] }}"
                                            class="btn btn-sm btn-success">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
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
<script>
    $(function () {
      $('#table-siswa').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,

      });
    });
</script>
@endpush