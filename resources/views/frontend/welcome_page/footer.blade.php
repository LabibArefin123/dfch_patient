<!-- Footer -->
<footer class="footer bg-info text-white pt-2">
    <link rel="stylesheet" href="{{ asset('css/frontend/custom_footer.css') }}">
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

                <p class="small mb-2">
                    <i class="fas fa-map-marker-alt me-2 mt-1"></i>

                    <span class="footer-action text-white custom-footer-link" data-action="location">
                        86 (New), 726/A (Old), Satmasjid Road,
                  
                    </span>
                    <span class="footer-action text-white custom-footer-link" data-action="location">
                   
                        Dhanmondi, Dhaka-1209
                    </span>
                </p>

                <p class="mb-1">
                    <i class="fas fa-envelope me-2"></i>
                    <a href="mailto:info@fazlulhaquehospital.com" class="text-white text-decoration-none custom-footer-link">
                        info@fazlulhaquehospital.com
                    </a>
                </p>

                <p class="small mb-2">
                    <i class="fas fa-phone me-2"></i>
                    <span class="footer-action text-white custom-footer-link" data-action="phone">
                        01755-697173 / 01755-697176
                    </span>
                </p>


                <p class="mb-1">
                    <i class="fas fa-fax me-2"></i>
                    0241023155 / 09646710720
                </p>
            </div>

            <!-- Right: Quick Links -->
            <div class="col-md-6">
                <div class="row">
                    <div class="col-6">
                        <h6 class="text-warning fw-bold mb-3">About Hospital</h6>
                        <ul class="list-unstyled small mb-0">
                            <li><a href="#" class="text-white text-decoration-none">About Hospital</a></li>
                            <li><a href="#" class="text-white text-decoration-none">Career</a></li>
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
            <a href="https://fazlulhaquehospital.com/" target="_blank" class="custom-footer-link fw-bold text-decoration-none">
                <strong> {{ $orgLogo }}.</strong>
            </a> All rights reserved |
            Design & Developed by
            <a href="https://www.labib.work" target="_blank" class="custom-footer-link fw-bold text-decoration-none">
                Labib Arefin
            </a>
        </div>
    </div>
    <script>
        function openProblemModal() {
            const modal = document.getElementById('problemModal');
            modal.style.display = 'flex';
        }

        function closeProblemModal() {
            const modal = document.getElementById('problemModal');
            modal.style.display = 'none';
        }

        // Optional: click outside modal to close
        window.addEventListener('click', function(event) {
            const modal = document.getElementById('problemModal');
            if (event.target === modal) {
                closeProblemModal();
            }
        });
    </script>

</footer>
