<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('backend/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('backend/css/sb-admin-2.min.css') }}" rel="stylesheet">

</head>

<body id="page-top">

    <div id="ns"></div>

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        @include('layouts.componen_backend.sidebar')
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                @include('layouts.componen_backend.navbar')
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            @include('layouts.componen_backend.footer')
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('backend/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('backend/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('backend/js/sb-admin-2.min.js') }}"></script>

    <!-- Page level plugins -->
    <script src="{{ asset('backend/vendor/chart.js/Chart.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('backend/js/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('backend/js/demo/chart-pie-demo.js') }}"></script>


    <script>
        function confirmAction(message, callback) {
            const modal = document.createElement('div');
            modal.innerHTML = `
        <div style="
            position:fixed;
            top:0;left:0;width:100%;height:100%;
            background:rgba(0,0,0,0.4);
            display:flex;
            align-items:center;
            justify-content:center;
            z-index:99999;
        ">
            <div style="
                background:white;
                padding:20px;
                border-radius:12px;
                width:300px;
                text-align:center;
                box-shadow:0 10px 30px rgba(0,0,0,0.2);
            ">
                <h4 style="margin-bottom:10px;">Konfirmasi</h4>
                <p style="font-size:14px;color:#555;">${message}</p>

                <div style="margin-top:15px;display:flex;gap:10px;justify-content:center;">
                    <button id="cancelBtn" style="
                        padding:8px 16px;
                        border:none;
                        background:#eee;
                        border-radius:8px;
                        cursor:pointer;
                    ">Batal</button>

                    <button id="okBtn" style="
                        padding:8px 16px;
                        border:none;
                        background:#3d5af1;
                        color:white;
                        border-radius:8px;
                        cursor:pointer;
                    ">Ya</button>
                </div>
            </div>
        </div>
    `;

            document.body.appendChild(modal);

            modal.querySelector('#cancelBtn').onclick = () => {
                modal.remove();
            };

            modal.querySelector('#okBtn').onclick = () => {
                callback();
                modal.remove();
            };
        }
    </script>

    <script>
        const NC = {
            success: {
                bg: '#e6fff7',
                br: '#00c9a7',
                tx: '#007f6b',
                ic: '🎉'
            },
            error: {
                bg: '#ffeaea',
                br: '#f1523d',
                tx: '#a12b1b',
                ic: '❌'
            },
            info: {
                bg: '#eef0fe',
                br: '#3d5af1',
                tx: '#2d48e0',
                ic: '💡'
            },
            warn: {
                bg: '#fff6e6',
                br: '#f1a83d',
                tx: '#b07010',
                ic: '⚠️'
            }
        };

        function showN(type, title, msg) {
            const c = NC[type] || NC.info;

            const el = document.createElement('div');
            el.className = 'nt2';

            el.innerHTML = `
        <div class="nt2-left" style="background:${c.bg}; color:${c.tx}">
            ${c.ic}
        </div>
        <div>
            <div class="nt2-title">${title}</div>
            <div class="nt2-msg">${msg}</div>
        </div>
        <div class="nt2-close" onclick="closeN(this.parentElement)">✕</div>
        <div class="nt2-progress" style="background:${c.br}"></div>
    `;

            document.getElementById('ns').appendChild(el);

            setTimeout(() => closeN(el), 4000);
        }

        function closeN(el) {
            if (!el) return;
            el.classList.add('out');
            setTimeout(() => el.remove(), 300);
        }

        document.addEventListener('DOMContentLoaded', () => {
            @if (session('success'))
                showN('success', 'Berhasil', @json(session('success')));
            @endif
            @if (session('error'))
                showN('error', 'Gagal', @json(session('error')));
            @endif
            @if (session('warning'))
                showN('warn', 'Perhatian', @json(session('warning')));
            @endif
            @if (session('info'))
                showN('info', 'Info', @json(session('info')));
            @endif
        });
    </script>

    {{-- Taruh di dalam <head> pada layouts/admin.blade.php --}}
    <style>
        /* Container notifikasi */
        #ns {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 99999;
            display: flex;
            flex-direction: column;
            gap: 10px;
            min-width: 320px;
            max-width: 380px;
        }

        /* Card notifikasi */
        .nt2 {
            display: flex;
            align-items: stretch;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            overflow: hidden;
            position: relative;
            animation: ntSlideIn .3s ease forwards;
        }

        .nt2.out {
            animation: ntSlideOut .3s ease forwards;
        }

        /* Strip kiri berwarna */
        .nt2-left {
            width: 48px;
            min-width: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            border-radius: 12px 0 0 12px;
        }

        /* Teks */
        .nt2>div:nth-child(2) {
            padding: 12px 14px;
            flex: 1;
        }

        .nt2-title {
            font-weight: 700;
            font-size: 13px;
            color: #2d3748;
            margin-bottom: 2px;
        }

        .nt2-msg {
            font-size: 12px;
            color: #718096;
            line-height: 1.5;
        }

        /* Tombol close */
        .nt2-close {
            padding: 10px 12px;
            cursor: pointer;
            color: #a0aec0;
            font-size: 14px;
            display: flex;
            align-items: flex-start;
            transition: color .2s;
        }

        .nt2-close:hover {
            color: #4a5568;
        }

        /* Progress bar bawah */
        .nt2-progress {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3px;
            width: 100%;
            border-radius: 0 0 12px 12px;
            animation: ntProgress 4s linear forwards;
        }

        /* Animasi */
        @keyframes ntSlideIn {
            from {
                opacity: 0;
                transform: translateX(60px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes ntSlideOut {
            from {
                opacity: 1;
                transform: translateX(0);
            }

            to {
                opacity: 0;
                transform: translateX(60px);
            }
        }

        @keyframes ntProgress {
            from {
                width: 100%;
            }

            to {
                width: 0%;
            }
        }
    </style>

</body>

</html>
