<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Keterangan</th>
            <th>QTY</th>
            <th>Harga Satuan</th>
            <th>Total Harga</th>
        </tr>
    </thead>
    <tbody>
    <?php $total = 0; ?>
    @foreach($data as $k => $d)
        <tr>
            <td>{{ $k+1 }}</td>
            <td>{{ $d->tgl_pengeluaran }}</td>
            <td>{{ $d->keterangan }}</td>
            <td>{{ $d->qty }}</td>
            <td>{{ 'Rp. '.number_format($d->harga_satuan) }}</td>
            <td>{{ 'Rp. '.number_format($d->total_harga) }}</td>
            <?php
                $total = $d->total_harga + $total
            ?>
        </tr>
    @endforeach
    <tr>
        <td colspan="5" style="text-align: center"><b>Total Pengeluaran</b></td>
        <td><b>{{ 'Rp. '.number_format($total) }}</b></td>
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