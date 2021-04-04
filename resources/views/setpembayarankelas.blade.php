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
                                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                <li class="breadcrumb-item active">Data Master</li>
                                <li class="breadcrumb-item active">Jenis Pembayaran</li>
                                <li class="breadcrumb-item active">Set Pembayaran Kelas</li>
                            </ol>
                        </div>
                        <div class="col-sm-6">
                            <h1 class="float-sm-right"><i class="fas fa-cog"></i> {{ $jenispembayaran->nama_pembayaran }}</h1>
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
                    <a href="{{ url('jenispembayaran') }}" class="btn btn-sm btn-primary"><i class="fas fa-arrow-left"></i> Kembali</a>
                    <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambahpembayarankelas"><i class="fas fa-plus"></i> Tambah</a>
                    <div class="modal fade" id="tambahpembayarankelas" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Tambah Kelas</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="formtambah" action="{{ url('tambahpembayarankelas') }}" method="post">
                                @csrf
                                <input type="hidden" name="id_jenis_pembayaran" value="{{ $jenispembayaran->id_jenis_pembayaran }}">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label class="col-form-label">Jenis Pembayaran</label>
                                        <input type="text" class="form-control" value="{{ $jenispembayaran->nama_pembayaran }}" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Kelas</label>
                                        <select class="form-control" name="id_kelas" required>
                                            <option value="">----</option>
                                            @foreach ($kelas as $item)
                                                <option value="{{ $item->id_kelas }}">{{ $item->kelas }}/{{ $item->jenjang }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Biaya</label>
                                        <input type="number" name="biaya" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Keterangan</label>
                                        <textarea name="keterangan" rows="3" class="form-control"></textarea>
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
                    <table width="100%" id="table-pembayaran-kelas" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th width="20px">No</th>
                                <th>Kelas</th>
                                <th>Jenjang</th>
                                <th>Biaya</th>
                                <th>Keterangan</th>
                                <th width="10px"></th>
                                <th width="10px"></th>
                            </tr>
                        </thead>
                        @foreach ($setpembayarankelas as $k => $item)
                        <tr>
                            <td>{{ $k+1 }}</td>
                            <td>{{ $item->kelas }}</td>
                            <td>{{ $item->jenjang }}</td>
                            <td>{{ 'Rp. '.number_format($item->biaya) }}</td>
                            <td>{{ $item->keterangan }}</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-success" data-toggle="modal" data-target="#editpembayarankelas{{$item->id_set_pembayaran_kelas}}"><i class="fas fa-edit"></i></a>
                                <div class="modal fade" id="editpembayarankelas{{$item->id_set_pembayaran_kelas}}" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit Pembayaran Kelas</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form id="formtambah" action="{{ url('editpembayarankelas') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="id_set_pembayaran_kelas" value="{{ $item->id_set_pembayaran_kelas }}">
                                            <input type="hidden" name="id_jenis_pembayaran" value="{{ $jenispembayaran->id_jenis_pembayaran }}">
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label class="col-form-label">Jenis Pembayaran</label>
                                                    <input type="text" class="form-control" value="{{ $jenispembayaran->nama_pembayaran }}" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label">Kelas</label>
                                                    <select class="form-control" name="id_kelas">
                                                        <option value="{{ $item->id_kelas }}" selected>{{ $item->kelas }}/{{ $item->jenjang }}</option>
                                                        @foreach ($kelas as $k)
                                                            <option value="{{ $k->id_kelas }}">{{ $k->kelas }}/{{ $k->jenjang }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label">Biaya</label>
                                                    <input type="number" name="biaya" class="form-control" value="{{ $item->biaya }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label">Keterangan</label>
                                                    <textarea name="keterangan" rows="3" class="form-control">{{ $item->keterangan }}</textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary"> Edit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <a href="{{ url('hapuspembayarankelas') }}/{{ $item->id_set_pembayaran_kelas }}" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
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
      $('#table-pembayaran-kelas').DataTable({
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