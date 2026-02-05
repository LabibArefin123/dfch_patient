<link rel="stylesheet" href="{{ asset('css/frontend/custom_navbar.css') }}">
<nav class="main-header navbar navbar-expand-md navbar-light navbar-white"
    style="padding-left: 30px; padding-right: 30px;">
    <div class="container-fluid">
        <!-- Left: Logo -->
        <a href="{{ route('welcome') }}" class="navbar-brand d-flex align-items-center">
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
                    style="width:350px; height:75px; object-fit: contain;">
            @else
                {{-- Fallback --}}
                <img src="{{ asset('uploads/images/logo.png') }}" alt="Default Logo" class="brand-image elevation-3"
                    style="width:350px; height:75px; object-fit: contain;">
            @endif
        </a>


        <!-- Toggle button for mobile -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
            aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Center Menu -->
        <div class="collapse navbar-collapse justify-content-center order-2" id="navbarCollapse">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="{{ route('welcome') }}"
                        class="nav-link custom-link {{ request()->routeIs('welcome') ? 'active' : '' }}">
                        Overview
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#about" class="nav-link custom-link">About</a>
                </li>

                <li class="nav-item">
                    <a href="#departments" class="nav-link custom-link">Departments</a>
                </li>

                <li class="nav-item dropdown">
                    <a href="#facilities" class="nav-link custom-link dropdown-toggle">
                        Facilities
                    </a>

                    <ul class="dropdown-menu">
                        <li><a href="{{ route('facility_1') }}" class="dropdown-item">Emergency Department</a></li>
                        <li><a href="#icu" class="dropdown-item">Intensive Care Unit (ICU)</a></li>
                        <li><a href="#ot" class="dropdown-item">Operation Theatre (OT)</a></li>
                        <li><a href="#post-op" class="dropdown-item">Post Operative Room</a></li>
                        <li><a href="#ward" class="dropdown-item">Ward</a></li>
                        <li><a href="#cabin" class="dropdown-item">Cabin</a></li>
                        <li><a href="#lab" class="dropdown-item">Laboratory</a></li>
                        <li><a href="#radiology" class="dropdown-item">Radiology & Imaging</a></li>
                        <li><a href="#ecg" class="dropdown-item">ECG</a></li>
                        <li><a href="#colonoscopy" class="dropdown-item">Colonoscopy</a></li>
                        <li><a href="#pharmacy" class="dropdown-item">Pharmacy</a></li>
                        <li><a href="#ambulance" class="dropdown-item">24-Hour Ambulance Service</a></li>
                    </ul>
                </li>


                <li class="nav-item">
                    <a href="#services" class="nav-link custom-link">Services</a>
                </li>

                <li class="nav-item dropdown">
                    <a href="#specialists" class="nav-link custom-link dropdown-toggle">Our Specialists</a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('doc_1') }}" class="dropdown-item">Prof. Dr. AKM Fazlul Haque</a></li>
                        <li><a href="{{ route('doc_2') }}" class="dropdown-item">Dr. Asif Almas Haque</a></li>
                        <li><a href="{{ route('doc_3') }}" class="dropdown-item">Dr. Fatema Sharmin (Anny)</a></li>
                        <li><a href="{{ route('doc_4') }}" class="dropdown-item">Dr. Sakib Sarwat Haque</a></li>
                        <li><a href="{{ route('doc_5') }}" class="dropdown-item">Dr. Asma Husain Noora</a></li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#goals" class="nav-link custom-link">Our Goals</a>
                </li>
            </ul>
        </div>

        <!-- Right: Login Button -->
        <div class="order-3 ml-auto d-flex align-items-center">
            <a href="{{ route('login') }}" class="btn login-btn" style="margin-right: 10px;">Login</a>
        </div>

    </div>
</nav>
<link rel="stylesheet" href="{{ asset('css/frontend/custom_header.css') }}">
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
