<link rel="stylesheet" href="{{ asset('css/frontend/custom_layout/navbar/navbar_base.css') }}">
<link rel="stylesheet" href="{{ asset('css/frontend/custom_layout/navbar/navbar_links.css') }}">

<link rel="stylesheet" href="{{ asset('css/frontend/custom_layout/navbar/navbar_dropdown_base.css') }}">
<link rel="stylesheet" href="{{ asset('css/frontend/custom_layout/navbar/navbar_dropdown_items.css') }}">
<link rel="stylesheet" href="{{ asset('css/frontend/custom_layout/navbar/navbar_dropdown_submenu.css') }}">

<link rel="stylesheet" href="{{ asset('css/frontend/custom_layout/navbar/navbar_animation.css') }}">

<link rel="stylesheet" href="{{ asset('css/frontend/custom_layout/navbar/navbar_buttons.css') }}">

<link rel="stylesheet" href="{{ asset('css/frontend/custom_layout/navbar/navbar_toggle.css') }}">
<link rel="stylesheet" href="{{ asset('css/frontend/custom_layout/navbar/navbar_overlay.css') }}">
<link rel="stylesheet" href="{{ asset('css/frontend/custom_layout/navbar/navbar_sidebar.css') }}">
<link rel="stylesheet" href="{{ asset('css/frontend/custom_layout/navbar/navbar_mobile_dropdown.css') }}">
<nav class="main-header navbar navbar-expand-md navbar-light navbar-white bg-info"
    style="padding-left: 30px; padding-right: 30px;">
    <div class="container-fluid">

        {{-- ==========================================
    LOGO
========================================== --}}
        <a href="{{ route('welcome') }}" class="navbar-brand">

            @php
                $logoPath = null;

                if (!empty($orgPicture)) {
                    foreach (['jpg', 'jpeg', 'png', 'webp'] as $ext) {
                        $path = public_path('uploads/images/backend/organization/' . $orgPicture . '.' . $ext);

                        if (file_exists($path)) {
                            $logoPath = asset('uploads/images/backend/organization/' . $orgPicture . '.' . $ext);

                            break;
                        }
                    }
                }
            @endphp

            @if ($logoPath)
                <img src="{{ $logoPath }}" alt="{{ $orgName }}" class="brand-image elevation-3"
                    style="width:350px;height:75px;object-fit:contain;">
            @else
                <img src="{{ asset('uploads/images/logo.png') }}" alt="Default Logo" class="brand-image elevation-3"
                    style="width:350px;height:75px;object-fit:contain;">
            @endif

        </a>


        {{-- ==========================================
    MOBILE TOGGLER
========================================== --}}
        <button type="button" id="navbarToggle" class="custom-navbar-toggler" aria-label="Open Menu">

            <span></span>
            <span></span>
            <span></span>

        </button>


        {{-- ==========================================
    MOBILE SIDEBAR
========================================== --}}
        <div class="mobile-navbar-overlay"></div>


        <div class="mobile-navbar">

            <div class="mobile-navbar-header">

                <h5 class="mb-0">Menu</h5>

                <button type="button" class="mobile-navbar-close">
                    &times;
                </button>

            </div>

            <ul class="mobile-navbar-menu">

                <li>
                    <a href="{{ route('welcome') }}">
                        Overview
                    </a>
                </li>

                <li>
                    <a href="#about">
                        About
                    </a>
                </li>

                <li>
                    <a href="#departments">
                        Departments
                    </a>
                </li>

                {{-- Facilities --}}
                <li class="mobile-dropdown">

                    <a href="javascript:void(0)" class="mobile-dropdown-toggle">

                        Facilities

                        <span class="dropdown-arrow">
                            <i class="fas fa-chevron-right"></i>
                        </span>

                    </a>

                    <ul class="mobile-submenu">

                        <li><a href="{{ route('facility_1') }}">Emergency Department</a></li>
                        <li><a href="{{ route('facility_2') }}">Intensive Care Unit (ICU)</a></li>
                        <li><a href="{{ route('facility_3') }}">Operation Theatre (OT)</a></li>
                        <li><a href="{{ route('facility_4') }}">Post Operative Room</a></li>
                        <li><a href="{{ route('facility_5') }}">Ward</a></li>
                        <li><a href="{{ route('facility_6') }}">Cabin</a></li>
                        <li><a href="{{ route('facility_7') }}">Laboratory</a></li>
                        <li><a href="{{ route('facility_8') }}">Radiology & Imaging</a></li>
                        <li><a href="{{ route('facility_9') }}">ECG</a></li>
                        <li><a href="{{ route('facility_10') }}">Colonoscopy</a></li>
                        <li><a href="{{ route('facility_11') }}">Pharmacy</a></li>
                        <li><a href="{{ route('facility_12') }}">24-Hour Ambulance Service</a></li>

                    </ul>

                </li>

                <li>
                    <a href="#services">
                        Services
                    </a>
                </li>

                {{-- Specialists --}}
                <li class="mobile-dropdown">

                    <a href="javascript:void(0)" class="mobile-dropdown-toggle">

                        Our Specialists

                        <span class="dropdown-arrow">
                            <i class="fas fa-chevron-right"></i>
                        </span>

                    </a>

                    <ul class="mobile-submenu">

                        <li><a href="{{ route('doc_1') }}">Prof. Dr. AKM Fazlul Haque</a></li>
                        <li><a href="{{ route('doc_2') }}">Dr. Asif Almas Haque</a></li>
                        <li><a href="{{ route('doc_3') }}">Dr. Fatema Sharmin (Anny)</a></li>
                        <li><a href="{{ route('doc_4') }}">Dr. Sakib Sarwat Haque</a></li>
                        <li><a href="{{ route('doc_5') }}">Dr. Asma Husain Noora</a></li>

                    </ul>

                </li>

                <li>
                    <a href="#goals">
                        Our Goals
                    </a>
                </li>

                <li>
                    <a href="{{ route('login') }}">
                        Hospital Login
                    </a>
                </li>

            </ul>

        </div>




        {{-- ==========================================
    DESKTOP NAVIGATION
========================================== --}}
        <div class="collapse navbar-collapse justify-content-center order-2" id="navbarCollapse">

            <ul class="navbar-nav">

                {{-- Overview --}}
                <li class="nav-item">

                    <a href="{{ route('welcome') }}"
                        class="nav-link custom-link {{ request()->routeIs('welcome') ? 'active' : '' }}">

                        Overview

                    </a>

                </li>

                {{-- About --}}
                <li class="nav-item">

                    <a href="#about" class="nav-link custom-link">

                        About

                    </a>

                </li>

                {{-- Departments --}}
                <li class="nav-item">

                    <a href="#departments" class="nav-link custom-link">

                        Departments

                    </a>

                </li>

                {{-- Facilities --}}
                <li class="nav-item dropdown" id="facility_dropdown">

                    <a href="#facilities" class="nav-link custom-link dropdown-toggle" role="button">

                        Facilities

                    </a>

                    <ul class="dropdown-menu">

                        <li><a href="{{ route('facility_1') }}" class="dropdown-item">Emergency Department</a></li>
                        <li><a href="{{ route('facility_2') }}" class="dropdown-item">Intensive Care Unit (ICU)</a>
                        </li>
                        <li><a href="{{ route('facility_3') }}" class="dropdown-item">Operation Theatre (OT)</a></li>
                        <li><a href="{{ route('facility_4') }}" class="dropdown-item">Post Operative Room</a></li>
                        <li><a href="{{ route('facility_5') }}" class="dropdown-item">Ward</a></li>
                        <li><a href="{{ route('facility_6') }}" class="dropdown-item">Cabin</a></li>
                        <li><a href="{{ route('facility_7') }}" class="dropdown-item">Laboratory</a></li>
                        <li><a href="{{ route('facility_8') }}" class="dropdown-item">Radiology & Imaging</a></li>
                        <li><a href="{{ route('facility_9') }}" class="dropdown-item">ECG</a></li>
                        <li><a href="{{ route('facility_10') }}" class="dropdown-item">Colonoscopy</a></li>
                        <li><a href="{{ route('facility_11') }}" class="dropdown-item">Pharmacy</a></li>
                        <li><a href="{{ route('facility_12') }}" class="dropdown-item">24-Hour Ambulance Service</a>
                        </li>

                    </ul>

                </li>

                {{-- Services --}}
                <li class="nav-item">

                    <a href="#services" class="nav-link custom-link">

                        Services

                    </a>

                </li>

                {{-- Specialists --}}
                <li class="nav-item dropdown">

                    <a href="#specialists" class="nav-link custom-link dropdown-toggle">

                        Our Specialists

                    </a>

                    <ul class="dropdown-menu">

                        <li><a href="{{ route('doc_1') }}" class="dropdown-item">Prof. Dr. AKM Fazlul Haque</a></li>
                        <li><a href="{{ route('doc_2') }}" class="dropdown-item">Dr. Asif Almas Haque</a></li>
                        <li><a href="{{ route('doc_3') }}" class="dropdown-item">Dr. Fatema Sharmin (Anny)</a></li>
                        <li><a href="{{ route('doc_4') }}" class="dropdown-item">Dr. Sakib Sarwat Haque</a></li>
                        <li><a href="{{ route('doc_5') }}" class="dropdown-item">Dr. Asma Husain Noora</a></li>

                    </ul>

                </li>

                {{-- Goals --}}
                <li class="nav-item">

                    <a href="#goals" class="nav-link custom-link">

                        Our Goals

                    </a>

                </li>

            </ul>

        </div>


        {{-- ==========================================
    LOGIN BUTTON
========================================== --}}
        <div class="order-3 ml-auto d-flex align-items-center">

            <a href="{{ route('login') }}" class="btn login-btn me-2">

                Hospital Login

            </a>

        </div>



    </div>
