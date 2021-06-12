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
                                <li class="breadcrumb-item">Rombel</li>
                                <li class="breadcrumb-item active">Detail Rombel {{ $kelas->kelas }}</li>
                            </ol>
                        </div>
                        <div class="col-sm-6">
                            <h1 class="float-sm-right"><i class="fas fa-cog"></i> Rombel {{ $kelas->kelas }}</h1>
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
                    <a class="btn btn-sm btn-primary" href="{{ url('rombel') }}"><i class="fas fa-arrow-left"></i> Kembali</a>
                    <a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambahrombel" href="#"><i class="fas fa-plus"></i> Tambah</a>
                    <a href="{{ url('exportrombel') }}/{{ $kelas->id_kelas }}" class="btn btn-sm btn-success"><i class="fas fa-file-excel"></i> Export</a>
                    <a class="btn btn-sm btn-warning float-right" href="#">{{$kelas->kelas}} {{$tahun->tahun}}</a>

                    <div class="modal fade" id="tambahrombel" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Tambah Peserta Kelas</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="post" action="{{ url('tambahdetailrombel') }}">
                                @csrf
                                <input type="hidden" name="id_kelas" value="{{ $kelas->id_kelas }}">
                                <input type="hidden" name="id_tahun" value="{{ $tahun->id_tahun }}">
                                <div class="modal-body">
                                    <table width="100%" id="table-siswa" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th width="20px">No</th>
                                                <th>NIS</th>
                                                <th>Nama Siswa</th>
                                                <th>JK</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-dismiss="modal">Close</button>
                                    <button id="submit" type="submit" class="btn btn-primary">Tambah</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                    <table width="100%" id="table-rombel" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th width="20px">No</th>
                                <th>NIS</th>
                                <th>Nama Siswa</th>
                                <th>JK</th>
                                <th width="10px"></th>
                            </tr>
                        </thead>

                            @foreach ($rombel as $k => $item)
                            <tr>
                                <td>{{ $k+1 }}</td>
                                <td>{{ $item->nis }}</td>
                                <td>{{ $item->nama_siswa }}</td>
                                <td>{{ $item->jk == 1 ? 'Laki-laki' : 'Perempuan' }}</td>
                                <td>
                                    <a href="#" data-toggle="modal" data-target="#hapussiswa{{$item->id_rombel}}" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
                                    <div class="modal fade" id="hapussiswa{{$item->id_rombel}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Hapus Siswa Rombel</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Yakin Ingin Menghapus {{$item->nama_siswa}} dari Rombel ini ?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="{{ url('hapusdetailrombel') }}/{{$item->id_rombel}}" class="btn btn-danger">Hapus</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
  <script>
    $(function() {
        let id, nis, nama, jk, no_telp, nama_ayah, nama_ibu, alamat
        $('#table-siswa').DataTable({
            processing: true,
            serverSide: true,
            ajax: 'rombel-add-json',
            columns: [
                { data: 'id_siswa', render: function (data){
                    return '<input type="checkbox" class="checkbox-siswa" name="siswa[]" value="'+data+'">'
                }},
                { data: 'id_siswa',     name:'id_siswa',    render: function (data, type, row, meta) {
                    id = data
                    return meta.row + meta.settings._iDisplayStart + 1;
                }},
                { data: 'nis',          name: 'nis',        render: function(data){ return nis = data }},
                { data: 'nama_siswa',   name: 'nama_siswa', render: function(data){ return nama = data }},
                { data: 'jk',           name: 'jk',         render: function(data){ 
                    jk = data 
                    return data == 1 ? 'Laki-laki' : 'Perempuan' 
                }}
            ]
        });
    });
</script>
@endpush