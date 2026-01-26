<!-- Top Info Bar -->
<div class="py-1" style="background-color: #003366; color: #fff; font-size: 14px;">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <!-- Left: Email + Phone -->
        <div class="d-flex align-items-center">
            <i class="fas fa-envelope mr-2"></i> mdlabibarefin@gmail.com
            <span class="mx-3">|</span>
            <i class="fas fa-phone mr-2"></i> +8801776197999
        </div>
        <!-- Right: Date & Time -->
        <div id="currentDateTime">
            {{ now()->format('d M Y, h:i A') }}
        </div>
    </div>
</div>

<!-- Main Navbar -->
<nav class="main-header navbar navbar-expand-md navbar-light navbar-white"
    style="padding-left: 30px; padding-right: 30px;">
    <div class="container-fluid">

        <!-- Left: Logo -->
        <a href="#" class="navbar-brand d-flex align-items-center">
            <img src="{{ asset('uploads/images/logo.png') }}" alt="Logo" class="brand-image img-circle elevation-3"
                style="width:350px; height:75px;">
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

                <li class="nav-item"><a href="#about" class="nav-link custom-link">About</a></li>
                <li class="nav-item"><a href="#features" class="nav-link custom-link">Features</a></li>
                <li class="nav-item"><a href="#services" class="nav-link custom-link">Services</a></li>
            </ul>
        </div>

        <!-- Right: Login Button -->
        <div class="order-3 ml-auto d-flex align-items-center">
            <a href="{{ route('login') }}" class="btn btn-outline-primary" style="margin-right: 10px;">Login</a>
        </div>

    </div>
</nav>
