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
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            // ✅ 1️⃣ Logout Confirmation
            const logoutButton = document.querySelector('a[href="#"][onclick*="logout-form"]');
            const logoutForm = document.getElementById('logout-form');

            if (logoutButton && logoutForm) {
                logoutButton.removeAttribute('onclick');
                logoutButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Are you sure you want to log out?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, log out',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Slight delay to ensure session flash persists properly
                            setTimeout(() => logoutForm.submit(), 200);
                        }
                    });
                });
            }

            // ✅ 2️⃣ Show alerts based on session (AFTER page reload)
            @if (session()->has('login_success'))
                setTimeout(() => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Welcome back!',
                        text: '{{ session('login_success') }}',
                        timer: 2500,
                        showConfirmButton: false
                    });
                }, 300);
            @endif

            @if (session()->has('logout_success'))
                setTimeout(() => {
                    Swal.fire({
                        icon: 'info',
                        title: 'Logged Out',
                        text: '{{ session('logout_success') }}',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                }, 300);
            @endif

            // ✅ 3️⃣ Invalid Login Alert (Optional)
            @if (session()->has('login_error'))
                setTimeout(() => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Login Failed',
                        text: '{{ session('login_error') }}',
                        confirmButtonColor: '#d33'
                    });
                }, 300);
            @endif
        });
    </script>

    {{-- start of manual search --}}
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const globalSearchUrl = "{{ route('global.search') }}";

            const navbarForms = document.querySelectorAll(".navbar-search-block form");

            navbarForms.forEach(form => {
                const input = form.querySelector('input[name="term"]');
                if (!input) return;

                // Create result box
                const resultBox = document.createElement("div");
                resultBox.style.position = "absolute";
                resultBox.style.top = "40px";
                resultBox.style.left = "0";
                resultBox.style.width = "100%";
                resultBox.style.maxHeight = "250px";
                resultBox.style.overflowY = "auto";
                resultBox.style.background = "#ffffff";
                resultBox.style.border = "1px solid #ddd";
                resultBox.style.borderRadius = "6px";
                resultBox.style.boxShadow = "0 4px 8px rgba(0,0,0,0.08)";
                resultBox.style.zIndex = "99999";
                resultBox.style.display = "none";
                resultBox.style.color = "#000";

                const parentGroup = input.closest(".input-group");
                parentGroup.style.position = "relative";
                parentGroup.appendChild(resultBox);

                let timer = null;

                // Prevent full-page reload
                form.addEventListener("submit", e => e.preventDefault());

                input.addEventListener("input", function() {
                    const query = this.value.trim();
                    clearTimeout(timer);

                    if (query.length < 2) {
                        resultBox.style.display = "none";
                        return;
                    }

                    timer = setTimeout(() => {
                        fetch(`${globalSearchUrl}?term=${encodeURIComponent(query)}`)
                            .then(res => res.json())
                            .then(data => {
                                if (!Array.isArray(data) || data.length === 0) {
                                    resultBox.innerHTML = `
                                    <div class="p-2 text-muted" style="color:#555;">No results found</div>`;
                                } else {
                                    resultBox.innerHTML = data.map(item => `
                                    <div class="search-item"
                                        style="
                                            padding:8px 12px;
                                            cursor:pointer;
                                            display:flex;
                                            justify-content:space-between;
                                            align-items:center;
                                            border-bottom:1px solid #f1f1f1;
                                            color:#000;
                                        "
                                        onmouseover="this.style.background='#f7f7f7'"
                                        onmouseout="this.style.background='#fff'"
                                        onclick="window.location='${item.url}'">
                                        
                                        <span style="font-size:14px; font-weight:500;">
                                            ${item.label}
                                        </span>

                                        <span style="
                                            font-size:11px;
                                            background:#e6f0ff;
                                            color:#000;
                                            padding:2px 6px;
                                            border-radius:4px;
                                        ">
                                            ${item.type ? item.type.toUpperCase() : ''}
                                        </span>
                                    </div>
                                `).join("");
                                }
                                resultBox.style.display = "block";
                            })
                            .catch(() => {
                                resultBox.innerHTML = `
                                <div class="p-2 text-danger">Error loading results</div>`;
                                resultBox.style.display = "block";
                            });
                    }, 300);
                });

                // Close when clicking outside
                document.addEventListener("click", function(e) {
                    if (!resultBox.contains(e.target) && e.target !== input) {
                        resultBox.style.display = "none";
                    }
                });
            });
        });
    </script>
    {{-- end of manual search --}}
    <!-- start of action reminder notification -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let pendingAction = null;

            // ✅ CREATE CONFIRMATION HANDLER
            document.querySelectorAll('form[data-confirm="create"]').forEach(form => {
                form.addEventListener('submit', function(e) {
                    if (!form.dataset.confirmed) {
                        e.preventDefault();
                        pendingAction = form;
                        $('#createConfirmModal').modal('show');
                    }
                });
            });

            // ✅ EDIT CONFIRMATION HANDLER
            document.querySelectorAll('form[data-confirm="edit"]').forEach(form => {
                form.addEventListener('submit', function(e) {
                    if (!form.dataset.confirmed) {
                        e.preventDefault();
                        pendingAction = form;
                        $('#editConfirmModal').modal('show');
                    }
                });
            });

            // ✅ DELETE CONFIRMATION HANDLER
            window.triggerDeleteModal = function(url) {
                const form = document.getElementById('deleteForm');
                form.action = url;
                $('#deleteConfirmModal').modal('show');
            };

            // ✅ ON MODAL CONFIRM CLICKS
            document.querySelectorAll('#createConfirmModal .btn-success, #editConfirmModal .btn-info').forEach(
                button => {
                    button.addEventListener('click', function() {
                        if (pendingAction) {
                            pendingAction.dataset.confirmed = true;
                            pendingAction.submit();
                            pendingAction = null;
                        }
                    });
                });
        });
    </script>
    <!-- end of action reminder notification -->

    <!-- start of delete confirmation script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userRole = "{{ Auth::user()->getRoleNames()->first() }}";

            // Hide all delete buttons for unauthorized roles
            if (userRole !== 'admin' && userRole !== 'manager') {
                document.querySelectorAll('button.btn-danger.btn-sm').forEach(button => {
                    // Optional: Hide the whole form instead of just the button
                    const form = button.closest('form');
                    if (form) {
                        form.remove();
                    } else {
                        button.remove();
                    }
                });
                return; // Stop execution for unauthorized users
            }

            // Only admin & it_support can delete
            window.triggerDeleteModal = function(actionUrl) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This record will be permanently deleted!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = actionUrl;

                        const csrfToken = document.querySelector('meta[name="csrf-token"]')
                            .getAttribute('content');
                        const csrfField = document.createElement('input');
                        csrfField.type = 'hidden';
                        csrfField.name = '_token';
                        csrfField.value = csrfToken;

                        const methodField = document.createElement('input');
                        methodField.type = 'hidden';
                        methodField.name = '_method';
                        methodField.value = 'DELETE';

                        form.appendChild(csrfField);
                        form.appendChild(methodField);
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            };
        });
    </script>
    <!-- end of delete confirmation script -->

    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: "{{ session('success') }}",
                timer: 2000,
                showConfirmButton: false
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "{{ session('error') }}",
                timer: 2500,
                showConfirmButton: false
            });
        @endif

        @if (session('warning'))
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: "{{ session('warning') }}",
                timer: 2500,
                showConfirmButton: false
            });
        @endif

        @if (session('info'))
            Swal.fire({
                icon: 'info',
                title: 'Info',
                text: "{{ session('info') }}",
                timer: 2500,
                showConfirmButton: false
            });
        @endif
    </script>
    <!-- end of notification toaster notification -->
    <!-- start of data table format table -->
    <script>
        $(document).ready(function() {
            $('#dataTables').DataTable();
        });
    </script>
    <!-- end of data table format table -->

    <!-- start of jquery and bootstrap table -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- end of jquery and bootstrap table -->

    {{-- start of validation --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let isDirty = false;
            let lastBackHref = null;

            // Track changes on all forms
            document.querySelectorAll("form").forEach(form => {
                form.querySelectorAll("input, textarea, select").forEach(input => {
                    input.addEventListener("change", () => {
                        isDirty = true;
                    });
                });

                // Reset dirty flag on submit
                form.addEventListener("submit", () => {
                    isDirty = false;
                });
            });

            // Handle all back buttons
            document.querySelectorAll(".back-btn").forEach(btn => {
                btn.addEventListener("click", function(e) {
                    const href = btn.getAttribute("href");
                    if (isDirty) {
                        e.preventDefault();
                        lastBackHref = href; // save the target URL
                        $('#backConfirmModal').modal('show');
                    } else {
                        window.location.href = href;
                    }
                });
            });

            // Leave page from modal
            const leaveBtn = document.querySelector("#backConfirmModal .leave-page");
            leaveBtn.addEventListener("click", function() {
                if (lastBackHref) {
                    isDirty = false;
                    window.location.href = lastBackHref; // go to correct index page dynamically
                }
            });

            // Warn user if leaving by browser navigation
            window.addEventListener("beforeunload", function(e) {
                if (isDirty) {
                    e.preventDefault();
                    e.returnValue = '';
                }
            });
        });
    </script>
    {{-- end of validation --}}

    {{-- Start of password eye --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".toggle-password").forEach(button => {
                button.addEventListener("click", function() {
                    const targetId = this.getAttribute("data-target");
                    const input = document.getElementById(targetId);
                    const icon = this.querySelector("i");

                    if (input.type === "password") {
                        input.type = "text";
                        icon.classList.remove("fa-eye");
                        icon.classList.add("fa-eye-slash");
                    } else {
                        input.type = "password";
                        icon.classList.remove("fa-eye-slash");
                        icon.classList.add("fa-eye");
                    }
                });
            });
        });
    </script>
    {{-- End of password eye --}}

    {{-- start of date --}}
    <script>
        function formatDate(dateString) {
            const date = new Date(dateString);
            const options = {
                day: '2-digit',
                month: 'long',
                year: 'numeric'
            };
            return date.toLocaleDateString('en-GB', options);
        }

        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.format-date').forEach(function(el) {
                const original = el.textContent.trim();
                el.textContent = formatDate(original);
            });
        });
    </script>
    {{-- end of date --}}

    {{-- start of warning limit --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const totalRecords = {{ $totalRecords ?? 0 }};
            const limit = 500;

            if (totalRecords >= limit) {
                setTimeout(() => {
                    const modal = new bootstrap.Modal(
                        document.getElementById('limitWarningModal')
                    );
                    modal.show();
                }, 600); // small delay for smooth UX
            }
        });
    </script>
    {{-- end of warning limit --}}

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
