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
                                <li class="breadcrumb-item active">Tambah Pengeluaran</li>
                            </ol>
                        </div>
                        <div class="col-sm-6">
                            <h1 class="float-sm-right"><i class="fas fa-cog"></i> Pengeluaran</h1>
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
                    <form action="{{ url('tambahpengeluaranlain') }}" method="post">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Tanggal<sup class="text-red">*</sup></label>
                            <div class="col-sm-7">
                            <input type="date" class="form-control @error('tgl_pengeluaran') is-invalid @enderror" value="{{ date("Y-m-d") }}" placeholder="Tanggal" name="tgl_pengeluaran">
                            @error('tgl_pengeluaran')
                                <p class="text-red">{{ $message }}</p>
                            @enderror 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Keterangan<sup class="text-red">*</sup></label>
                            <div class="col-sm-7">
                            <textarea name="keterangan" class="form-control" rows="5"></textarea>
                            @error('keterangan')
                                <p class="text-red">{{ $message }}</p>
                            @enderror 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">QTY<sup class="text-red">*</sup></label>
                            <div class="col-sm-7">
                                <input type="number" class="form-control" name="qty" id="qty" onchange="hitungtotalharga()">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Harga Satuan<sup class="text-red">*</sup></label>
                            <div class="col-sm-7">
                                <input type="number" class="form-control" name="harga_satuan" id="harga_satuan" onkeyup="hitungtotalharga()">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Total Harga<sup class="text-red">*</sup></label>
                            <div class="col-sm-7">
                                <input type="number" class="form-control" name="total_harga" id="total_harga" readonly>
                            </div>
                        </div>
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
</script>
<script>
    function hitungtotalharga(){
        var qty = document.getElementById('qty').value
        var harga_satuan = document.getElementById('harga_satuan').value

        document.getElementById('total_harga').value = qty * harga_satuan 
    }
</script>
@endpush