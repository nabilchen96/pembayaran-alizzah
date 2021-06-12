@extends('layouts.app')

@push('style')

<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('adminlte/plugins/toastr/toastr.min.css') }}">
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
                                <li class="breadcrumb-item active">Laporan Tunggakan</li>
                            </ol>
                        </div>
                        <div class="col-sm-6">
                            <h1 class="float-sm-right"><i class="fas fa-cog"></i> Laporan Tunggakan</h1>
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

                    <a id="export" href="#" class="btn btn-sm btn-success"><i class="fas fa-file-excel"></i> Export</a>

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
                    <?php $tahun = DB::table('tahun_ajarans')->where('status_aktif', 1)->count(); ?>
                    @if ($tahun == 0)
                        <span class="badge badge-danger">Aktifkan Tahun Ajaran Terlebih Dahulu untuk Melihat Laporan</span>
                        <br>
                    @else
                        <div class="form-group row">
                            <div class="col-sm-3">
                                <select id="id_pembayaran" name="id_jenis_pembayaran" class="form-control">
                                    @foreach ($pembayaran as $item)
                                        <option value="{{ $item->id_jenis_pembayaran }}">{{ $item->nama_pembayaran}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-2"> 
                                <button onclick="getpembayaran()" class="btn btn btn-primary"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    @endif
                    <br>
                    <div class="table-responsive">
                        <table width="100%" id="table-tahun" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="20px">No</th>
                                    <th>NIS</th>
                                    <th>Nama Siswa</th>
                                    <th>Kelas</th>
                                    {{-- <th>Total Tunggakan</th> --}}
                                    <th>Total Hutang</th>
                                    {{-- status tunggakan = 2 bulan menunggak  --}}
                                    {{-- <th width="10px"></th> --}}
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
<script>
        function getpembayaran() {
            var id = document.getElementById('id_pembayaran').value
            var a = document.getElementById('export');
                a.href = "{{ url('laporantunggakan-export')}}/"+id

        $('#table-tahun').DataTable({
            bDestroy: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: 'laporantunggakan-json',
                data: {
                    'id_jenis_pembayaran' : id
                }
            },
            columns: [
                { data: 'id_siswa',     name:'id_siswa',    render: function (data, type, row, meta) {
                    id = data
                    return meta.row + meta.settings._iDisplayStart + 1;
                }},
                { data: 'nis', name: 'nis'},
                { data: 'nama_siswa', name: 'nama_siswa'},
                { data: 'kelas', name: 'kelas', render: function(data){
                    return data == 0 ? 'Data Kelas Belum Diset' : data
                }},
                // { data: 'total_tunggakan', name: 'total_tunggakan', render: function(data, type, row, meta){
                //     if(!row.spp){
                //         return 'Pembayaran Kelas Belum Diset'
                //     }else{
                //         return data+' Bulan Menunggak'
                //     }
                // }},
                { data: 'hutang_tunggakan', name: 'hutang_tunggakan', render: function(data, type, row, meta){
                    if(row.spp == null){
                        return 'Pembayaran Kelas Belum Diset'
                    }else if(data == 0){
                        return 'Tidak Ada Hutang Tunggakan'
                    }else{
                        return data == 0 ? 'Pembayaran Kelas Belum Diset' : "Rp. "+Intl.NumberFormat().format(data)
                    }
                }},
                // { name: 'surat', render: function(data, type, row, meta){
                //     return '<a href="{{ url("surat-tunggakan") }}/'+row.id_siswa+'" class="btn btn-sm btn-danger"><i class="fas fa-envelope"></i></a>'
                // }}
            ]
        });
    }
    // );
</script>
@endpush