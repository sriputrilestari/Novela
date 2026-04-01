<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Author Panel</title>

    <!-- Custom fonts -->
    <link href="{{ asset('backend/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">

    <!-- Custom styles -->
    <link href="{{ asset('backend/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        .btn-primary {
            background-color: #5B8DEF !important;
            border-color: #5B8DEF !important;
        }

        .btn-primary:hover {
            background-color: #4A7BE0 !important;
            border-color: #4A7BE0 !important;
        }

        .btn-outline-primary {
            color: #5B8DEF !important;
            border-color: #5B8DEF !important;
        }

        .btn-outline-primary:hover {
            background-color: #5B8DEF !important;
            color: white !important;
        }

        .badge.bg-primary {
            background-color: #5B8DEF !important;
        }
    </style>

</head>

<body id="page-top">

    <div id="wrapper">

        <!-- Sidebar -->
        @include('author.layouts.sidebar')
        <!-- End Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Navbar -->
                @include('author.layouts.navbar')
                <!-- End Navbar -->

                <!-- Page Content -->
                <div class="container-fluid">
                    @yield('content')
                </div>

            </div>
            <!-- End Main Content -->

            <!-- Footer -->
            @include('author.layouts.footer')
            <!-- End Footer -->

        </div>
        <!-- End Content Wrapper -->

    </div>
    <!-- End Wrapper -->

    <!-- Scroll to Top -->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- JS -->
    <script src="{{ asset('backend/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('backend/js/sb-admin-2.min.js') }}"></script>

    {{-- ── Custom Confirm Modal ── --}}
    <div id="confirmModal"
        style="display:none;position:fixed;inset:0;background:rgba(24,25,42,.45);z-index:99999;align-items:center;justify-content:center;backdrop-filter:blur(4px);font-family:'Plus Jakarta Sans',sans-serif;">
        <div
            style="background:#fff;border-radius:18px;border:1px solid #e8eaf3;padding:2rem 1.75rem;max-width:360px;width:90%;text-align:center;box-shadow:0 20px 60px rgba(24,25,42,.18);animation:cmIn .35s cubic-bezier(.16,1,.3,1) both;">
            <div id="cmIco" style="font-size:36px;margin-bottom:12px;"></div>
            <div id="cmTitle" style="font-size:17px;font-weight:800;color:#18192a;margin-bottom:6px;"></div>
            <div id="cmMsg" style="font-size:13px;color:#5a5f7a;line-height:1.7;margin-bottom:1.6rem;"></div>
            <div style="display:flex;gap:10px;">
                <button id="cmCancel" onclick="closeConfirm()"
                    style="flex:1;padding:11px;border-radius:10px;font-size:13.5px;font-weight:700;cursor:pointer;border:1.5px solid #e8eaf3;background:#f4f6fb;color:#5a5f7a;font-family:inherit;transition:.18s;"
                    onmouseover="this.style.background='#e8eaf3'" onmouseout="this.style.background='#f4f6fb'">
                    Batal
                </button>
                <button id="cmConfirm"
                    style="flex:1;padding:11px;border-radius:10px;font-size:13.5px;font-weight:700;cursor:pointer;border:none;color:#fff;font-family:inherit;transition:.18s;">
                    Lanjutkan
                </button>
            </div>
        </div>
    </div>

    <style>
        @keyframes cmIn {
            from {
                opacity: 0;
                transform: scale(.92) translateY(12px)
            }

            to {
                opacity: 1;
                transform: scale(1) translateY(0)
            }
        }
    </style>

    <script>
        let _cmCallback = null;

        const _cmTypes = {
            danger: {
                ico: '🗑️',
                btnBg: '#f1523d',
                btnHover: '#d43020',
                confirmText: 'Ya, Hapus'
            },
            warn: {
                ico: '☣️',
                btnBg: '#f1a83d',
                btnHover: '#c48020',
                confirmText: 'Ya, Lanjutkan'
            },
            info: {
                ico: '❓',
                btnBg: '#3d5af1',
                btnHover: '#2d48e0',
                confirmText: 'Ya, Lanjutkan'
            },
        };

        function showConfirm(type, title, msg, callback) {
            const t = _cmTypes[type] || _cmTypes.info;
            document.getElementById('cmIco').textContent = t.ico;
            document.getElementById('cmTitle').textContent = title;
            document.getElementById('cmMsg').textContent = msg;

            const btn = document.getElementById('cmConfirm');
            btn.textContent = t.confirmText;
            btn.style.background = t.btnBg;
            btn.onmouseover = () => btn.style.background = t.btnHover;
            btn.onmouseout = () => btn.style.background = t.btnBg;

            _cmCallback = callback;
            const modal = document.getElementById('confirmModal');
            modal.style.display = 'flex';
        }

        function closeConfirm() {
            document.getElementById('confirmModal').style.display = 'none';
            _cmCallback = null;
        }

        document.getElementById('cmConfirm').onclick = function() {
            closeConfirm();
            if (_cmCallback) _cmCallback();
        };

        document.getElementById('confirmModal').addEventListener('click', function(e) {
            if (e.target === this) closeConfirm();
        });
    </script>
</body>

</html>
