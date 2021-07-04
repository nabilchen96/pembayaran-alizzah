<table>
    <tr>
        <td>Nama Siswa</td>
        <td colspan="4">{{ $data_siswa->nama_siswa }}</td>
    </tr>
    <tr>
        <td>NIS</td>
        <td colspan="4">{{ $data_siswa->nis }}</td>
    </tr>
    <tr>
        <td>Kelas</td>
        <td colspan="4">{{ $data_siswa->kelas }} / {{ $data_siswa->jenjang }}</td>
    </tr>
    <tr>
        <td>No</td>
        <td>No Nota</td>
        <td>Tgl Transaksi</td>
        <td>Pembayaran</td>
        <td>Jumlah Bayar</td>
    </tr>
    @foreach ($data as $k => $item)
    <tr>
        <td>{{ $k+1 }}</td>
        <td>{{ $item->kd_nota }}</td>
        <td>{{ date('d-m-Y', strtotime($item->tgl_transaksi)) }}</td>
        <td>{{ $item->nama_pembayaran }}</td>
        <td>Rp. {{ number_format($item->jumlah_bayar) }}</td>
    </tr>
    @endforeach
</table>