<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <a href="#" class="nav-link">
                <div class="nav-profile-image">
                    {{-- PERBAIKAN PATH FOTO PROFIL SIDEBAR --}}
                    <img src="{{ asset('assets/assets/images/faces/face1.jpg') }}" alt="profile" />
                    <span class="login-status online"></span>
                </div>
                <div class="nav-profile-text d-flex flex-column">
                    <span class="font-weight-bold mb-2">
                        @auth {{ Auth::user()->name }} @else Guest @endauth
                    </span>
                    <span class="text-secondary text-small">Project Manager</span>
                </div>
                <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
            </a>
        </li> {{-- TUTUP TAG LI PROFILE --}}

        <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/') }}">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon"></i>
            </a>
        </li>

        <li class="nav-item {{ request()->is('kategori*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/kategori') }}">
                <span class="menu-title">Kategori</span>
                <i class="mdi mdi-format-list-bulleted menu-icon"></i>
            </a>
        </li>

        <li class="nav-item {{ request()->is('buku*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/buku') }}">
                <span class="menu-title">Buku</span>
                <i class="mdi mdi-book-open-variant menu-icon"></i>
            </a>
        </li>

        <li class="nav-item {{ request()->is('pdf*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/pdf') }}">
                <span class="menu-title">pdf</span>
                <i class="mdi mdi-file-pdf menu-icon"></i>
            </a>
        </li>

        <li class="nav-item {{ request()->is('barang*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/barang') }}">
                <span class="menu-title">Tambah Barang</span>
                <i class="mdi mdi-printer menu-icon"></i>
            </a>
        </li>

        <li class="nav-item {{ request()->is('kota*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/kota') }}">
                <span class="menu-title">Kota</span>
                <i class="mdi mdi-map-marker menu-icon"></i>
            </a>
        </li>

        <li class="nav-item {{ request()->is('wilayah*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/wilayah') }}">
                <span class="menu-title">Wilayah</span>
                <i class="mdi mdi-map menu-icon"></i>
            </a>
        </li>

        <li class="nav-item {{ request()->is('pos*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/pos') }}">
                <span class="menu-title">POS</span>
                <i class="mdi mdi-cart menu-icon"></i>

                        <li class="nav-item {{ request()->is('pos*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/pos') }}">
                <span class="menu-title">Print Baru</span>

            </a>
        </li>
    </ul>
</nav>