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
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Kelas</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" value="Kelas I">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Jenjang</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" value="Setingakat SD/MI/Ula">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Tahun Ajaran</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" value="Tahun Ajaran 2020/2021">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <span class="badge badge-warning">Perhitungan Pendapatan Awal</span>
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
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Pembayaran</label>
                        <label class="col-sm-2 col-form-label">Biaya</label>
                        <label class="col-sm-1 col-form-label"></label>
                        <label class="col-sm-1 col-form-label">Pertahun</label>
                        <label class="col-sm-1 col-form-label"></label>
                        <label class="col-sm-1 col-form-label">Total</label>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">SPP</label>
                        <div class="col-sm-2">
                            <input type="text" value="Rp. 500.000" class="form-control">
                        </div>
                        <label class="col-sm-1 col-form-label text-center">(x)</label>
                        <div class="col-sm-1">
                            <input type="text" value="12" class="form-control">
                        </div>
                        <label class="col-sm-1 col-form-label text-center">=</label>
                        <div class="col-sm-2">
                            <input type="text" value="Rp. 6.000.000" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Uang Makan</label>
                        <div class="col-sm-2">
                            <input type="text" value="Rp. 500.000" class="form-control">
                        </div>
                        <label class="col-sm-1 col-form-label text-center">(x)</label>
                        <div class="col-sm-1">
                            <input type="text" value="12" class="form-control">
                        </div>
                        <label class="col-sm-1 col-form-label text-center">=</label>
                        <div class="col-sm-2">
                            <input type="text" value="Rp. 6.000.000" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-9">
                            <hr>
                        </div>
                        <div class="col-sm-1">
                            <strong class="float-left">(+)</strong>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-5 col-form-label"></label>
                        <label class="col-sm-1 col-form-label">Sub Total</label>
                        <label class="col-sm-1 col-form-label text-center">=</label>
                        <div class="col-sm-2">
                            <input type="text" value="Rp. 12.000.000" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-5 col-form-label"></label>
                        <label class="col-sm-1 col-form-label">Total Siswa</label>
                        <label class="col-sm-1 col-form-label text-center">=</label>
                        <div class="col-sm-2">
                            <input type="text" value="30 Orang" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-9">
                            <hr>
                        </div>
                        <div class="col-sm-1">
                            <strong class="float-left">(x)</strong>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-5 col-form-label"></label>
                        <label class="col-sm-1 col-form-label">Total</label>
                        <label class="col-sm-1 col-form-label text-center">=</label>
                        <div class="col-sm-2">
                            <input type="text" value="Rp. 360.000.000" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <span class="badge badge-warning">Perhitungan Keringanan</span>
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
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Pembayaran</label>
                        <label class="col-sm-2 col-form-label">Biaya</label>
                        <label class="col-sm-1 col-form-label"></label>
                        <label class="col-sm-1 col-form-label">Pertahun</label>
                        <label class="col-sm-1 col-form-label"></label>
                        <label class="col-sm-1 col-form-label">Penerima</label>
                        <label class="col-sm-1 col-form-label"></label>
                        <label class="col-sm-1 col-form-label">Total</label>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">SPP</label>
                        <div class="col-sm-2">
                            <input type="text" value="Rp. 500.000" class="form-control">
                        </div>
                        <label class="col-sm-1 col-form-label text-center">(x)</label>
                        <div class="col-sm-1">
                            <input type="text" value="12" class="form-control">
                        </div>
                        <label class="col-sm-1 col-form-label text-center">(x)</label>
                        <div class="col-sm-1">
                            <input type="text" value="12" class="form-control">
                        </div>
                        <label class="col-sm-1 col-form-label text-center">=</label>
                        <div class="col-sm-2">
                            <input type="text" value="Rp. 6.000.000" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Uang Makan</label>
                        <div class="col-sm-2">
                            <input type="text" value="Rp. 500.000" class="form-control">
                        </div>
                        <label class="col-sm-1 col-form-label text-center">(x)</label>
                        <div class="col-sm-1">
                            <input type="text" value="12" class="form-control">
                        </div>
                        <label class="col-sm-1 col-form-label text-center">(x)</label>
                        <div class="col-sm-1">
                            <input type="text" value="12" class="form-control">
                        </div>
                        <label class="col-sm-1 col-form-label text-center">=</label>
                        <div class="col-sm-2">
                            <input type="text" value="Rp. 6.000.000" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-11">
                            <hr>
                        </div>
                        <div class="col-sm-1">
                            <strong class="float-left">(+)</strong>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-7 col-form-label"></label>
                        <label class="col-sm-1 col-form-label">Sub Total</label>
                        <label class="col-sm-1 col-form-label text-center">=</label>
                        <div class="col-sm-2">
                            <input type="text" value="Rp. 12.000.000" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-7 col-form-label"></label>
                        <label class="col-sm-1 col-form-label">Total Siswa</label>
                        <label class="col-sm-1 col-form-label text-center">=</label>
                        <div class="col-sm-2">
                            <input type="text" value="30 Orang" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-11">
                            <hr>
                        </div>
                        <div class="col-sm-1">
                            <strong class="float-left">(x)</strong>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-7 col-form-label"></label>
                        <label class="col-sm-1 col-form-label">Total</label>
                        <label class="col-sm-1 col-form-label text-center">=</label>
                        <div class="col-sm-2">
                            <input type="text" value="Rp. 360.000.000" class="form-control">
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
<script>
    @if($message = Session::get('gagal'))
        toastr.error("{{ $message }}")
    @endif
</script>
@endpush