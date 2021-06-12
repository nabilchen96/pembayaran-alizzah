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
                                <li class="breadcrumb-item">Keringanan</li>
                                <li class="breadcrumb-item active">Daftar Penerima Keringanan</li>
                            </ol>
                        </div>
                        <div class="col-sm-6">
                            <h1 class="float-sm-right"><i class="fas fa-cog"></i> Daftar Penerima Keringanan</h1>
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
                    <form method="get" action="{{ url('tambahpenerimakeringanan') }}">
                        <a class="btn btn-sm btn-primary" href="{{ url('penerimakeringanan') }}"><i
                                class="fas fa-arrow-left"></i> Kembali</a>

                        <input type="hidden" name="id_keringanan" value="{{ $keringanan->id_keringanan }}">

                        <?php
                            $tahun = DB::table('tahun_ajarans')->where('status_aktif', 1)->first();
                            $tahun = date('m', strtotime($tahun->tgl_mulai));
                        ?>
                        @if ( $tahun == date('m') )
                        <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> Tambah</button>
                        @else
                        <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambah"><i
                                class="fas fa-plus"></i> Tambah</a>
                        <div class="modal fade" id="tambah" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Pesan Kesalahan</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>
                                            Tidak Dapat melakukan pendaftaran penerima keringanan. Penerima keringanan hanya dapat ditambah di setiap awal tahun ajaran.
                                            
                                        </p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <a href="{{ url('penerimakeringanan-export') }}/{{ $keringanan->id_keringanan }}"
                            class="btn btn-sm btn-success"><i class="fas fa-file-excel"></i> Export</a>

                        <a class="btn btn-sm btn-warning float-right" href="#"> Daftar Penerima
                            {{ $keringanan->keringanan }}</a>
                    </form>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table width="100%" id="table-rombel" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="20px">No</th>
                                    <th>NIS</th>
                                    <th>Nama Siswa</th>
                                    <th>Status Penerima</th>
                                    <th>Berkas Keringanan</th>
                                    <th>Alasan Keringanan</th>
                                    <th width="10px"></th>
                                    <th width="10px"></th>
                                </tr>
                            </thead>
                            @foreach ($penerimakeringanan as $k => $item)
                            <tr>
                                <td>{{ $k+1 }}</td>
                                <td>{{ $item->nis }}</td>
                                <td>{{ $item->nama_siswa }}</td>
                                @if ($item->status_penerima == 1)
                                <td><span class="badge badge-success">Aktif</span></td>
                                @else
                                <td><span class="badge badge-danger">Tidak Aktif</span></td>
                                @endif
                                <td><a href="{{ asset('file_upload') }}/{{ $item->berkas_keringanan }}">Berkas
                                        Keringanan</a></td>
                                <td>{{ $item->alasan_keringanan }}</td>
                                <td>
                                    <form action="{{ url('editpenerimakeringanan') }}" method="GET">
                                        <input type="hidden" name="id_penerima_keringanan"
                                            value="{{ $item->id_penerima_keringanan }}">
                                        <input type="hidden" name="id_keringanan" value="{{ $item->id_keringanan }}">
                                        <button type="submit" class="btn btn-sm btn-success"><i
                                                class="fas fa-edit"></i></button>
                                    </form>
                                </td>
                                <td>
                                    <button class="btn btn-danger btn-sm" data-toggle="modal"
                                        data-target="#hapuspenerimakeringanan{{ $item->id_penerima_keringanan }}"><i
                                            class="fas fa-trash"></i></button>
                                    <div class="modal fade"
                                        id="hapuspenerimakeringanan{{ $item->id_penerima_keringanan }}" tabindex="-1"
                                        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Hapus Penerima
                                                        Keringanan</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Yakin Ingin Menghapus Data Penerima Keringanan ?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                    <a href="{{ url('hapuspenerimakeringanan') }}/{{ $item->id_penerima_keringanan }}"
                                                        class="btn btn-danger">Hapus</a>
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
            ajax: 'siswa-json',
            columns: [
                { data: 'id_siswa', render: function (data){
                    return '<input type="checkbox" class="form-control checkbox-siswa" name="siswa[]" value="'+data+'">'
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