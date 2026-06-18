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
    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- AOS CSS -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <!-- Bootstrap CSS -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/frontend/frontend.css') }}">

    {{-- BACK TO TOP SECTION --}}
    <link rel="stylesheet" href="{{ asset('css/frontend/custom_layout/back_to_top/bot_layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/frontend/custom_layout/back_to_top/bot_state.css') }}">
    <link rel="stylesheet" href="{{ asset('css/frontend/custom_layout/back_to_top/bot_hover.css') }}">

    {{-- TOPBAR AND FOOTER MODAL SECTION --}}
    <link rel="stylesheet" href="{{ asset('css/frontend/modals/custom_location_modal_top.css') }}">
    <link rel="stylesheet" href="{{ asset('css/frontend/modals/custom_location_modal_topr.css') }}">
    <link rel="stylesheet" href="{{ asset('css/frontend/modals/custom_contact_modal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/frontend/modals/custom_phone_modal_rt.css') }}">
    <link rel="stylesheet" href="{{ asset('css/frontend/modals/custom_land_modal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/frontend/modals/custom_email_modal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/frontend/modals/custom_location_modal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/frontend/modals/custom_location_modal_footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/frontend/modals/custom_phone_modal_footer.css') }}">

    {{-- IMAGE MODAL SECTION --}}
    <link rel="stylesheet" href="{{ asset('css/frontend/modals/image_part/image_modal_layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/frontend/modals/image_part/image_modal_content.css') }}">
    <link rel="stylesheet" href="{{ asset('css/frontend/modals/image_part/image_modal_close.css') }}">

    {{-- LOGIN PAGE SECTION --}}
    <link rel="stylesheet" href="{{ asset('css/backend/login_page/login_base.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/login_page/login_layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/login_page/login_logo.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/login_page/login_buttons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/login_page/login_modal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/login_page/login_responsive.css') }}">
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
    <script>
        window.appConfig = {
            welcomeUrl: "{{ route('welcome') }}"
        };
    </script>

    @include('frontend.modal.custom_location')
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

    {{-- NAVIGATION SECTION --}}
    <script src="{{ asset('js/custom_frontend/navigation/welcome_navigation.js') }}"></script> {{-- Welcome Navigation JS --}}
    <script src="{{ asset('js/custom_frontend/navigation/navbar-toggle.js') }}"></script> {{-- Navbar Toggle JS --}}
    <script src="{{ asset('js/custom_frontend/navigation/scroll_progress.js') }}"></script> {{-- Scroll Progress JS --}}

    {{-- MAPS SECTION --}}
    <script src="{{ asset('js/custom_frontend/maps/custom_top_map.js') }}"></script> {{-- Top Map Modal JS --}}

    {{-- MODAL SECTION --}}
    <script src="{{ asset('js/custom_frontend/modals/phone.js') }}"></script> {{-- Phone Modal JS --}}
    <script src="{{ asset('js/custom_frontend/modals/land_phone.js') }}"></script> {{-- Land Phone Modal JS --}}
    <script src="{{ asset('js/custom_frontend/modals/language.js') }}"></script> {{-- Language Modal JS --}}
    <script src="{{ asset('js/custom_frontend/modals/magnified_image_modal.js') }}"></script> {{-- Magnified Image Modal JS --}}
    <script src="{{ asset('js/custom_frontend/modals/custom_footer_modal.js') }}"></script> {{-- Footer Modal JS --}}
    <script src="{{ asset('js/custom_frontend/modals/location_footer_config.js') }}"></script> {{-- Footer Location Config JS --}}
    <script src="{{ asset('js/custom_frontend/modals/location_footer_actions.js') }}"></script> {{-- Footer Location Action JS --}}

    {{-- UI SECTION --}}
    <script src="{{ asset('js/custom_frontend/ui/custom_banner.js') }}"></script> {{-- banner aniamtion JS --}}
    <script src="{{ asset('js/custom_frontend/ui/facility_dropdown.js') }}"></script> {{-- Facility Dropdown JS --}}
    <script src="{{ asset('js/custom_frontend/ui/custom_back_top_button.js') }}"></script> {{-- Back to Top JS --}}


</body>

</html>
