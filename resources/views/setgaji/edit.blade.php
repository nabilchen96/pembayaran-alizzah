@extends('layouts.app')

@push('style')
<link rel="stylesheet" href="{{ asset('adminlte/plugins/toastr/toastr.min.css') }}">
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
                                <li class="breadcrumb-item active">Edit Data Gaji</li>
                            </ol>
                        </div>
                        <div class="col-sm-6">
                            <h1 class="float-sm-right"><i class="fas fa-cog"></i> Edit Gaji</h1>
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
                    <a href="{{ url('setgaji') }}" class="btn btn-sm btn-primary"><i class="fas fa-arrow-left"></i> Kembali</a>
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
                    <form action="{{ url('updategaji') }}" method="post">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">NIP<sup class="text-red">*</sup></label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" placeholder="NIP" disabled value="{{ $data[0]->nip }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nama Pegawai<sup class="text-red">*</sup></label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" placeholder="Nama Lengkap" value="{{ $data[0]->nama_pegawai }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Total Gaji</label>
                            <div class="col-sm-7">
                                <input type="text" id="result" class="form-control" disabled>
                            </div>
                        </div>
                        @foreach ($data as $k => $item)
                        <input type="hidden" name="id_pegawai" value="{{ $item->id_pegawai }}">
                        <input type="hidden" name="id_setgaji_old[]" value="{{ $item->id_setgaji }}">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Rincian dan Gaji {{ $k+1 }}</label>
                            <div class="col-sm-3">
                                <input type="text" name="jenis_rincian_old[]" class="form-control gajian" value="{{ $item->jenis_rincian }}" oninput="calculateTotal()">
                            </div>
                            <div class="col-sm-3">
                                <input type="text" name="gaji_rincian_old[]" class="form-control gajian" value="{{ $item->gaji_rincian }}" oninput="calculateTotal()">
                            </div>
                            <div class="col-sm-1">
                                <a href="{{ url('destroygaji') }}/{{ $item->id_setgaji }}" class="btn btn-danger btn-block"><i class="fas fa-trash"></i></a>
                            </div>
                        </div>
                        @endforeach
                        <div class="form-group row after-add-more">
                            <label class="col-sm-2 col-form-label">Add Rincian dan Gaji</label>
                            <div class="col-sm-3">
                                <input type="text" name="jenis_rincian[]" class="form-control gajian" oninput="calculateTotal()" required>
                            </div>
                            <div class="col-sm-3">
                                <input type="text" name="gaji_rincian[]" class="form-control gajian" oninput="calculateTotal()" requried>
                            </div>
                            <div class="col-1">
                                <button type="button" class="btn btn-primary btn-block"><i
                                        class="fas fa-plus" id="button_tambah"></i></button>
                            </div>
                        </div>

                        <div class="d-none copy">
                            <div class="form-group row mt-2">
                                <label class="col-sm-2 col-form-label">Add Rincian dan Gaji</label>
                                <div class="col-sm-3">
                                    <input type="text" name="jenis_rincian[]" class="form-control gajian" oninput="calculateTotal()">
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" name="gaji_rincian[]" class="form-control gajian" oninput="calculateTotal()">
                                </div>
                                <div class="col-1">
                                    <button class="btn btn-danger btn-block remove"><i
                                            class="fas fa-trash"></i></button>
                                </div>
                            </div>
                        </div>
                        <div id="copy-area"></div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label"></label>
                            <div class="col-sm-7">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('script')
<script src="{{ asset('adminlte/plugins/toastr/toastr.min.js') }}"></script>
<script>
    @if($message = Session::get('gagal'))
        toastr.error("{{ $message }}")
    @endif

    $(document).ready(function(){
        $("#button_tambah").click(function(){ 
            var html = $(".copy").html();
            $("#copy-area").before(html);
        });

        $("body").on("click",".remove",function(){ 
            $(this).parents(".form-group").remove();
            calculateTotal()
        });

        calculateTotal() 
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