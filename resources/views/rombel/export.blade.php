<table>
    <thead>
        <tr>
            <td></td>
            <td>Kelas</td>
            <td colspan="11">
                @foreach ($data as $kelas)
                    {{$kelas->kelas}}
                    @break
                @endforeach
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Jenjang</td>
            <td colspan="11">
                @foreach ($data as $jenjang)
                    {{$jenjang->jenjang}}
                    @break
                @endforeach
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Tahun Ajaran</td>
            <td colspan="11">
                @foreach ($data as $tahun)
                    {{$tahun->tahun}}
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
            <th>Kelas</th>
            <th>Jenjang</th>
            <th>Tahun Ajaran</th>
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
            <td>{{ $d->kelas }}</td>
            <td>{{ $d->jenjang }}</td>
            <th>{{ $d->tahun }}</th>
        </tr>
    @endforeach
    </tbody>
</table>