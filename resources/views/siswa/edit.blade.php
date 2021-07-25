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
                                <li class="breadcrumb-item">Dashbaord</li>
                                <li class="breadcrumb-item active">Data Master</li>
                                <li class="breadcrumb-item active">Edit Siswa</li>
                            </ol>
                        </div>
                        <div class="col-sm-6">
                            <h1 class="float-sm-right"><i class="fas fa-cog"></i> Edit Siswa</h1>
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
                    <form action="{{ url('updatesiswa') }}" method="post">
                        @csrf
                        <input type="hidden" name="id_siswa" value="{{ $siswa->id_siswa }}">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">NIS<sup class="text-red">*</sup></label>
                            <div class="col-sm-7">
                            <input type="text" class="form-control @error('nis') is-invalid @enderror" placeholder="NIS" name="nis" value="{{ $siswa->nis }}">
                            @error('nis')
                                <p class="text-red">{{ $message }}</p>
                            @enderror 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-2 col-form-label">Qr Code</label>
                            <div class="col-sm-7">
                                {!! QrCode::size(100)->generate($siswa->nis); !!}
                                <br><br>
                                <a href="{{ url('printqrcodesiswa') }}/{{ $siswa->id_siswa }}" class="btn btn-sm btn-success"><i class="fas fa-print"></i> Print QrCode</a>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nama Lengkap<sup class="text-red">*</sup></label>
                            <div class="col-sm-7">
                            <input type="text" class="form-control @error('nama_siswa') is-invalid @enderror" placeholder="Nama Lengkap" name="nama_siswa" value="{{ $siswa->nama_siswa }}">
                            @error('nama_siswa')
                                <p class="text-red">{{ $message }}</p>
                            @enderror 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Jenis Kelamin<sup class="text-red">*</sup></label>
                            <div class="col-sm-7">
                                <select name="jk" class="form-control">
                                    <option value="1" {{ $siswa->jk == 1 ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="0" {{ $siswa->jk == 0 ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nomor Telpon/Hp</label>
                            <div class="col-sm-7">
                                <input type="number" class="form-control" name="no_telp" placeholder="Nomor Telpon/Hp" value="{{ $siswa->no_telp }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nama Ayah</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" name="nama_ayah" placeholder="Nama Ayah" value="{{ $siswa->nama_ayah }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nomor Telpon/Hp</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" name="nama_ibu" placeholder="Nama Ibu" value="{{ $siswa->nama_ibu }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Alamat</label>
                            <div class="col-sm-7">
                                <textarea name="alamat" class="form-control" rows="10">{{ $siswa->alamat }}</textarea>
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