<table>
    <thead>
        <tr>
            <th>No</th>
            <th>NIP</th>
            <th>NIK</th>
            <th>Nama Lengkap</th>
            <th>Jenis Kelamin</th>
            <th>No Telpon</th>
            <th>Jenis Pegawai</th>
            <th>Tgl Bergabung</th>
            <th>Alamat</th>
        </tr>
    </thead>
    <tbody>
    @foreach($data as $k => $d)
        <tr>
            <td>{{ $k+1 }}</td>
            <td>{{ $d->nip }}</td>
            <td>{{ $d->nik }}</td>
            <td>{{ $d->nama_pegawai }}</td>
            <td>{{ $d->jk == 1 ? 'Laki-laki' : 'Perempuan'}}</td>
            <td>{{ $d->no_telp }}</td>
            <td>{{ $d->jenis_pegawai }}</td>
            <td>{{ $d->tgl_bergabung }}</td>
            <td>{{ $d->alamat }}</td>
        </tr>
    @endforeach
    </tbody>
</table>