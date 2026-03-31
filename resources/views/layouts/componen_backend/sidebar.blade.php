<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    {{-- Brand --}}
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
        <div class="sidebar-brand-icon">
            <i class="fas fa-book-reader"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Admin Novela</div>
    </a>

    <hr class="sidebar-divider my-0">

    {{-- Dashboard --}}
    <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">
    <div class="sidebar-heading">Kelola User</div>

    {{-- Reader --}}
    <li class="nav-item {{ request()->routeIs('admin.reader.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.reader.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Reader</span>
        </a>
    </li>

    {{-- Author --}}
    <li class="nav-item {{ request()->routeIs('admin.authors.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.author.index') }}">
            <i class="fas fa-fw fa-user-tie"></i>
            <span>Author</span>
        </a>
    </li>

    <hr class="sidebar-divider">
    <div class="sidebar-heading">Kelola Novel</div>

    {{-- Genre --}}
    <li class="nav-item {{ request()->routeIs('admin.genre.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.genre.index') }}">
            <i class="fas fa-fw fa-tags"></i>
            <span>Genre</span>
        </a>
    </li>

    {{-- Novel --}}
    <li class="nav-item {{ request()->routeIs('admin.novels.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.novels.index') }}">
            <i class="fas fa-fw fa-book-open"></i>
            <span>Novel</span>
        </a>
    </li>

    <hr class="sidebar-divider">
    <div class="sidebar-heading">Laporan</div>

    {{-- Report --}}
    <li class="nav-item {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.reports.index') }}">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Report Novel</span>
        </a>
    </li>

    <hr class="sidebar-divider">
    <div class="sidebar-heading">Akun</div>

    {{-- Profile --}}
    <li class="nav-item {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.profile.index')}}">
            <i class="fas fa-fw fa-user-cog"></i>
            <span>Profile</span>
        </a>
    </li>

    {{-- Logout --}}
    <li class="nav-item">
        <a class="nav-link" href="{{ route('logout') }}"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <span>Keluar</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    {{-- Toggle Sidebar --}}
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
