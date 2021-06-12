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
                        <div class="control-group">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Tgl Bayar<sup class="text-red">*</sup></label>
                                <div class="col-sm-10">
                                    <input type="date" form="form2" name="tgl_transaksi"
                                        class="form-control @error('tgl_transaksi') is-invalid @enderror"
                                        value="{{ date("Y-m-d") }}">
                                    @error('tgl_transaksi')
                                    <p class="text-red">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <form action="{{ url('tambah-transaksi') }}" id="form2" method="GET">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Kelas<sup class="text-red">*</sup></label>
                                    <div class="col-sm-10">
                                        <select class="form-control @error('id_kelas') is-invalid @enderror"
                                            name="id_kelas" form="form2" onchange="submit();">
                                            <option value="">----</option>
                                            @foreach ($kelas as $item)
                                            <option {{ @$id_kelas == $item->id_kelas ? 'selected' : ''}}
                                                value="{{ $item->id_kelas }}">{{ $item->kelas }}/{{ $item->jenjang }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('id_kelas')
                                        <p class="text-red">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </form>

                            <form action="{{'tambah-transaksi'}}" id="form3" method="GET">
                                <input type="hidden" name="nama_pembayar" value="{{ $nama_pembayar }}">
                                <input type="hidden" name="tgl_transaksi" value="{{ $tgl_transaksi }}">
                                <input type="hidden" name="id_kelas" value="{{ $id_kelas }}">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Nama Siswa</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="id_siswa" onchange="submit();" id="carisiswa">
                                            <option value="">----</option>
                                            @foreach ($siswa as $s)
                                            <option {{ @$id_siswa == $s->id_siswa ? 'selected' : ''}}
                                                value="{{ $s->id_siswa }}">{{ $s->nama_siswa }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </form>

                            <form action="{{ url('simpan-transaksi') }}" id="form1" method="Post">
                                @csrf
                                <input type="hidden" name="nama_pembayar" value="{{ $nama_pembayar }}">
                                <input type="hidden" name="tgl_transaksi" value="{{ $tgl_transaksi }}">
                                <input type="hidden" name="id_kelas" value="{{ $id_kelas }}">
                                <input type="hidden" name="id_siswa" value="{{ $id_siswa }}">
                                @if (!empty($id_kelas))
                                @forelse ($pembayaran as $p)
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">{{ $p->nama_pembayaran }}</label>
                                    <div class="col-sm-2">
                                        <input type="hidden" name="id_jenis_pembayaran[]"
                                            value="{{ $p->id_jenis_pembayaran }}">
                                        <input type="hidden" name="biaya" value="{{$p->biaya}}">
                                        <input type="text" class="form-control"
                                            value="Rp. {{ number_format($p->biaya) }}" disabled>
                                    </div>
                                    <label class="col-sm-2 col-form-label text-center">Keringanan</label>
                                    <div class="col-sm-2">
                                        <input type="hidden" name="besaran_keringanan[]"
                                            value="@if(@$p->id_siswa == @$id_siswa ) {{@$p->besaran_keringanan}}@else{{0}}@endif">
                                        <input type="text" class="form-control"
                                            value="Rp @if(@$p->id_siswa == @$id_siswa ) {{ number_format(@$p->besaran_keringanan) }} @else 0 @endif"
                                            disabled>
                                    </div>
                                    <label class="col-sm-2 col-form-label text-center">Jumlah Bayar</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control number-separator" name="jumlah_bayar[]">
                                    </div>
                                </div>
                                @empty
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-10">
                                        <p class="text-red">Pilih Kelas Terlebih Dahulu untuk Menampilkan Semua
                                            Pembayaran</p>
                                    </div>
                                </div>
                                @endforelse
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
                                            value="{{ $nama_pembayar }}" required>
                                        @error('nama_pembayar')
                                        <p class="text-red">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Keterangan<sup
                                            class="text-red">*</sup></label>
                                    <div class="col-sm-10">
                                        <textarea name="keterangan" class="form-control" rows="5"></textarea>
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