</nav>

<!------start of welcome link js--->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const welcomeUrl = "{{ route('welcome') }}";

        document.querySelectorAll('a.nav-link[href^="#"]').forEach(link => {
            link.addEventListener('click', function(e) {
                const targetId = this.getAttribute('href');

                // If NOT on welcome page
                if (window.location.pathname !== new URL(welcomeUrl).pathname) {
                    e.preventDefault();
                    window.location.href = welcomeUrl + targetId;
                }
            });
        });
    });
</script>
<!------end of welcome link js--->

<!------start of facility js--->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dropdown = document.getElementById('facility_dropdown');
        const toggleLink = dropdown.querySelector('.dropdown-toggle');
        const menu = dropdown.querySelector('.dropdown-menu');

        // Toggle on click
        toggleLink.addEventListener('click', function(e) {
            e.preventDefault();

            const isOpen = menu.classList.contains('show');
            document.querySelectorAll('.dropdown-menu.show').forEach(el => {
                el.classList.remove('show');
            });

            menu.classList.toggle('show', !isOpen);
            toggleLink.setAttribute('aria-expanded', !isOpen);
        });

        // Close when clicking outside
        document.addEventListener('click', function(e) {
            if (!dropdown.contains(e.target)) {
                menu.classList.remove('show');
                toggleLink.setAttribute('aria-expanded', 'false');
            }
        });
    });
</script>
<!------end of facility js--->
