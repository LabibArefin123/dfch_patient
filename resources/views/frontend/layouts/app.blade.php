<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @hasSection('title')
            @yield('title')
        @else
            {{ config('app.name', 'Dr. Fazlul Haque Colorectal Hospital Limited (DFCH)') }}
        @endif
    </title>

    <!-- Fonts -->
    <link rel="icon" type="image/png" href="{{ asset('uploads/images/icon.png') }}">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <!-- AOS CSS -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <!-- Bootstrap CSS -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/frontend/frontend.css') }}">
    <link rel="stylesheet" href="{{ asset('css/frontend/modals/custom_contact_modal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/frontend/modals/custom_land_modal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/frontend/modals/custom_email_modal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/frontend/modals/custom_location_modal.css') }}">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">
        <!-- Scroll Progress Bar -->
        <div id="scrollProgress"
            style="position: fixed; top: 0; left: 0; width: 0%; height: 4px; background-color: #ff6b6b; z-index: 9999; transition: width 0.25s ease;">
        </div>
        <main class="">
            @yield('content')
        </main>
    </div>
    <!-- Bootstrap JS + dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000, // Animation duration
            easing: 'ease-in-out', // Easing style
            once: true, // Only animate once
        });
    </script>

    @include('frontend.modal.custom_phone')
    @include('frontend.modal.custom_land_phone')
    @include('frontend.modal.footer.phone')
    @include('frontend.modal.footer.land_phone')
    @include('frontend.modal.footer.email')
    @include('frontend.modal.footer.location')

    <!-- Back to Top Button -->
    <button id="backToTop" class="back-to-top" aria-label="Back to Top">
        <i class="bi bi-arrow-up"></i>
    </button>
    {{-- Start of SweetAlert2 notifications --}}
    <script>
        window.appData = {
            success: @json(session('success')),
            errors: @json($errors->all())
        };
    </script>
    {{-- End of SweetAlert2 notifications --}}
    <script src="{{ asset('js/custom_frontend/sweet_alert.js') }}"></script> {{-- Sweet Alert Notification JS --}}
    <script src="{{ asset('js/custom_frontend/phone.js') }}"></script> {{-- Phone Modal JS --}}
    <script src="{{ asset('js/custom_frontend/land_phone.js') }}"></script> {{-- Land Phone Modal JS --}}
    <script src="{{ asset('js/custom_frontend/custom_top_map.js') }}"></script> {{-- Location Modal JS --}}
    <script src="{{ asset('js/custom_frontend/custom_banner.js') }}"></script> {{-- Location Modal JS --}}
    <script src="{{ asset('js/custom_frontend/language.js') }}"></script> {{-- Language Modal JS --}}
    <script src="{{ asset('js/custom_frontend/magnified_image_modal.js') }}"></script> {{-- Magnified Image Modal JS --}}
    <script src="{{ asset('js/custom_frontend/scroll_progress.js') }}"></script> {{-- Scroll Progress JS --}}
    <script src="{{ asset('js/custom_frontend/custom_back_top_button.js') }}"></script> {{-- Back to Top JS --}}
    <script src="{{ asset('js/custom_frontend/custom_footer_modal.js') }}"></script> {{-- Footer Modal JS --}}

</body>

</html>
