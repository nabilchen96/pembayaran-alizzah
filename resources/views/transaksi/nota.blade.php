<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <table class="table" style="border-color: transparent">
            <tr class="row">
                {{-- <td class="col-2">
                    <img height="100" src="{{ asset('logologo.png') }}" alt="">
                </td> --}}
                <td class="col-12 text-center">
                    <img width="100%" height="100" src="{{ asset('kop.jpeg')}}" alt="">
                </td>
            </tr>
            <tr class="row">
                <td style="margin-bottom: -20px">
                    <hr>
                </td>
            </tr>
        </table>
        <table class="table table-striped" style="border-color: transparent;">
            <tr class="row">
                <td class="col-2" style="width: 15%">Nama Pembayar</td>
                <td class="col-1" style="width: 5%">:</td>
                <td class="col-9" style="width: 80%">{{ $nota->nama_pembayar }}</td>
            </tr>
            <tr class="row">
                <td class="col-2" style="width: 15%">Nama</td>
                <td class="col-1" style="width: 5%">:</td>
                <td class="col-3" style="width: 30%">{{ $nota->nama_siswa}}/{{ $nota->nis }}</td>
                <td class="col-2" style="width: 15%">Kelas</td>
                <td class="col-1" style="width: 5%">:</td>
                <td class="col-3" style="width: 30%">
                    @foreach ($pembayaran as $p)
                    {{$p->kelas}}/{{$p->jenjang}}
                    @break
                    @endforeach</td>
            </tr>
            <tr class="row">
                <td class="col-2" style="width: 15%">Kode Transaksi</td>
                <td class="col-1" style="width: 5%">:</td>
                <td class="col-3" style="width: 30%">{{ $nota->kd_nota }}</td>
                <td class="col-2" style="width: 15%">TGL Transaksi</td>
                <td class="col-1" style="width: 5%">:</td>
                <td class="col-3" style="width: 30%">{{ date('d F Y', strtotime($nota->tgl_transaksi)) }}</td>
            </tr>
        </table>
        <table class="table table-striped">
            <thead>
                <tr class="row">
                    <td class="col">No</td>
                    <td class="col">Pembayaran</td>
                    <td class="col">Jumlah Bayar</td>
                </tr>
            </thead>
            <?php $jumlah = 0?>
            @foreach ($pembayaran as $key => $item)
            <tr class="row">
                <td class="col">{{ $key+1 }}</td>
                <td class="col">{{ $item->nama_pembayaran }}</td>
                <td class="col">Rp. {{ number_format($item->jumlah_bayar) }}</td>
                <?php $jumlah = $item->jumlah_bayar + $jumlah; ?>
            </tr>
            @endforeach
            <tr class="row">
                <td class="col-11" colspan="2">
                    <hr>
                </td>
                <td class="col-1">(+)</td>
            </tr>
            <tr class="row">
                <td class="col">Total Pembayaran</td>
                <td class="col"></td>
                <td class="col">Rp. {{ number_format($jumlah) }}</td>
            </tr>
            <tr class="row">
                <td class="col" colspan="3">Keterangan : {{$nota->keterangan}}</td>
            </tr>
        </table>
        <table class="table" style="border-color: transparent">
            <tr class="row text-right">
                <td style="text-align: end;" colspan="3" class="text-right">Palembang, {{ date('d F Y', strtotime($nota->tgl_transaksi)) }}</td>
            </tr>
            <tr class="row text-right" style="margin-top: 70px">
                <td style="text-align: end;" colspan="3" class="text-right">( ............................................)</td>
            </tr>
        </table>
    </div>
    <script>
        window.print()
    </script>   
</body>

</html>