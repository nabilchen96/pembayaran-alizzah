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
                    <a href="{{ url('siswa') }}" class="btn btn-sm btn-primary"><i class="fas fa-arrow-left"></i>
                        Kembali</a>
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
                    <form action="{{ url('tambahgajipegawai') }}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Tanggal <sup class="text-red">*</sup></label>
                            <div class="col-sm-7">
                                <input type="date" class="form-control @error('tgl_pengeluaran') is-invalid @enderror"
                                    placeholder="Tanggal Pengeluaran" name="tgl_pengeluaran" value="{{ date("Y-m-d") }}" required>
                                @error('tgl_pengeluaran')
                                <p class="text-red">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Pilih Pegawai <sup class="text-red">*</sup></label>
                            <div class="col-sm-7">
                                <div class="table-responsive">
                                    <table width="100%" id="table-gaji" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th width="20px">
                                                    <input type="checkbox" class="cek" onclick="selectall(this)">
                                                </th>
                                                <th width="20px">No</th>
                                                <th>NIP</th>
                                                <th>Nama Pegawai</th>
                                                <th>Jenis Pegawai</th>
                                                <th>Total Gaji</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $k => $item)
                                            <tr>
                                                <td><input type="checkbox" class="cek" name="id_pegawai[]"
                                                        value="{{ $item->id_pegawai }}"></td>
                                                <td>{{ $k+1 }}</td>
                                                <td>{{ $item->nip }}</td>
                                                <td>{{ $item->nama_pegawai }}</td>
                                                <td>{{ $item->jenis_pegawai }}</td>
                                                <td>{{ 'Rp. '.number_format($item->total_gaji) }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <button class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> Tambah</button>
                    </form>
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
      $('#table-gaji').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
      });
    });
</script>
<script>
    function selectall(source){
          checkboxes = document.getElementsByClassName('cek')
          for(var i=0, n=checkboxes.length;i<n;i++) {
                checkboxes[i].checked = source.checked;
                // console.log(checkboxes[i].value)
            }
      }
</script>
@endpush