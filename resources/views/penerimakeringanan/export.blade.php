<table>
    <thead>
        <tr>
            <td></td>
            <td>Keringanan</td>
            <td colspan="7" style="text-align: left">
                @foreach ($data as $k)
                    {{$k->keringanan}}
                    @break
                @endforeach
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Besaran Keringanan</td>
            <td colspan="7">
                @foreach ($data as $bk)
                    {{ 'Rp. '.number_format($bk->besaran_keringanan)}}
                    @break
                @endforeach
            </td>
        </tr>
        <tr>
            <th>No</th>
            <th>NIS</th>
            <th>Nama Siswa</th>
            <th>Jenis Kelamin</th>
            <th>No Telpon</th>
            <th>Nama Ayah</th>
            <th>Nama Ibu</th>
            <th>Alamat</th>
            <th>Alasan Keringanan</th>
        </tr>
    </thead>
    <tbody>
    @foreach($data as $k => $d)
        <tr>
            <td>{{ $k+1 }}</td>
            <td>{{ $d->nis }}</td>
            <td>{{ $d->nama_siswa }}</td>
            <td>{{ $d->jk == 1 ? 'Laki-laki' : 'Perempuan' }}</td>
            <td>{{ $d->no_telp }}</td>
            <td>{{ $d->nama_ayah }}</td>
            <td>{{ $d->nama_ibu }}</td>
            <td>{{ $d->alamat }}</td>
            <td>{{ $d->alasan_keringanan }}</td>
        </tr>
    @endforeach
    </tbody>
</table>