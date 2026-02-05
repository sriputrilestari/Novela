<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- BRAND -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center"
       href="{{ route('admin.dashboard') }}">
        <div class="sidebar-brand-icon">
            <i class="fas fa-book-reader"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Admin Novela</div>
    </a>

    <hr class="sidebar-divider my-0">

    <!-- DASHBOARD -->
    <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <!-- USERS -->
    <div class="sidebar-heading">Kelola User</div>

    <li class="nav-item {{ request()->is('admin/authors*') || request()->is('admin/readers*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse"
           data-target="#collapseUsers" aria-expanded="true">
            <i class="fas fa-fw fa-user-friends"></i>
            <span>Users</span>
        </a>
        <div id="collapseUsers"
             class="collapse {{ request()->is('admin/authors*') || request()->is('admin/readers*') ? 'show' : '' }}">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->routeIs('admin.author.index') ? 'active' : '' }}"
                   href="{{ route('admin.author.index') }}">
                    Author
                </a>
                <a class="collapse-item {{ request()->routeIs('admin.reader.index') ? 'active' : '' }}"
                   href="{{ route('admin.reader.index') }}">
                    Reader
                </a>
            </div>
        </div>
    </li>

    <hr class="sidebar-divider">
    <div class="sidebar-heading">Kelola Novel</div>
    <!-- GENRE -->
    <li class="nav-item {{ request()->is('admin/genres*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse"
           data-target="#genreMenu" aria-expanded="true">
            <i class="fas fa-tags"></i>
            <span>Genre</span>
        </a>
        <div id="genreMenu"
             class="collapse {{ request()->is('admin/genres*') ? 'show' : '' }}">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->routeIs('admin.genre.index') ? 'active' : '' }}"
                   href="{{ route('admin.genre.index') }}">
                    Semua Genre
                </a>
            </div>
        </div>
    </li>

    <!-- NOVEL -->
    <li class="nav-item {{ request()->is('admin/novels*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse"
           data-target="#novelMenu" aria-expanded="true">
            <i class="fas fa-book-open"></i>
            <span>Novel</span>
        </a>
        <div id="novelMenu"
             class="collapse {{ request()->is('admin/novels*') ? 'show' : '' }}">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('admin.novels.index') }}">Semua Novel</a>
            </div>
        </div>
    </li>

    <hr class="sidebar-divider">

    <!-- LAPORAN -->
    <div class="sidebar-heading">Laporan</div>

    <li class="nav-item {{ request()->routeIs('admin.reports.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.reports.index') }}">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Report Novel</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <!-- SETTINGS -->
    <div class="sidebar-heading">Settings</div>

    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-user-cog"></i>
            <span>Profile</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </li>

</ul>
