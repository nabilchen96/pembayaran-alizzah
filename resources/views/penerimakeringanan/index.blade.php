@extends('layouts.app')

@push('style')

<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('adminlte/plugins/toastr/toastr.min.css') }}">

@endpush

@push('penerimakeringanan')
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
                                <li class="breadcrumb-item active">Keringanan</li>
                            </ol>
                        </div>
                        <div class="col-sm-6">
                            <h1 class="float-sm-right"><i class="fas fa-cog"></i> Keringanan</h1>
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
                    {{-- <a href="#" class="btn btn-sm btn-success"><i class="fas fa-file-excel"></i> Export</a> --}}
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
                    <table width="100%" id="table-rombel" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th width="20px">No</th>
                                <th>Keringanan</th>
                                <th>Besaran Keringanan</th>
                                <th>Untuk Pembayaran</th>
                                <th>Jumlah Penerima</th>
                                <th width="">Action</th>
                            </tr>
                        </thead>
                        @foreach ($keringanan as $k => $item)
                            <tr>
                                <td>{{ $k+1 }}</td>
                                <td>{{ $item->keringanan }}</td>
                                <td>Rp. {{ number_format($item->besaran_keringanan) }}</td>
                                <td>{{ $item->nama_pembayaran }}</td>
                                <td>
                                    <?php 
                                        echo DB::table('penerima_keringanans')
                                            ->join('tahun_ajarans', 'tahun_ajarans.id_tahun', '=', 'penerima_keringanans.id_tahun')
                                            ->where('id_keringanan', $item->id_keringanan)
                                            ->where('tahun_ajarans.status_aktif', '1')
                                            ->where('status_penerima', 1)
                                            ->count();
                                    ?>
                                    Orang
                                </td>
                                <td>
                                    <form method="get" action="{{ url('detailpenerimakeringanan')}}">
                                        <input type="hidden" name="id_keringanan" value="{{ $item->id_keringanan }}">
                                        <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i> Cek Penerima Kerignanan</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
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
    $(function () {
      $('#table-rombel').DataTable({
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