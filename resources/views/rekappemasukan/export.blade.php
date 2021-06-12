<table border=1>
    <thead>
        <tr>
            <th><b>No</b></th>
            <th><b>No Nota</b></th>
            <th><b>Tanggal Transaksi</b></th>
            <th><b>Pembayaran</b></th>
            <th><b>Nama Pembayar</b></th>
            <th><b>Siswa</b></th>
            <th><b>Kelas</b></th>
            <th><b>Keterangan</b></th>
            <th><b>Jumlah Bayar</b></th>
        </tr>
    </thead>
    <tbody>
    <?php $total = 0; ?>
    @foreach($data as $k => $d)
        <tr>
            <td>{{ $k+1 }}</td>
            <td>{{ $d->kd_nota }}</td>
            <td>{{ $d->tgl_transaksi }}</td>
            <td>{{ $d->nama_pembayaran }}</td>
            <td>{{ $d->nama_pembayar }}</td>
            <td>{{ $d->nis }}/{{ $d->nama_siswa }}</td>
            <td>{{ $d->kelas }}/{{ $d->jenjang }}</td>
            <td>{{ $d->keterangan }}</td>
            <?php
                $total = $d->jumlah_bayar + $total
            ?>
            <td>Rp. {{ number_format($d->jumlah_bayar) }}</td>
        </tr>
    @endforeach
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><b>Total Pemasukan</b></td>
        <td><b>Rp. {{ number_format( $total )}}</b></td>
    </tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>Mengetahui, Mudir PPTQ Al-Izzah</td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>Palembang, {{ date('d-m-Y') }}</td>
    </tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>Mujiburrahiem, BA</td>
    </tr>
    </tbody>
</table>
