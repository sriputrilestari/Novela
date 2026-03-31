<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <ul class="navbar-nav ml-auto">

        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false"
                style="display:flex;align-items:center;gap:10px;padding:8px 12px;">

                {{-- Avatar inisial --}}
                <div
                    style="
                    width:36px;height:36px;border-radius:10px;
                    background:linear-gradient(135deg,#3d5af1 0%,#2d48e0 100%);
                    display:flex;align-items:center;justify-content:center;
                    font-family:'Plus Jakarta Sans',sans-serif;
                    font-size:13px;font-weight:800;color:#fff;
                    flex-shrink:0;border:2px solid rgba(61,90,241,.2);
                    letter-spacing:.5px;
                ">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>

                <div class="d-none d-lg-flex flex-column" style="line-height:1.2;text-align:left;">
                    <span
                        style="font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:#18192a;">
                        {{ auth()->user()->name }}
                    </span>
                    <span
                        style="font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:500;color:#9698ae;">
                        Admin
                    </span>
                </div>

                <i class="fas fa-chevron-down d-none d-lg-inline"
                    style="font-size:9px;color:#9698ae;margin-left:2px;"></i>
            </a>

            {{-- DROPDOWN --}}
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown"
                style="
                     border:1px solid #e8eaf3;border-radius:14px;
                     padding:8px;min-width:220px;
                     box-shadow:0 8px 32px rgba(24,25,42,.13)!important;
                     margin-top:6px;
                 ">

                {{-- Header info --}}
                <div style="padding:10px 14px 12px;border-bottom:1px solid #e8eaf3;margin-bottom:6px;">
                    <div
                        style="font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:#18192a;">
                        {{ auth()->user()->name }}
                    </div>
                    <div
                        style="font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;color:#9698ae;margin-top:2px;">
                        {{ auth()->user()->email }}
                    </div>
                    <div
                        style="
                        display:inline-flex;align-items:center;gap:5px;margin-top:8px;
                        background:#eef0fe;color:#3d5af1;
                        border:1px solid rgba(61,90,241,.2);border-radius:99px;
                        padding:3px 10px;font-size:11px;font-weight:700;
                        font-family:'Plus Jakarta Sans',sans-serif;
                    ">
                        🛡️ Admin</div>
                </div>

                {{-- Profile link --}}
                <a class="dropdown-item" href="{{ route('admin.profile.index') }}"
                    style="
                       display:flex;align-items:center;gap:10px;
                       border-radius:10px;padding:10px 12px;
                       font-family:'Plus Jakarta Sans',sans-serif;
                       font-size:13px;font-weight:600;color:#18192a;
                       transition:all .2s;
                   "
                    onmouseover="this.style.background='#eef0fe';this.style.color='#3d5af1'"
                    onmouseout="this.style.background='transparent';this.style.color='#18192a'">
                    <div
                        style="width:30px;height:30px;border-radius:8px;background:#eef0fe;display:flex;align-items:center;justify-content:center;font-size:13px;flex-shrink:0;">
                        👤</div>
                    Profil Saya
                </a>

                {{-- Divider --}}
                <div style="border-top:1px solid #e8eaf3;margin:6px 0;"></div>

                {{-- Logout --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item"
                        style="
                            display:flex;align-items:center;gap:10px;width:100%;
                            border-radius:10px;padding:10px 12px;border:none;
                            background:transparent;cursor:pointer;
                            font-family:'Plus Jakarta Sans',sans-serif;
                            font-size:13px;font-weight:600;color:#f1523d;
                            transition:all .2s;
                        "
                        onmouseover="this.style.background='#fef0ee'" onmouseout="this.style.background='transparent'">
                        <div
                            style="width:30px;height:30px;border-radius:8px;background:#fef0ee;display:flex;align-items:center;justify-content:center;font-size:13px;flex-shrink:0;">
                            🚪</div>
                        Keluar
                    </button>
                </form>

            </div>
        </li>

    </ul>

</nav>
