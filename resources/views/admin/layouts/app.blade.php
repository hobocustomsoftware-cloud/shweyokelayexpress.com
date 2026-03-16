<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Myanmar:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cargo.shweyokelayexpress.com/public/build/assets/app.css" />
    <link rel="stylesheet" href="https://cargo.shweyokelayexpress.com/public/build/assets/app2.css" />
    <script src="{{ asset('js/vfs_fonts.js') }}" defer></script>
    @livewireStyles
    @stack('styles')
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
        <!-- Navbar -->
        @include('admin.layouts.nav')
        <!-- /.navbar -->
        <!-- Main Sidebar -->
        @include('admin.layouts.sidebar')
        <!-- /.sidebar -->

        <!-- Main content -->
        <main class="app-main">
            @yield('content')
        </main>
        <!-- /.content -->

        <!-- Main Footer -->
        @include('admin.layouts.footer')

    </div>
    <!-- ./wrapper -->
    @livewireScripts
    <script type="module" src="{{ asset('build/assets/app2.js') }}"></script>
    @stack('scripts')
</body>

</html>