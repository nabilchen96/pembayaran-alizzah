@extends('layouts.app')

@push('style')
<link rel="stylesheet" href="{{ asset('adminlte/plugins/toastr/toastr.min.css') }}">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
@endpush

@push('transaksi')
active
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
                                <li class="breadcrumb-item active">Detail Transaksi</li>
                            </ol>
                        </div>
                        <div class="col-sm-6">
                            <h1 class="float-sm-right"><i class="fas fa-cog"></i> Detail Transaksi</h1>
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
                    <a href="{{ url('transaksi') }}" class="btn btn-sm btn-primary"><i class="fas fa-arrow-left"></i> Kembali</a>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div>
                        <div class="control-group">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Nama Pembayar</label>
                                <div class="col-sm-7">
                                    <input type="text" disabled class="form-control" value="{{ $data->nama_pembayar }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Kode Nota</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" value="{{ $data->kd_nota }}" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Tgl Bayar</label>
                                <div class="col-sm-7">
                                    <input type="date" class="form-control" value="{{ $data->tgl_transaksi }}" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Kelas</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" value="{{ $data->kelas }}/{{ $data->jenjang }}" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Siswa</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" value="{{ $data->nama_siswa }}" disabled>
                                </div>
                            </div>
                            @foreach ($transaksi as $t)
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">{{ $t->nama_pembayaran }}</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" value="Rp. {{ number_format($t->jumlah_bayar) }}" disabled>
                                    </div>
                                </div>
                            @endforeach
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Keterangan</label>
                                <div class="col-sm-7">
                                    <textarea name="keterangan" class="form-control" rows="5" disabled>{{ $data->keterangan }}</textarea>
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
@endpush