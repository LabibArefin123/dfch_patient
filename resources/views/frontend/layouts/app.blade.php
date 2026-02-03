<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'DFCH - Dr. Fazlul Haque Colorectal Hospital Limited') }}</title>

    <!-- Fonts -->
    <link rel="icon" type="image/png" href="{{ asset('uploads/images/icon.png') }}">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <!-- AOS CSS -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/frontend.css') }}">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">

        <main class="">
            @yield('content')
        </main>
    </div>
    <!-- Bootstrap JS + dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000, // Animation duration
            easing: 'ease-in-out', // Easing style
            once: true, // Only animate once
        });
    </script>
    <script>
        $(document).ready(function() {
            $('a[href^="#"]').on('click', function(e) {
                e.preventDefault();
                var target = this.hash;
                $('html, body').animate({
                    scrollTop: $(target).offset().top
                }, 800);
            });
        });

        function changeBackground(color) {
            document.getElementById('features').style.transition = "background 1.5s ease-in-out";
            document.getElementById('features').style.background =
                `radial-gradient(circle at center, ${color} 0%, #f8f9fa 80%)`;
        }
    </script>

</body>

</html>
