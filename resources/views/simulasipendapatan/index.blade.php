@extends('layouts.app')

@push('style')

<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('adminlte/plugins/toastr/toastr.min.css') }}">
@endpush

@push('simulasipendapatan')
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
                                <li class="breadcrumb-item active">Simulasi Pendapatan</li>
                            </ol>
                        </div>
                        <div class="col-sm-6">
                            <h1 class="float-sm-right"><i class="fas fa-cog"></i> Simulasi Pendapatan</h1>
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
                    <button class="btn btn-sm btn-warning">Simulasi Pendapatan Tahun Ajaran 2021/2022</button>
                    <a href="{{ url('tambahsimulasipendapatan') }}" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> Buat Simulasi</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                    <table width="100%" id="table-rombel" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kelas</th>
                                <th>Jumlah Siswa</th>
                                <th>Pendapatan Awal</th>
                                <th>Keringanan</th>
                                <th>Total</th>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>
                                    Kelas I<br>
                                    Setingkat SD/MI/Ula
                                </td>
                                <td>30 Orang</td>
                                <td>
                                    Rp. 180.000.000
                                </td>
                                <td>
                                    -Rp. 3.024.000
                                </td>
                                <td><?php echo 'Rp. '.number_format(180000000 - 3024000); ?><br>                                    
                                    <span class="badge badge-info">Lihat Detail Keringanan</span>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>
                                    Kelas II<br>
                                    Setingkat SD/MI/Ula
                                </td>
                                <td>25 Orang</td>
                                <td>
                                    Rp. 150.000.000
                                </td>
                                <td>
                                    -Rp. 2.024.000
                                </td>
                                <td>
                                    <?php echo 'Rp. '.number_format(150000000 - 2024000); ?>
                                    <br><span class="badge badge-info">Lihat Detail Keringanan</span>
                                </td>
                            </tr>
                            <tr>
                                <th colspan="2">Total</th>
                                <th>55 Orang</th>
                                <th>Rp. 230.000.000</th>
                                <th>-Rp. 5.048.000</th>
                                <th><?php echo 'Rp. '.number_format(230000000 - 5048000); ?></th>
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
@endpush