@extends('adminlte::master')

@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\PreloaderHelper')

<link rel="icon" type="image/png" href="{{ asset('uploads/images/icon.png') }}">
<link rel="stylesheet" href="{{ asset('css/custom_backend.css') }}">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet"> --}}

@section('classes_body', $layoutHelper->makeBodyClasses())
@section('body_data', $layoutHelper->makeBodyData())

@section('body')
    <div class="wrapper">
        <!-- start of validate modal and its animation -->
        @include('backend.global_modals.modal_validation')
        <!-- Bootstrap 5 Premium Image Zoom Modal -->
        @include('backend.global_modals.modal_image_zoom')
        <!-- xray image zoom modal animation -->
        @include('backend.global_modals.modal_xray_image')
        <!-- create animation model -->
        @include('backend.global_modals.modal_create_confirm')
        <!-- edit animation model -->
        @include('backend.global_modals.modal_edit_confirm')
        <!-- start of delete animation model -->
        @include('backend.global_modals.modal_delete_confirm')

        <div id="dtErrorToast" class="dt-error-toast">
            <div class="dt-error-box">
                <h5>⚠ System Notice</h5>
                <p id="dtErrorMessage">
                    Something went wrong while loading data.
                </p>
                <button onclick="closeDtToast()" class="btn btn-sm btn-secondary mt-2">
                    Close
                </button>
            </div>
        </div>


        {{-- Preloader --}}
        @if ($preloaderHelper->isPreloaderEnabled())
            @include('adminlte::partials.common.preloader')
        @endif

        {{-- Top Navbar --}}
        @if ($layoutHelper->isLayoutTopnavEnabled())
            @include('adminlte::partials.navbar.navbar-layout-topnav')
        @else
            @include('adminlte::partials.navbar.navbar')
        @endif

        {{-- Sidebar --}}
        @unless ($layoutHelper->isLayoutTopnavEnabled())
            @include('adminlte::partials.sidebar.left-sidebar')
        @endunless

        {{-- Content --}}
        @empty($iFrameEnabled)
            @include('adminlte::partials.cwrapper.cwrapper-default')
        @else
            @include('adminlte::partials.cwrapper.cwrapper-iframe')
        @endempty

        {{-- Footer --}}
        @include('frontend.layouts.footer')
        @hasSection('footer')
            @yield('footer')
        @endif

        {{-- Right Sidebar --}}
        @if ($layoutHelper->isRightSidebarEnabled())
            @include('adminlte::partials.sidebar.right-sidebar')
        @endif
    </div>
@stop

@section('adminlte_js')
    @stack('js')
    @yield('js')
    <script src="{{ asset('js/backend/global_js/auth/logout-handler.js') }}"></script>
    <script src="{{ asset('js/backend/global_js/auth/password-toggle.js') }}"></script>

    <script src="{{ asset('js/backend/global_js/forms/action-confirmation.js') }}"></script>
    <script src="{{ asset('js/backend/global_js/forms/form-dirty-validator.js') }}"></script>
    <script src="{{ asset('js/backend/global_js/forms/delete-confirmation.js') }}"></script>

    <script src="{{ asset('js/backend/global_js/notifications_part/flash-alerts.js') }}"></script>
    <script src="{{ asset('js/backend/global_js/notifications_part/limit-warning.js') }}"></script>

    <script src="{{ asset('js/backend/global_js/ui_part/global_search/global-search-init.js') }}"></script>
    <script src="{{ asset('js/backend/global_js/ui_part/global_search/global-search-config.js') }}"></script>
    <script src="{{ asset('js/backend/global_js/ui_part/global_search/global-search-fetch.js') }}"></script>
    <script src="{{ asset('js/backend/global_js/ui_part/global_search/global-search-render.js') }}"></script>
    <script src="{{ asset('js/backend/global_js/ui_part/global_search/global-search-ui.js') }}"></script>
    <script src="{{ asset('js/backend/global_js/ui_part/date-formatter.js') }}"></script>
    <script src="{{ asset('js/backend/global_js/ui_part/data-table-loader.js') }}"></script>

    <script>
        window.Laravel = {
            csrfToken: "{{ csrf_token() }}",
            userRole: "{{ Auth::check() ? Auth::user()->getRoleNames()->first() : '' }}",
            searchUrl: "{{ route('global.search') }}",
            totalRecords: {{ $totalRecords ?? 0 }},
            sessions: {
                loginSuccess: "{{ session('login_success') }}",
                logoutSuccess: "{{ session('logout_success') }}",
                loginError: "{{ session('login_error') }}",
                // 🆕 Added standard sessions:
                success: "{{ session('success') }}",
                error: "{{ session('error') }}",
                warning: "{{ session('warning') }}",
                info: "{{ session('info') }}"
            }
        };
    </script>

    <!-- start of jquery and bootstrap table -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- end of jquery and bootstrap table -->

    {{-- start of image zoom modal js --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imageZoomModal = document.getElementById('imageZoomModal');
            if (imageZoomModal) {
                imageZoomModal.addEventListener('show.bs.modal', function(event) {
                    // Get the link element that triggered the modal
                    const triggerElement = event.relatedTarget;
                    // Extract the image source from the data attribute
                    const imgSrc = triggerElement.getAttribute('data-bs-img-src');
                    // Dynamically update the modal image source
                    const modalImage = imageZoomModal.querySelector('#modalZoomImage');
                    modalImage.src = imgSrc;
                });
            }
        });
    </script>
    {{-- start of image zoom modal js --}}
@section('plugins.Datatables', true)
@stop
