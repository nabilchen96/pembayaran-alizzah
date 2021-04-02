@extends('layouts.app')

@push('style')

<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('adminlte/plugins/toastr/toastr.min.css') }}">
@endpush

@push('penerimakeringanan')
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
                                <li class="breadcrumb-item active">Keringanan</li>
                                <li class="breadcrumb-item active">Edit Penerima Keringanan</li>
                            </ol>
                        </div>
                        <div class="col-sm-6">
                            <h1 class="float-sm-right"><i class="fas fa-cog"></i> Edit Penerima Keringanan</h1>
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
                    <a href="{{ url('detailpenerimakeringanan') }}?id_keringanan={{ $keringanan->id_keringanan }}" class="btn btn-sm btn-primary"><i class="fas fa-arrow-left"></i> Kembali</a>
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
                    <form action="{{ url('updatepenerimakeringanan') }}" enctype="multipart/form-data" method="post">
                        @csrf
                        <input type="hidden" name="id_penerima_keringanan" value="{{ $penerima->id_penerima_keringanan }}">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Keringanan<sup class="text-red">*</sup></label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" value="{{ $keringanan->keringanan }}" disabled>
                                <input type="hidden" name="id_keringanan" value="{{ $keringanan->id_keringanan }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">NIS<sup class="text-red">*</sup></label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="nis" value="{{ $penerima->nis }}" disabled>
                                <input type="hidden" name="id_siswa" id="id_siswa" value="{{ $penerima->id_siswa }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nama Siswa<sup class="text-red">*</sup></label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="nama_siswa" value="{{ $penerima->nama_siswa }}" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Status Penerima<sup class="text-red">*</sup></label>
                            <div class="col-sm-7">
                                <select class="form-control" name="status_penerima">
                                    <option value="1" {{ $penerima->status_penerima == '1' ? 'selected' : '' }} >Aktif</option>
                                    <option value="0" {{ $penerima->status_penerima == '0' ? 'selected' : ''}}>Tidak Aktif</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Berkas Keringanan<sup class="text-red">*</sup></label>
                            <div class="col-sm-7">
                                <input type="file" class="form-control" name="berkas_keringanan">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label"></label>
                            <div class="col-sm-7">
                                <a href="{{ asset('file_upload') }}/{{$penerima->berkas_keringanan}}" class="badge badge-info">Lihat Berkas yang diupload</a>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Alasan Keringanan</label>
                            <div class="col-sm-7">
                                <textarea name="alasan_keringanan" class="form-control" rows="10">{{ $penerima->alasan_keringanan }}</textarea>
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
<script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/toastr/toastr.min.js') }}"></script>

<script>
    @if($message = Session::get('gagal'))
        toastr.error("{{ $message }}")
    @endif
</script>
@endpush