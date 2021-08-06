<li class="nav-item">
    <a href="{{ url('jeniskeringanan') }}" class="nav-link @if(Request::is('jeniskeringanan')) active @endif">
        <i class="nav-icon fas fa-handshake"></i>
        <p>Jenis Keringanan</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('penerimakeringanan') }}" class="nav-link @stack('penerimakeringanan')">
        <i class="nav-icon fas fa-handshake"></i>
        <p>Penerima Keringanan</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('setgaji') }}" class="nav-link  @if(Request::is('setgaji')) active @endif">
        <i class="nav-icon fas fa-coins"></i>
        <p>Set Gaji Pegawai</p>
    </a>
</li>
<li class="nav-item has-treeview @stack('transaksi')">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-cash-register"></i>
        <p>
            Transaksi
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item" style="margin-left: 30px">
            <a href="{{ url('transaksi') }}" class="nav-link @stack('transaksi')">
                <p>Transaksi Pemasukan</p>
            </a>
        </li>
        <li class="nav-item" style="margin-left: 30px">
            <a href="{{ url('pengeluaran') }}" class="nav-link @stack('transaksi_pengeluaran')">
                <p>Transaksi Pengeluaran</p>
            </a>
        </li>
    </ul>
</li>
<li class="nav-item has-treeview @stack('uangsaku')">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-coins"></i>
        <p>
            Uang Saku Siswa
            <i class="right fas fa-angle-left"></i>
        </p>

    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item" style="margin-left: 30px">
            <a href="{{ route('uangsaku.index') }}" class="nav-link">
                <p>Uang Saku</p>
            </a>
        </li>
    </ul>
</li>
<li class="nav-item has-treeview @stack('laporan')">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-file"></i>
        <p>
            Laporan
            <i class="right fas fa-angle-left"></i>
        </p>

    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item" style="margin-left: 30px">
            <a href="{{ url('rekappemasukan') }}" class="nav-link @stack('rekappemasukan')">
                <p>Rekap Pemasukan</p>
            </a>
        </li>
        <li class="nav-item" style="margin-left: 30px">
            <a href="{{ url('pengeluaran') }}" class="nav-link @stack('pengeluaran')">
                <p>Rekap Pengeluaran</p>
            </a>
        </li>
        <li class="nav-item" style="margin-left: 30px">
            <a href="{{ url('rekaptransaksi') }}" class="nav-link @stack('rekaptransaksi')">
                <p>Rekap Transaksi</p>
            </a>
        </li>
        <li class="nav-item" style="margin-left: 30px">
            <a href="{{ url('laporantunggakan') }}" class="nav-link @if(Request::is('laporantunggakan')) active @endif">
                <p>Laporan Tunggakan</p>
            </a>
        </li>
        <li class="nav-item" style="margin-left: 30px">
            <a href="{{ url('laporanbayarbulanan') }}"
                class="nav-link @if(Request::is('laporanbayarbulanan')) active @endif">
                <p>Laporan Bayar Bulanan</p>
            </a>
        </li>
        <li class="nav-item" style="margin-left: 30px">
            <a href="{{ url('laporanpersiswa') }}" class="nav-link @if(Request::is('laporanpersiswa')) active @endif">
                <p>Laporan Persiswa</p>
            </a>
        </li>
    </ul>
</li>