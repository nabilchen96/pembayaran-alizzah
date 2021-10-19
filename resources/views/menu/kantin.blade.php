<li class="nav-item">
    <a href="{{ url('transaksikantin') }}" class="nav-link  @if(Request::is('transaksikantin')) active @endif">
        <i class="nav-icon fas fa-coins"></i>
        <p>Transaksi Kantin</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('laporankantin') }}" class="nav-link  @if(Request::is('laporankantin')) active @endif">
        <i class="nav-icon fas fa-file"></i>
        <p>Laporan Kantin</p>
    </a>
</li>