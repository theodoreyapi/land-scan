@if (Auth::check())
@else
    <script>
        window.location.href = "{{ URL::to('logout') }}";
    </script>
@endif
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-layout="transparent">

<head>

    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scanner | {{ $title }}</title>

    <meta name="description"
        content="AptioTalent - vous permet de postuler a des offres, noté les employés et employeurs.">
    <meta name="author" content="AptioTech">
    <meta name="robots" content="index, follow">

    <!-- Apple Touch Icon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ URL::asset('') }}assets/img/apple-touch-icon.png">

    <!-- Favicon -->
    <link rel="icon" href="{{ URL::asset('') }}assets/img/favicon.png" type="image/x-icon">
    <link rel="shortcut icon" href="{{ URL::asset('') }}assets/img/favicon.png" type="image/x-icon">

    <!-- Theme Script js -->
    <script src="{{ URL::asset('') }}assets/js/theme-script.js"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/css/bootstrap.min.css">

    <!-- Feather CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/icons/feather/feather.css">

    <!-- Tabler Icon CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/tabler-icons/tabler-icons.css">

    @stack('csss')

</head>

<body class="data-layout-transparent">

    <div id="global-loader">
        <div class="page-loader"></div>
    </div>

    <!-- Main Wrapper -->
    <div class="main-wrapper">

        @include('layouts.header')

        @include('layouts.menus')

        <!-- Page Wrapper -->
        <div class="page-wrapper">
            @yield('content')

            @include('layouts.footer')

        </div>
        <!-- /Page Wrapper -->

    </div>
    <!-- /Page Wrapper -->
    @stack('modale')

    </div>
    <!-- /Main Wrapper -->
    @include('layouts.scripts')
</body>

</html>
