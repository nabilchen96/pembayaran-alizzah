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
                                <li class="breadcrumb-item active">Data Master</li>
                                <li class="breadcrumb-item active">Set Gaji</li>
                            </ol>
                        </div>
                        <div class="col-sm-6">
                            <h1 class="float-sm-right"><i class="fas fa-cog"></i> Set Gaji</h1>
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
                    <a href="#" data-toggle="modal" data-target="#tambah" class="btn btn-sm btn-primary"><i
                            class="fas fa-plus"></i> Tambah</a>
                    <a href="{{ url('setgaji-export') }}" class="btn btn-sm btn-success"><i
                            class="fas fa-file-excel"></i> Export</a>

                    <div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Tambah Set Gaji</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ url('tambahsetgaji') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Pegawai</label>
                                            <select name="id_pegawai" class="form-control" required>
                                                @foreach ($data as $item)
                                                <option value="{{ $item->id_pegawai }}">
                                                    {{ $item->nip }}/{{ $item->nama_pegawai }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Jumlah Gaji</label>
                                            <input type="number" id="result" class="form-control" required disabled>
                                        </div>
                                        <div class="form-group after-add-more">
                                            <label for="recipient-name" class="col-form-label">Rincian</label>
                                            <div class="row">
                                                <div class="col-6">
                                                    <input type="text" name="jenis_rincian[]" class="form-control"
                                                        placeholder="Jenis Rincian" required>
                                                </div>
                                                <div class="col-4">
                                                    <input type="text" name="gaji_rincian[]" oninput="calculateTotal()"
                                                        class="form-control gajian" placeholder="Rp. 0" required>
                                                </div>
                                                <div class="col-2">
                                                    <button id="button_tambah" type="button" class="btn btn-primary btn-block"><i class="fas fa-plus"></i></button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-none copy">
                                            <div class="form-group ">
                                                <div class="row mt-2">
                                                    <div class="col-6">
                                                        <input type="text" class="form-control"
                                                            placeholder="Jenis Rincian" name="jenis_rincian[]"
                                                            placeholder="Jenis Rincian">
                                                    </div>
                                                    <div class="col-4">
                                                        <input type="text" name="gaji_rincian[]"
                                                            oninput="calculateTotal()" class="form-control gajian"
                                                            placeholder="Rp. 0">
                                                    </div>
                                                    <div class="col-2">
                                                        <button class="btn btn-danger btn-block remove"><i class="fas fa-trash"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="copy-area"></div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
                        <table width="100%" id="table-setgaji" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="20px">No</th>
                                    <th>NIP</th>
                                    <th>Nama Pegawai</th>
                                    <th>Jumlah Gaji</th>
                                    <th>Keterangan</th>
                                    <th width="10px"></th>
                                    <th width="10px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($gaji as $k => $item)
                                <tr>
                                    <td>{{ $k+1 }}</td>
                                    <td>{{ $item->nip }}</td>
                                    <td>{{ $item->nama_pegawai }}</td>
                                    <td>{{ 'Rp. '.number_format($item->gaji_rincian) }}</td>
                                    <td>
                                        <?php
                                                $rincian = DB::table('set_gajis')->where('id_pegawai', $item->id_pegawai)->get();
                                                foreach ($rincian as $key => $value) {
                                                    echo '<span class="badge badge-success">'.$value->jenis_rincian.' : Rp'.number_format($value->gaji_rincian).'</span><br>';    
                                                }
                                            ?>
                                    </td>
                                    <td>
                                        <a href="{{ url('editgaji') }}/{{ $item->id_pegawai }}" class="btn btn-sm btn-success"><i class="fas fa-edit"></i></a>
                                    </td>
                                    <td>
                                        <button class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#hapus{{ $item->id_pegawai }}"><i class="fas fa-trash"></i></button>
                                        <div class="modal fade" id="hapus{{ $item->id_pegawai }}" tabindex="-1" role="dialog"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Hapus Data Gaji</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Yakin Ingin Menghapus Data Gaji ini ?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                        <a href="{{ url('hapusgaji') }}/{{ $item->id_pegawai }}"
                                                            class="btn btn-danger">Hapus</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
<script>
    @if($message = Session::get('sukses'))
        toastr.success("{{ $message }}")
    @elseif($message = Session::get('gagal'))
        toastr.error("{{ $message }}")
    @endif
</script>
<script>
    $(document).ready(function() {
        $('table').DataTable();

      $("#button_tambah").click(function(){ 
          var html = $(".copy").html();
          $("#copy-area").before(html);
      });

      $("body").on("click",".remove",function(){ 
            $(this).parents(".form-group").remove();
            calculateTotal()
      });
    })

    function calculateTotal(){
        var total = 0;
        $('.gajian').each(function(){
            if (!isNaN(this.value) && this.value.length != 0) {
                total += parseFloat(this.value);
            }

            document.getElementById('result').value = total
        })
    }
        
</script>
@endpush