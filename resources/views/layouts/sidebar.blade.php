<nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item nav-profile">
              <a href="#" class="nav-link">
                <div class="nav-profile-image">
                  <img src="assets/images/faces/face1.jpg" alt="profile" />
                  <span class="login-status online"></span>
                  </div>
                <div class="nav-profile-text d-flex flex-column">
                  <span class="font-weight-bold mb-2">Rafi Fernandito</span>
                  <span class="text-secondary text-small">Project Manager</span>
                </div>
                <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
              </a>
            <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
    <a class="nav-link" href="{{ url('/') }}">
        <span class="menu-title">Dashboard</span>
    </a>
</li>

<li class="nav-item {{ request()->is('kategori*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ url('/kategori') }}">
        <span class="menu-title">Kategori</span>
    </a>
</li>

<li class="nav-item {{ request()->is('buku*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ url('/buku') }}">
        <span class="menu-title">Buku</span>
    </a>
</li>

<li class="nav-item {{ request()->is('pdf*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ url('/pdf') }}">
        <span class="menu-title">pdf</span>
    </a>
</li>

<li class="nav-item {{ request()->is('barang*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ url('/barang') }}">
        <span class="menu-title">Cetak Data</span>
    </a>
</li>

<li class="nav-item {{ request()->is('kota*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ url('/kota') }}">
        <span class="menu-title">Kota</span>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link" href="{{ url('/wilayah') }}">
        <span class="menu-title">Wilayah</span>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link" href="{{ url('/pos') }}">
        <span class="menu-title">POS</span>
    </a>
</li>

          </ul>
        </nav>

