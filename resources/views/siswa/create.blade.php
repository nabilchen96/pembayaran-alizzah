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
                    <form action="{{ url('simpansiswa') }}" method="post">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">NIS<sup class="text-red">*</sup></label>
                            <div class="col-sm-7">
                            <input type="text" class="form-control @error('nis') is-invalid @enderror" placeholder="NIS" name="nis">
                            @error('nis')
                                <p class="text-red">{{ $message }}</p>
                            @enderror 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nama Lengkap<sup class="text-red">*</sup></label>
                            <div class="col-sm-7">
                            <input type="text" class="form-control @error('nama_siswa') is-invalid @enderror" placeholder="Nama Lengkap" name="nama_siswa">
                            @error('nama_siswa')
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
                            <label class="col-sm-2 col-form-label">Nama Ayah</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" name="nama_ayah" placeholder="Nama Ayah">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nama Ibu</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" name="nama_ibu" placeholder="Nama Ibu">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Alamat</label>
                            <div class="col-sm-7">
                                <textarea name="alamat" class="form-control" rows="10"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Status</label>
                            <div class="col-sm-7">
                                <select name="status" class="form-control">
                                    <option value="Aktif">Aktif</option>
                                    <option value="Tidak Aktif">Tidak Aktif</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Password</label>
                            <div class="col-sm-7">
                                <input type="password" class="form-control" name="password" required>
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