<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CPSU | DARE</title>
    <link rel="stylesheet" href="{{ asset('template/plugins/toastr/toastr.min.css') }}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('template/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('template/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('template/dist/css/adminlte.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('template/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('template/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('template/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- Logo  -->
    <link rel="shortcut icon" type="" href="{{ asset('template/img/CPSU_L.png') }}">
</head>

<style>
    .nav-link.active {
        font-weight: bold;
        color: #28a745 !important; /* Bootstrap success color */
        border-bottom: 3px solid #28a745; /* green underline */
    }

    .nav-link:hover {
        background-color: rgba(40, 167, 69, 0.1); /* light green hover effect */
        transition: 0.3s;
    }

    .small-footer {
    padding: 5px 10px !important;
    font-size: 13px;
    background-color: #f9f9f9; /* optional: lighten the footer */
    color: #555;
}
</style>

<body class="hold-transition sidebar-collapse layout-footer-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        {{-- <nav class="main-header navbar navbar-expand-md navbar-light" style="background-color: #1F5036;"> --}}
        <div class="main-header navbar navbar-expand-md navbar-light container-fluid"
            style="background-color: #1F5036;">
            <a href="{{ route('index') }}" class="mt-2">
                <img src="{{ asset('template/img/CPSU_L.png') }}" alt="AdminLTE Logo" class="brand-image img-circle"
                    style="box-shadow: 0 0 4px white;width: 2%;">&nbsp;
                <span class="brand-text text-light text-bold"> Digital Archive for Research and Explore</span>
            </a>
            <!-- Right navbar links -->
            {{-- <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                                <i class="fas fa-user"></i>&nbsp;&nbsp;Signed In: MICHAEL BALIVIA
                            </a>
                        </li>
                    </ul> --}}
            {{--    <a href="{{ route('getLogin') }}" class="ml-auto">
                        <span class="text-white"><i class="fas fa-user-circle text-white"></i> Sign In</span>
                    </a> --}}
        </div>
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('index') }}" class="nav-link" style="color: black;">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link" style="color: black;">Catalog</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('folders') }}"
                        class="nav-link {{ request()->routeIs('folders') || request()->routeIs('documentView') ? 'active text-success' : '' }}"
                        style="color: black;">Folders</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('userView') }}"
                        class="nav-link {{ request()->routeIs('userView') ? 'active text-success' : '' }}"
                        style="color: black;">Users</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link" style="color: black;">Logs</a>
                </li>
            </ul>
            <!-- Right-aligned section -->
            <ul class="navbar-nav ml-auto"> <!-- This pushes the item to the right -->
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('logout') }}" class="nav-link"
                        style="border-radius: 3px 3px 3px 3px; border: 1px solid grey; color: black;">
                        <i class="fas fa-sign-out-alt"></i> Sign out
                    </a>
                </li>
            </ul>
        </nav>
        <div class="content-wrapper">
            @yield('body') <!-- This will display the content from index.blade.php -->
        </div>
        <!-- Main footer -->
        <footer class="main-footer small-footer">
    <strong>Maintained and Managed by MIS.</strong> All rights reserved.
</footer>
        <aside class="control-sidebar control-sidebar-dark">
        </aside>
    </div>
    <script src="{{ asset('template/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('template/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('template/dist/js/adminlte.min.js') }}"></script>
    <!-- Toastr -->
    <script src="{{ asset('template/plugins/toastr/toastr.min.js') }}"></script>
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('template/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('template/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('template/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('template/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('template/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('template/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('template/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('template/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('template/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('template/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('template/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('template/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('template/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('template/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        @if (Session::has('error'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                'positionClass': 'toast-bottom-right'
            }
            toastr.error("{{ session('error') }}")
        @endif

        @if (Session::has('error1'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                'positionClass': 'toast-bottom-center'
            }
            toastr.error("{{ session('error1') }}")
        @endif
        @if (Session::has('success'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                'positionClass': 'toast-bottom-right'
            }
            toastr.success("{{ session('success') }}")
        @endif
        @if ($errors->any())
            var errorMessage = "";
            @foreach ($errors->all() as $error)
                errorMessage += "{{ $error }}" + "<br>";
            @endforeach
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-bottom-right"
            };
            toastr.error(errorMessage);
        @endif
    </script>
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": false,
                "lengthChange": true,
                "autoWidth": true,
                //"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
</body>

</html>
