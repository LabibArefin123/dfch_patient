<!-- Footer -->
<footer class="footer bg-info text-white pt-5">
    <div class="container">
        <div class="row align-items-start g-4">
            <!-- Left: Logo / Image -->
            <div class="col-md-3 text-center text-md-start">
                <!-- Placeholder for logo -->
                <a href="https://fazlulhaquehospital.com/" target="_blank" class="navbar-brand d-flex align-items-center">
                    <img src="{{ asset('uploads/images/logo.png') }}" alt="DFCH Logo" class="img-fluid mb-3"
                        style="width:250px; height:50px;">
                </a>
                <p class="small">
                    Compassionate colorectal care with expertise, advanced treatments, and patient-centered services.
                </p>
            </div>

            <!-- Middle: Contact Info -->
            <div class="col-md-3">
                <h6 class="text-warning fw-bold mb-3">Contact Us</h6>
                <p class="mb-1">
                    <i class="fas fa-map-marker-alt me-2"></i>
                    86 (New), 726/A (Old), Satmasjid Road, Dhanmondi, Dhaka-1209
                </p>
                <p class="mb-1">
                    <i class="fas fa-envelope me-2"></i>
                    <a href="mailto:info@fazlulhaquehospital.com" class="text-white text-decoration-none">
                        info@fazlulhaquehospital.com
                    </a>
                </p>
                <p class="mb-1">
                    <i class="fas fa-phone me-2"></i>01755697173 / 01755697176
                </p>
                <p class="mb-1">
                    <i class="fas fa-phone me-2"></i>0241023155
                </p>
                <p class="mb-0">
                    <i class="fas fa-phone me-2"></i>09646710720
                </p>
            </div>

            <!-- Right: Quick Links -->
            <div class="col-md-6">
                <div class="row">
                    <div class="col-6">
                        <h6 class="text-warning fw-bold mb-3">About Clinic</h6>
                        <ul class="list-unstyled small mb-0">
                            <li><a href="#" class="text-white text-decoration-none">About Clinic</a></li>
                            <li><a href="#" class="text-white text-decoration-none">Careers</a></li>
                            <li><a href="#" class="text-white text-decoration-none">Press & Media</a></li>
                            <li><a href="#" class="text-white text-decoration-none">Our Blog</a></li>
                            <li><a href="#" class="text-white text-decoration-none">Advertising</a></li>
                        </ul>
                    </div>
                    <div class="col-6">
                        <h6 class="text-warning fw-bold mb-3">Discover</h6>
                        <ul class="list-unstyled small mb-0">
                            <li><a href="#" class="text-white text-decoration-none">Help Center</a></li>
                            <li><a href="#" class="text-white text-decoration-none">Live Chatting</a></li>
                            <li><a href="#" class="text-white text-decoration-none">Terms & Privacy</a></li>
                            <li><a href="#" class="text-white text-decoration-none">FAQs</a></li>
                            <li><a href="#" class="text-white text-decoration-none">Site Map</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom copyright -->
        <div class="text-center small mt-4 pt-3 border-top border-white">
            &copy;
            <a href="https://fazlulhaquehospital.com/" target="_blank" class="dev-link fw-bold text-decoration-none">
                <strong> {{ $orgLogo }}.</strong>
            </a> All rights reserved |
            Design & Developed by
            <a href="https://www.labib.work" target="_blank" class="dev-link fw-bold text-decoration-none">
                Labib Arefin
            </a>
        </div>
    </div>

    <!-- Icons & custom styles -->
    <style>
        .onstage-text {
            font-family: 'OnStage', sans-serif;
            color: #ff6b6b;
        }

        footer a:hover {
            color: #fff !important;
            text-decoration: underline;
        }

        footer h6 {
            font-size: 16px;
        }

        footer p,
        footer li {
            font-size: 14px;
        }

        /* Icon spacing */
        .fas {
            width: 18px;
            text-align: center;
        }
    </style>

    <!-- FontAwesome for icons (required) -->
    {{-- <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> --}}
</footer>
