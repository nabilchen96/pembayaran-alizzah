<table>
    <thead>
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
        </tr>
    @endforeach
    </tbody>
</table>