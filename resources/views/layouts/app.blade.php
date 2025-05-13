<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Promedic</title>

    <!-- jQuery -->
    <script src="{{ asset('build/assets/js/jquery-3.6.0.min.js') }}"></script>

    <!-- Bootstrap CSS + Icons (sin integrity para evitar mismatches) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Tu CSS personalizado -->
    <link rel="stylesheet" href="{{ asset('build/assets/css/dashboard.css') }}">


</head>

<body>
    @include('layouts.navbar')
    @include('layouts.menu')


    <div class="container py-4">
        @yield('content')
    </div>

    <!-- Bootstrap Bundle JS (Popper incluido) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Tus scripts personalizados -->
    <!-- app.js carga módulos, por eso type="module" -->
    <script type="module" src="{{ asset('build/assets/js/app.js') }}"></script>

    <!-- notifications.js y search.js se ejecutan tras parseo del DOM -->
    <script defer src="{{ asset('build/assets/js/notifications.js') }}"></script>
    <script defer src="{{ asset('build/assets/js/search.js') }}"></script>

    <!-- Push de scripts específicos de cada vista -->
    @stack('scripts')
</body>

</html>