<li class="nav-item">
    <a href="{{ url('siswa-uangsaku') }}" class="nav-link  @if(Request::is('siswa-uangsaku')) active @endif">
        <i class="nav-icon fas fa-coins"></i>
        <p>Uang Saku</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('siswa-profil') }}" class="nav-link  @if(Request::is('siswa-profil')) active @endif">
        <i class="nav-icon fas fa-user"></i>
        <p>Profil User</p>
    </a>
</li>