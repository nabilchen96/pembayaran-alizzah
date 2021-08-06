<li class="nav-item has-treeview @stack('master')">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-dumpster-fire"></i>
        <p>
            Data Master
            <i class="right fas fa-angle-left"></i>
        </p>

    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item" style="margin-left: 30px">
            <a href="{{ url('tahunajaran') }}" class="nav-link @if(Request::is('tahunajaran')) active @endif">
                <p>Tahun Ajaran</p>
            </a>
        </li>
        <li class="nav-item" style="margin-left: 30px">
            <a href="{{ url('kelas')}}" class="nav-link @if(Request::is('kelas')) active @endif">
                <p>Kelas</p>
            </a>
        </li>
        <li class="nav-item" style="margin-left: 30px">
            <a href="{{ url('pegawai') }}" class="nav-link">
                <p>Pegawai</p>
            </a>
        </li>
        <li class="nav-item" style="margin-left: 30px">
            <a href="{{ url('siswa') }}"
                class="nav-link @if(Request::is('siswa') or Request::is('tambahsiswa') or Request::is('edissiswa')) active @endif">
                <p>Siswa</p>
            </a>
        </li>
        <li class="nav-item" style="margin-left: 30px">
            <a href="{{ url('jenispembayaran') }}" class="nav-link @if(Request::is('jenispembayaran')) active @endif">
                <p>Jenis Pembayaran</p>
            </a>
        </li>

    </ul>
</li>
<li class="nav-item">
    <a href="{{ url('rombel') }}" class="nav-link @if(Request::is('rombel')) active @endif">
        <i class="nav-icon fas fa-users"></i>
        <p>Rombel</p>
    </a>
</li>