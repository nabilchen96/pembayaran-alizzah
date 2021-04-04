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
    @foreach($siswa as $k => $d)
        <tr>
            <td>{{ $k+1 }}</td>
            <td>{{ @$d['nis'] }}</td>
            <td>{{ @$d['nama_siswa'] }}</td>
            <td>{{ @$d['kelas'] }}</td>
            {{-- <td>{{ @$d['total_tunggakan'] }}</td> --}}
            <td>{{ 'Rp. '.number_format(@$d['hutang_tunggakan']) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>