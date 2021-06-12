<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Keterangan</th>
            <th>Pemasukan (Rp)</th>
            <th>Pengeluaran (Rp)</th>
            <th>Saldo</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $k => $item)
        <tr>
            <td>{{ $k+1 }}</td>
            <td>{{ $item['tgl_transaksi'] }}</td>
            <td>{{ $item['keterangan'] }}</td>
            <td>{{ $item['jenis_transaksi'] == 'pemasukan' ? 'Rp. '.number_format($item['jumlah_transaksi']) : '-' }}
            </td>
            <td>{{ $item['jenis_transaksi'] == 'pengeluaran' ? 'Rp '.number_format($item['jumlah_transaksi']) : '-' }}
            </td>
            <td>{{ 'Rp. '.number_format($item['saldo']) }}</td>
        </tr>
        @endforeach
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr>
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
            <td>Mujiburrahiem, BA</td>
        </tr>
    </tbody>
</table>