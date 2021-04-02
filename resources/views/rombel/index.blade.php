@extends('layouts.app')

@push('style')

<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('adminlte/plugins/toastr/toastr.min.css') }}">
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
                                <li class="breadcrumb-item active">Rombel</li>
                            </ol>
                        </div>
                        <div class="col-sm-6">
                            <h1 class="float-sm-right"><i class="fas fa-cog"></i> Rombel</h1>
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
                    <div class="table-responsive">
                    <table width="100%" id="table-rombel" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th width="20px">No</th>
                                <th>Kelas</th>
                                <th>Jenjang</th>
                                <th>Total Siswa</th>
                                <th width="">Action</th>
                            </tr>
                        </thead>

                            @foreach ($kelas as $k => $item)
                            <tr>
                                <td>{{ $k+1 }}</td>
                                <td>{{ $item->kelas }}</td>
                                <td>{{ $item->jenjang }}</td>
                                <td>
                                    <?php echo $jmlsiswa = DB::table('rombels')
                                                            ->join('tahun_ajarans', 'tahun_ajarans.id_tahun', '=', 'rombels.id_tahun')
                                                            ->where('id_kelas', $item->id_kelas)
                                                            ->where('tahun_ajarans.status_aktif', 1)->count(); ?> Orang
                                </td>
                                <td>
                                    <?php $cektahun = DB::table('tahun_ajarans')->where('status_aktif', 1)->count(); ?>
                                    @if ($cektahun < 1)
                                        <span class="badge badge-danger">Aktifkan Tahun Untuk Menambah Siswa Rombel</span>
                                    @else
                                        <form method="get" action="{{ url('detailrombel')}}">
                                            {{-- @csrf --}}
                                            <input type="hidden" name="id_kelas" value="{{ $item->id_kelas }}">
                                            <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i> Daftar Rombel</button>
                                        </form>
                                    @endif
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