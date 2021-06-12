<table>
    <thead>
        <tr>
            <td></td>
            <td>Tunggakan Pembayaran</td>
            <td colspan="6" style="text-align: left">
                @foreach ($siswa as $k)
                    {{@$k['pembayaran']}}
                    @break
                @endforeach
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Tahun Ajaran</td>
            <td colspan="6">
                @foreach ($siswa as $bk)
                    {{@$bk['tahun']}}
                    @break
                @endforeach
            </td>
        </tr>
        <tr>
            <th>No</th>
            <th>NIS</th>
            <th>Nama Siswa</th>
            <th>Kelas</th>
            {{-- <th>Total Tunggakan</th> --}}
            <th>Total Hutang</th>
        </tr>
    </thead>
    <tbody>
    <?php $total = 0; ?>
    @foreach($siswa as $k => $d)
        <tr>
            <td>{{ $k+1 }}</td>
            <td>{{ @$d['nis'] }}</td>
            <td>{{ @$d['nama_siswa'] }}</td>
            <td>{{ @$d['kelas'] }}</td>
            <?php

                $total = $d['hutang_tunggakan'] + $total;

            ?>
            <td>{{ @$d['spp'] == null ? 'Pembayaran Belum Diset' : 'Rp. '.number_format(@$d['hutang_tunggakan']) }}</td>
        </tr>
    @endforeach
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td><b>Total Tunggakan</b></td>
        <td><b>Rp. {{ number_format( $total ) }}</b></td>
    </tr>
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
        <td>Mujiburrahiem, BA</td>
    </tr>
    </tbody>
</table>