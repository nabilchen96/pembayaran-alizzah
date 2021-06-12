<table>
    <thead>
        <tr>
            <th>No</th>
            <th>NIP</th>
            <th>Nama Pegawai</th>
            <th>Jumlah Gaji</th>
            <th width="50">Keterangan</th>
        </tr>
    </thead>
    <tbody>
    @foreach($data as $k => $d)
        <tr>
            <td style="vertical-align: middle">{{ $k+1 }}</td>
            <td style="vertical-align: middle">{{ $d->nip }}</td>
            <td style="vertical-align: middle">{{ $d->nama_pegawai }}</td>
            <td style="vertical-align: middle">{{ 'Rp. '.number_format($d->gaji_rincian) }}</td>
            <td>
                <?php
                    $rincian = DB::table('set_gajis')->where('id_pegawai', $d->id_pegawai)->get();
                    foreach ($rincian as $key => $value) {
                        echo '<span class="badge badge-success">'.$value->jenis_rincian.' : Rp'.number_format($value->gaji_rincian).'</span><br>';    
                    }
                ?>
            </td>
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
        <td>Mengetahui, Mudir PPTQ Al-Izzah</td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>Palembang, {{ date('d-m-y') }}</td>
    </tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>Mujiburrahiem, BA</td>
    </tr>
    </tbody>
</table>