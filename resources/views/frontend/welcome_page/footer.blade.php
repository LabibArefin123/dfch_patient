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

                <div class="d-flex align-items-start mb-2">
                    <i class="fas fa-map-marker-alt me-2 mt-1"></i>

                    <a class="custom-map-link text-white text-decoration-none d-block" id="openMapModal">
                        86 (New), 726/A (Old), Satmasjid Road, Dhanmondi, Dhaka-1209
                    </a>
                </div>

                <p class="mb-1">
                    <i class="fas fa-envelope me-2"></i>
                    <a href="mailto:info@fazlulhaquehospital.com" class="text-white text-decoration-none dev-link">
                        info@fazlulhaquehospital.com
                    </a>
                </p>

                <p class="mb-1">
                    <i class="fas fa-phone me-2"></i>
                    <a href="https://wa.me/8801755697176" target="_blank"
                        class="dev-link text-white text-decoration-none">
                        01755697176
                    </a> /
                    <a href="https://wa.me/01755697173" target="_blank"
                        class="dev-link text-white text-decoration-none">
                        01755697173
                    </a>
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
                            {{-- <h6 class="text-warning fw-bold mb-3">Support</h6>
                            <li>
                                <a href="javascript:void(0);" onclick="openProblemModal()"
                                    class="text-white text-decoration-none">
                                    Facing a System Issue? Report Here</a>
                            </li> --}}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        {{-- SYSTEM PROBLEM MODAL --}}
        <div id="problemModal" class="problem-modal" style="display:none;">
            <div class="problem-modal-content">
                <div class="modal-header">
                    <h5 class="fw-bold mb-0">Report a System Problem</h5>
                    <button type="button" class="close-btn" onclick="closeProblemModal()">×</button>
                </div>

                <form method="POST" action="{{ route('system_problem.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Problem ID</label>
                        <input type="text" class="form-control" value="Auto Generated" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Problem Title</label>
                        <input type="text" name="problem_title" class="form-control"
                            placeholder="Example: Login not working">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Describe the Problem</label>
                        <textarea name="problem_description" class="form-control" rows="4" placeholder="Please explain what happened..."></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Priority Level</label>
                        <select name="status" class="form-control">
                            <option value="low">Low</option>
                            <option value="medium">Medium</option>
                            <option value="high">High</option>
                            <option value="critical">Critical</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Attachment (Optional)</label>
                        <input type="file" name="problem_file" class="form-control"
                            accept="image/*,.pdf,.doc,.docx">
                    </div>

                    <button type="submit" class="btn btn-primary w-100 rounded-pill"
                        onclick="this.disabled=true; this.innerText='Submitting...'; this.form.submit();">
                        Submit Problem
                    </button>
                </form>
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
