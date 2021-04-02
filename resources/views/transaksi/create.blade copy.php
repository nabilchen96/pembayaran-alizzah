@extends('layouts.app')

@push('style')
<link rel="stylesheet" href="{{ asset('adminlte/plugins/toastr/toastr.min.css') }}">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
@endpush

@push('master')
    menu-open
@endpush

@section('content')

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
                                <li class="breadcrumb-item active">Tambah Siswa</li>
                            </ol>
                        </div>
                        <div class="col-sm-6">
                            <h1 class="float-sm-right"><i class="fas fa-cog"></i> Tambah Siswa</h1>
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
                    <a href="{{ url('siswa') }}" class="btn btn-sm btn-primary"><i class="fas fa-arrow-left"></i> Kembali</a>
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
                    <form action="" method="post">
                        <div class="control-group after-add-more">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Pembayaran</label>
                                <div class="col-sm-7">
                                    <select name="id_jenis_pembayaran[]" class="form-control" onchange="ambil_data_pembayaran()">
                                        <option value="">----</option>
                                        @foreach ($pembayaran as $item)
                                            <option value="{{$item->id_jenis_pembayaran}}">{{$item->nama_pembayaran}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Kelas</label>
                                <div class="col-sm-7">
                                    <select name="id_set_pembayaran_kelas[]" class="form-control" id="id_set_pembayaran_kelas"></select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Jumlah Bayar</label>
                                <div class="col-sm-7">
                                    <input type="number" class="form-control">
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-7">
                                    <button class="btn btn-sm btn-success add-more" type="button"><i class="fas fa-plus"></i> Tambah Pembayaran</button>
                                    {{-- <button class="btn btn-sm btn-success" id="tes" type="button"><i class="fas fa-plus"></i> Tes</button> --}}
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nama Pembayar</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" name="nama_pembayar">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Keterangan</label>
                            <div class="col-sm-7">
                                <textarea name="keterangan" rows="5" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label"></label>
                            <div class="col-sm-7">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>

                    <div class="copy d-none">
                        <div class="control-group">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Pembayaran</label>
                                <div class="col-sm-7">
                                    <select name="id_jenis_pembayaran[]" class="form-control" id="id_jenis_pembayaran" onchange="ambil_data_pembayaran()">
                                        <option value="">----</option>
                                        @foreach ($pembayaran as $item)
                                            <option value="{{$item->id_jenis_pembayaran}}">{{$item->nama_pembayaran}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Kelas</label>
                                <div class="col-sm-7">
                                    <select name="id_set_pembayaran_kelas[]" class="form-control" id="kelas_biaya"></select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Jumlah Bayar</label>
                                <div class="col-sm-7">
                                    <input type="number" class="form-control">
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-7">
                                    <button class="btn btn-sm btn-danger remove" type="button"><i class="fas fa-trash"></i> Remove Pembayaran</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('script')
<script src="{{ asset('adminlte/plugins/toastr/toastr.min.js') }}"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script>
    @if($message = Session::get('gagal'))
        toastr.error("{{ $message }}")
    @endif
</script>
<script type="text/javascript">

    let count = 0;

    $(document).ready(function() {
      $(".add-more").click(function(){ 
          var html = $(".copy").html();
          $(".after-add-more").after(html);
          document.getElementById('kelas_biaya').classList.add('kelas'+count++);
      });
      $("body").on("click",".remove",function(){ 
          $(this).parents(".control-group").remove();
      });
    });

    function ambil_data_pembayaran(){
        var id_jenis_pembayaran = $("#id_jenis_pembayaran").val();

        $.ajax({
            url: 'setpembayarankelas-json',
            data:"id_jenis_pembayaran="+id_jenis_pembayaran,
        }).success(function (data) {
            var json = data,
            obj = JSON.parse(json);

            for(var i = 0; i < obj.length; i++){
                $('.kelas'+i).append($("<option>"+obj[i].kelas+"/"+obj[i].jenjang+" - Biaya :"+obj[i].biaya+"</option>"))
            }
        });
    }
</script>
@endpush