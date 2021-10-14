@extends('layouts.app')

@push('style')
<link rel="stylesheet" href="{{ asset('adminlte/plugins/toastr/toastr.min.css') }}">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
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
                                <li class="breadcrumb-item active">Tambah Transaksi</li>
                            </ol>
                        </div>
                        <div class="col-sm-6">
                            <h1 class="float-sm-right"><i class="fas fa-cog"></i> Tambah Transaksi</h1>
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
                    <a href="{{ url('transaksi') }}" class="btn btn-sm btn-primary"><i class="fas fa-arrow-left"></i>
                        Kembali</a>
                    <a href="{{ url('tambah-transaksi') }}" class="btn btn-sm btn-danger"><i class="fas fa-undo"></i>
                        Reset</a>
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
                    <div>
                        <form action="{{ url('tambah-transaksi') }}" method="GET">
                            <div class="control-group">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Tgl Bayar<sup
                                            class="text-red">*</sup></label>
                                    <div class="col-sm-10">
                                        <input type="date" name="tgl_transaksi" class="form-control"
                                            value="{{ @$_GET['tgl_transaksi'] }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Kelas<sup class="text-red">*</sup></label>
                                    <div class="col-sm-10">
                                        <select name="id_kelas" class="form-control" onchange="submit();">
                                            <option value="">--Pilih Kelas--</option>
                                            @foreach ($kelas as $item)
                                            <option {{ @$_GET['id_kelas'] == $item->id_kelas ? 'selected' : '' }}
                                                value="{{ $item->id_kelas }}">
                                                {{ $item->kelas }}/{{ $item->jenjang }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Siswa<sup class="text-red">*</sup></label>
                                    <div class="col-sm-10">
                                        <select id="carisiswa" name="id_siswa" class="form-control" onchange="submit();">
                                            <option value="">--Pilih Siswa--</option>
                                            @foreach (@$siswa as $siswa)
                                            <option {{ @$_GET['id_siswa'] == $siswa->id_siswa ? 'selected' : ''}}
                                                value="{{ $siswa->id_siswa }}">{{ $siswa->nama_siswa }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                        </form>
                        <form action="{{ url('simpan-transaksi') }}" method="POST">
                            @csrf
                            <input type="hidden" name="tgl_transaksi" value="{{ @$_GET['tgl_transaksi'] }}">
                            <input type="hidden" name="id_kelas" value="{{ @$_GET['id_kelas'] }}">
                            <input type="hidden" name="id_siswa" value="{{ @$_GET['id_siswa'] }}">
                                @if(@$_GET['id_kelas'])
                                @foreach ($pembayaran as $k => $p)
                                <?php

                                    $keringanan = DB::table('penerima_keringanans')
                                                    ->join('keringanans', 'keringanans.id_keringanan', '=', 'penerima_keringanans.id_keringanan')
                                                    ->join('jenis_pembayarans', 'jenis_pembayarans.id_jenis_pembayaran', '=', 'keringanans.id_jenis_pembayaran')
                                                    ->join('tahun_ajarans', 'tahun_ajarans.id_tahun', '=', 'penerima_keringanans.id_tahun')
                                                    ->where('tahun_ajarans.status_aktif', '1')
                                                    ->where('id_siswa', $_GET['id_siswa'])
                                                    ->where('jenis_pembayarans.id_jenis_pembayaran', $p->id_jenis_pembayaran)
                                                    ->first();

                                                    // dd($keringanan);
                                                    
                                ?>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">{{ $p->nama_pembayaran }}</label>
                                    <div class="col-sm-2">
                                        <input type="hidden" name="id_jenis_pembayaran[]"
                                            value="{{ $p->id_jenis_pembayaran }}">
                                        <input type="text" class="form-control"
                                            value="Rp. {{ number_format($p->biaya) }}" disabled>
                                    </div>
                                    <label class="col-sm-2 col-form-label text-center">Keringanan</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control"
                                            value="Rp. {{ @number_format($keringanan->besaran_keringanan) }}" disabled>
                                    </div>
                                    <label class="col-sm-2 col-form-label text-center">Jumlah Bayar</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control number-separator" name="jumlah_bayar[]">
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-10">
                                        <p class="text-red">Pilih Kelas Terlebih Dahulu untuk Menampilkan Semua
                                            Pembayaran</p>
                                    </div>
                                </div>
                                @endif
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Nama Pembayar<sup
                                            class="text-red">*</sup></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="nama_pembayar"
                                            class="form-control @error('nama_pembayar') is-invalid @enderror"
                                            value="{{ @$_GET['nama_pembayar'] }}" required>
                                        @error('nama_pembayar')
                                        <p class="text-red">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Keterangan<sup
                                            class="text-red">*</sup></label>
                                    <div class="col-sm-10">
                                        <textarea name="keterangan" class="form-control" rows="5" required></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-7">
                                        <button class="btn btn-sm btn-primary" type="submit"><i class="fas fa-plus"></i>
                                            Simpan</button>
                                    </div>

                                </div>
                            </div>
                        </form>
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
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/autonumeric@4.1.0"></script>
<script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
<script>
    @if($message = Session::get('gagal'))
        toastr.error("{{ $message }}")
    @elseif($errors->any())
        @foreach ($errors->all() as $error)
            toastr.error("{{ $error }}")
        @endforeach
    @endif

    document.querySelectorAll('.number-separator').forEach((item) => {
    item.addEventListener('input', (e) => {
        if (/^[0-9.,]+$/.test(e.target.value)) {
        e.target.value = parseFloat(
            e.target.value.replace(/,/g, '')
        ).toLocaleString('en');
        } else {
        e.target.value = e.target.value.substring(0, e.target.value.length - 1);
        }
    });
    });
</script>
<script>
    $(document).ready(function() {
    $('#carisiswa').select2({
      theme: 'bootstrap4'
    })
})

</script>
@endpush