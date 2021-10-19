<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>NIS</th>
            <th>Nama Siswa</th>
            <th>Keterangan</th>
            <th>Jumlah Transaksi</th>
        </tr>
    </thead>
    <tbody>
    @foreach($data as $k => $d)
        <tr>
            <td>{{ $k+1 }}</td>
            <td>{{ $d->created_at }}</td>
            <td>{{ $d->nis }}</td>
            <td>{{ $d->nama_siswa }}</td>
            <td>{{ $d->keterangan }}</td>
            <td>Rp. {{ number_format($d->jumlah) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>