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
                                    <li class="breadcrumb-item active">Profil Siswa</li>
                                </ol>
                            </div>
                            <div class="col-sm-6">
                                <h1 class="float-sm-right"><i class="fas fa-cog"></i> Profil Siswa</h1>
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

                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                                    aria-controls="home" style="color: black !important;" aria-selected="true">
                                    <i class="fas fa-th-large"></i> &nbsp; Profil Siswa
                                </a>

                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="home-tab" data-toggle="tab" href="#dokumen" role="tab"
                                    aria-controls="home" style="color: black !important;" aria-selected="true">
                                    <i class="fas fa-th-large"></i> &nbsp; Dokumen
                                </a>

                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="home-tab" data-toggle="tab" href="#uangsaku" role="tab"
                                    aria-controls="home" style="color: black !important;" aria-selected="true">
                                    <i class="fas fa-th-large"></i> &nbsp; Setting Uang Saku
                                </a>

                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <br>
                                <div class="col-12">

                                    <form action="{{ url('siswa-updateprofil') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="id_siswa" value="{{ @$siswa->id_siswa }}">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">NIS<sup
                                                    class="text-red">*</sup></label>
                                            <div class="col-sm-7">
                                                <input type="text" readonly
                                                    class="form-control @error('nis') is-invalid @enderror"
                                                    placeholder="NIS" value="{{ @$siswa->nis }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="" class="col-sm-2 col-form-label">Qr Code</label>
                                            <div class="col-sm-7">
                                                {!! QrCode::size(100)->generate(@$siswa->nis) !!}
                                                {{-- {!! QrCode::format('png')->merge('https://1.bp.blogspot.com/-5-KgAtUWeFs/YJZfknaACeI/AAAAAAAAGMw/qL0YhsXcGy4iMAwL8sayQ5cYz_8ppt0NwCLcBGAsYHQ/s1500/cara%2Bmembuat%2Bqrcode%2Blaravel%2Bcover.png', .3, true)->generate()  !!} --}}
                                                <br><br>
                                                <a href="{{ url('printqrcodesiswa') }}/{{ @$siswa->id_siswa }}"
                                                    class="btn btn-sm btn-success"><i class="fas fa-print"></i> Print
                                                    QrCode</a>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Nama Lengkap<sup
                                                    class="text-red">*</sup></label>
                                            <div class="col-sm-7">
                                                <input type="text"
                                                    class="form-control @error('nama_siswa') is-invalid @enderror"
                                                    placeholder="Nama Lengkap" name="nama_siswa"
                                                    value="{{ @$siswa->nama_siswa }}">
                                                @error('nama_siswa')
                                                    <p class="text-red">{{ @$message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Jenis Kelamin<sup
                                                    class="text-red">*</sup></label>
                                            <div class="col-sm-7">
                                                <select name="jk" class="form-control">
                                                    <option value="1" {{ @$siswa->jk == 1 ? 'selected' : '' }}>Laki-laki
                                                    </option>
                                                    <option value="0" {{ @$siswa->jk == 0 ? 'selected' : '' }}>Perempuan
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Nomor Telpon/Hp</label>
                                            <div class="col-sm-7">
                                                <input type="number" class="form-control" name="no_telp"
                                                    placeholder="Nomor Telpon/Hp" value="{{ @$siswa->no_telp }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Nama Ayah</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" name="nama_ayah"
                                                    placeholder="Nama Ayah" value="{{ @$siswa->nama_ayah }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Nama Ibu</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" name="nama_ibu"
                                                    placeholder="Nama Ibu" value="{{ @$siswa->nama_ibu }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Alamat</label>
                                            <div class="col-sm-7">
                                                <textarea name="alamat" class="form-control"
                                                    rows="10">{{ @$siswa->alamat }}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Status</label>
                                            <div class="col-sm-7">
                                                <select name="status" class="form-control">
                                                    <option {{ @$siswa->status == 'Aktif' ? 'selected' : '' }}
                                                        value="Aktif">Aktif
                                                    </option>
                                                    <option {{ @$siswa->status == 'Tidak Aktif' ? 'selected' : '' }}
                                                        value="Tidak Aktif">
                                                        Tidak Aktif</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Password</label>
                                            <div class="col-sm-7">
                                                <input type="password" class="form-control" name="password">
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
                            <div class="tab-pane fade" id="dokumen" role="tabpanel" aria-labelledby="profile-tab">
                                <br>
                                <div class="alert alert-info"><i class="fas fa-exclamation-triangle"></i> &nbsp; Halaman ini
                                    belum tersedia untuk saat ini</div>
                            </div>
                            <div class="tab-pane fade" id="uangsaku" role="tabpanel" aria-labelledby="profile-tab">
                                <br>
                                <form action="{{ url('siswa-settinguangsaku') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id_siswa" value="{{ @$siswa->id_siswa }}">
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Limit Jajan Harian<sup class="text-red">*</sup></label>
                                        <?php

                                            $limit = DB::table('uang_sakus')->where('id_siswa', @$siswa->id_siswa)->value('limit_jajan_harian');
                                        
                                        ?>
                                        <div class="col-sm-7">
                                            <select name="limit_jajan_harian" class="form-control" id="">
                                                <option {{ $limit == 5000 ? 'selected' : '' }} value="5000">Rp. 5.000</option>
                                                <option {{ $limit == 10000 ? 'selected' : '' }} value="10000">Rp. 10.000</option>
                                                <option {{ $limit == 15000 ? 'selected' : '' }} value="15000">Rp. 15.000</option>
                                                <option {{ $limit == 20000 ? 'selected' : '' }} value="20000">Rp. 20.000</option>
                                            </select>
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

                </div>
            </div>
        </section>
    </div>
@endsection
@push('script')
    <script src="{{ asset('adminlte/plugins/toastr/toastr.min.js') }}"></script>
    <script>
        @if($message = Session::get('sukses'))
            toastr.success("{{ $message }}")
        @elseif($message = Session::get('gagal'))
            toastr.error("{{ $message }}")
        @endif
    </script>
@endpush
