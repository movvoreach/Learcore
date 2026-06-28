<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin ផ្ទាំងគ្រប់គ្រង | LMS')</title>
    <link rel="icon" type="image/png" href="{{ asset('backend/dist/img/spilogo.png') }}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/fontawesome-free/css/all.min.css') }}">
    {{-- âœ… Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=ប្រភព+Sans+Pro:wght@300;400;600;700&family=Battambang:wght@300;400;600;700&display=swap"
        rel="stylesheet">

    {{-- âœ… Font Awesome (must load BEFORE AdminLTE) --}}
    <link rel="stylesheet" href="{{ asset('backend/plugins/fontawesome-free/css/all.min.css') }}">

    {{-- âœ… AdminLTE --}}
    <link rel="stylesheet" href="{{ asset('backend/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/dist/css/admin-business.css') }}">

    {{-- កម្មវិធីបន្ថែមជាជម្រើស --}}
    <link rel="stylesheet" href="{{ asset('backend/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

    {{-- Your page styles --}}
    @stack('styles')
    <style>
    /* ========================================== ðŸŽ“ ប្រព័ន្ធសិក្សាវិទ្យាស្ថានសន្តប៉ូល - រចនាប័ទ្មរបារចំហៀងពេញ ========================================== */
    :root {
        --sidebar-width: 300px;
        --sidebar-font: 21px;
        --sidebar-sub-font: 19px;
        --sidebar-icon: 17px;
        --sidebar-sub-icon: 14px;
        --sidebar-arrow: 14px;
        --sidebar-padding-y: 10px;
        --sidebar-padding-x: 12px;
    }

    .main-sidebar {
        width: var(--sidebar-width) !important;
        font-family: 'Battambang', sans-serif !important;
    }

    .content-wrapper,
    .main-header,
    .main-footer {
        margin-left: var(--sidebar-width) !important;
    }

    .sidebar-collapse .main-sidebar {
        width: 4.6rem !important;
    }

    .sidebar-collapse .content-wrapper,
    .sidebar-collapse .main-header,
    .sidebar-collapse .main-footer {
        margin-left: 4.6rem !important;
    }

    .main-sidebar .sidebar {
        width: 100% !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
    }

    .main-sidebar .brand-link {
        padding: 10px 12px !important;
    }

    .main-sidebar .brand-text {
        font-size: 18px !important;
        font-weight: 500;
    }

    .main-sidebar .nav-sidebar {
        width: 100% !important;
    }

    .main-sidebar .nav-sidebar .nav-item {
        width: 100% !important;
    }

    .main-sidebar .nav-sidebar .nav-link {
        display: flex !important;
        align-items: center !important;
        width: 100% !important;
        padding: var(--sidebar-padding-y) var(--sidebar-padding-x) !important;
        transition: all 0.2s ease;
    }

    .main-sidebar .nav-sidebar .nav-icon {
        width: 30px;
        text-align: center;
        font-size: var(--sidebar-icon) !important;
        margin-right: 14px;
    }

    .main-sidebar .nav-treeview .nav-icon {
        font-size: var(--sidebar-sub-icon) !important;
    }

    .main-sidebar .nav-sidebar .nav-link p {
        flex: 1 !important;
        margin: 0 !important;
        font-size: var(--sidebar-font) !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
    }

    .main-sidebar .nav-treeview .nav-link p {
        font-size: var(--sidebar-sub-font) !important;
    }

    .main-sidebar .nav-sidebar .nav-link .right {
        margin-left: auto !important;
        font-size: var(--sidebar-arrow) !important;
        opacity: .8;
    }

    .main-sidebar .nav-treeview .nav-link {
        padding-left: 55px !important;
    }

    .nav-item.menu-open>.nav-link {
        background: rgba(255, 255, 255, 0.05);
    }

    .main-sidebar .nav-header {
        padding: 12px 12px 6px !important;
        font-size: 13px !important;
        letter-spacing: 0;
        opacity: .75;
    }

    .main-sidebar .nav-sidebar .nav-link:hover {
        background: rgba(255, 255, 255, 0.08);
    }

    .main-sidebar .nav-treeview .nav-link {
        padding-top: 8px !important;
        padding-bottom: 8px !important;
    }

    .main-sidebar .user-panel .info a {
        font-size: 15px;
        color: #cfd8e3;
    }

    @media (max-width: 1366px) {
        :root {
            --sidebar-font: 16px;
            --sidebar-sub-font: 15px;
        }
    }

    @media (max-width: 992px) {
        :root {
            --sidebar-font: 15px;
            --sidebar-sub-font: 14px;
        }
    }
</style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @include('admin.partials.header')
        @include('admin.partials.sidebar')

        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    @yield('page-title')
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </section>
        </div>

    </div>

    {{-- âœ… JS order: jQuery -> Bootstrap -> plugins -> AdminLTE --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>

    <script src="{{ asset('backend/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('backend/dist/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('backend/dist/js/admin-business.js') }}"></script>

    <script>
        $(function() {
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            });



            // function showPageLoader() {
            //     $pageLoader.addClass('is-active').attr('aria-hidden', 'false');
            // }


        });
    </script>

    @stack('scripts')
</body>

</html>
