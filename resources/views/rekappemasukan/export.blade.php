<table>
    <thead>
        <tr>
            <th>No</th>
            <th>No Nota</th>
            <th>Tanggal Transaksi</th>
            <th>Pembayaran</th>
            <th>Nama Pembayar</th>
            <th>Jumlah Bayar</th>
            <th>Siswa</th>
            <th>Kelas</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
    @foreach($data as $k => $d)
        <tr>
            <td>{{ $k+1 }}</td>
            <td>{{ $d->kd_nota }}</td>
            <td>{{ $d->tgl_transaksi }}</td>
            <td>{{ $d->nama_pembayaran }}</td>
            <td>{{ $d->nama_pembayar }}</td>
            <td>{{ $d->jumlah_bayar }}</td>
            <td>{{ $d->nis }}/{{ $d->nama_siswa }}</td>
            <td>{{ $d->kelas }}/{{ $d->jenjang }}</td>
            <td>{{ $d->keterangan }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
