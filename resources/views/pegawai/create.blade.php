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
                                <li class="breadcrumb-item active">Tambah Pegawai</li>
                            </ol>
                        </div>
                        <div class="col-sm-6">
                            <h1 class="float-sm-right"><i class="fas fa-cog"></i> Tambah Pegawai</h1>
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
                    <a href="{{ url('pegawai') }}" class="btn btn-sm btn-primary"><i class="fas fa-arrow-left"></i> Kembali</a>
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
                    <form action="{{ url('simpanpegawai') }}" method="post">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">NIP<sup class="text-red">*</sup></label>
                            <div class="col-sm-7">
                            <input type="text" class="form-control @error('nip') is-invalid @enderror" placeholder="NIP" name="nip">
                            @error('nip')
                                <p class="text-red">{{ $message }}</p>
                            @enderror 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">NIK<sup class="text-red">*</sup></label>
                            <div class="col-sm-7">
                            <input type="text" class="form-control @error('nik') is-invalid @enderror" placeholder="NIK" name="nik">
                            @error('nik')
                                <p class="text-red">{{ $message }}</p>
                            @enderror 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nama Lengkap<sup class="text-red">*</sup></label>
                            <div class="col-sm-7">
                            <input type="text" class="form-control @error('nama_pegawai') is-invalid @enderror" placeholder="Nama Lengkap" name="nama_pegawai">
                            @error('nama_pegawai')
                                <p class="text-red">{{ $message }}</p>
                            @enderror 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Jenis Kelamin<sup class="text-red">*</sup></label>
                            <div class="col-sm-7">
                                <select name="jk" class="form-control">
                                    <option value="1">Laki-laki</option>
                                    <option value="0">Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nomor Telpon/Hp</label>
                            <div class="col-sm-7">
                                <input type="number" class="form-control" name="no_telp" placeholder="Nomor Telpon/Hp">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Jenis Pegawai</label>
                            <div class="col-sm-7">
                                <select name="jenis_pegawai" class="form-control">
                                    <option>Tenaga Pendidik</option>
                                    <option>Tenaga Kependidikan</option>
                                    <option>DLL</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Tgl Bergabung</label>
                            <div class="col-sm-7">
                                <input type="date" class="form-control" name="tgl_bergabung">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Alamat</label>
                            <div class="col-sm-7">
                                <textarea name="alamat" class="form-control" rows="10"></textarea>
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
@endpush