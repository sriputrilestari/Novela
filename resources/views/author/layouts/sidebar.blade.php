<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center"
       href="{{ route('author.dashboard') }}">
        <div class="sidebar-brand-icon">
            <i class="fas fa-feather-alt"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Author</div>
    </a>

    <hr class="sidebar-divider my-0">

    <!-- Dashboard -->
    <li class="nav-item {{ request()->routeIs('author.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('author.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        Konten
    </div>

    <!-- Novel -->
    <li class="nav-item {{ request()->routeIs('author.novel.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('author.novel.index') }}">
            <i class="fas fa-fw fa-book"></i>
            <span>Novel Saya</span>
        </a>
    </li>

    <!-- Komentar -->
    <li class="nav-item {{ request()->routeIs('author.comment.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('author.comment.index') }}">
            <i class="fas fa-fw fa-comments"></i>
            <span>Komentar</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        Akun
    </div>

    <!-- Profile -->
    <li class="nav-item {{ request()->routeIs('author.profile.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('author.profile.index') }}">
            <i class="fas fa-fw fa-user"></i>
            <span>Profile</span>
        </a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
