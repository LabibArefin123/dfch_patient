@extends('adminlte::master')

@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\PreloaderHelper')

<link rel="icon" type="image/png" href="{{ asset('uploads/images/icon.png') }}">
<link rel="stylesheet" href="{{ asset('css/custom_backend.css') }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet"> --}}

@section('classes_body', $layoutHelper->makeBodyClasses())
@section('body_data', $layoutHelper->makeBodyData())

@section('body')
    <div class="wrapper">
        <!-- start of modal animation -->
        <div class="modal fade" id="backConfirmModal" tabindex="-1" role="dialog" aria-labelledby="backConfirmLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content text-center p-4">
                    <!-- Animated Circle Icon -->
                    <div class="mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="animate-bounce" width="50" height="50"
                            fill="#FFC107" viewBox="0 0 16 16">
                            <path
                                d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0-12a.905.905 0 0 1 .9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 3.995A.905.905 0 0 1 8 3zm.002 6a1 1 0 1 1-2.002 0 1 1 0 0 1 2.002 0z" />
                        </svg>
                    </div>

                    <!-- Modal Message -->
                    <div class="modal-body mb-3">
                        Please fill up the required fields before leaving the page. Do you want to leave?
                    </div>

                    <!-- Footer Buttons -->
                    <div class="modal-footer d-flex justify-content-center gap-2">
                        <button type="button" class="btn btn-success" data-dismiss="modal">Stay</button>
                        <a href="#" class="btn btn-danger leave-page">Leave</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of modal animation -->

        <!-- start of create animation model -->
        <div class="modal fade" id="createConfirmModal" tabindex="-1" role="dialog" aria-labelledby="createConfirmLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content text-center p-4">

                    <!-- Animated Check Icon -->
                    <div class="mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="#28A745"
                            viewBox="0 0 16 16">
                            <path
                                d="M16 2a2 2 0 0 1-2 2h-1v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4H2a2 2 0 0 1 0-4h12a2 2 0 0 1 2 2zM5 4v10h6V4H5zm3 7.5a.5.5 0 0 1-.374-.832l1.5-1.5a.5.5 0 1 1 .707.707L8.707 10.5l1.126 1.126a.5.5 0 1 1-.707.707l-1.5-1.5A.5.5 0 0 1 8 11.5z" />
                        </svg>
                    </div>

                    <!-- Message -->
                    <div class="modal-body mb-3">
                        Are you sure you want to <strong>create</strong> this record?
                    </div>

                    <!-- Footer Buttons -->
                    <div class="modal-footer d-flex justify-content-center gap-2">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Confirm</button>
                    </div>

                </div>
            </div>
        </div>
        <!-- end of create animation model -->

        <!-- start of edit animation model -->
        <div class="modal fade" id="editConfirmModal" tabindex="-1" role="dialog" aria-labelledby="editConfirmLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content text-center p-4">

                    <!-- Animated Pencil Icon -->
                    <div class="mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="#17A2B8"
                            viewBox="0 0 16 16">
                            <path
                                d="M12.146.854a.5.5 0 0 1 .708 0l2.292 2.292a.5.5 0 0 1 0 .708l-9.193 9.193a.5.5 0 0 1-.168.11l-4 1.5a.5.5 0 0 1-.65-.65l1.5-4a.5.5 0 0 1 .11-.168l9.193-9.193zM11.207 2L3.5 9.707l-.793 2.121 2.121-.793L13.293 3 11.207 2z" />
                        </svg>
                    </div>

                    <!-- Message -->
                    <div class="modal-body mb-3">
                        Are you sure you want to <strong>update</strong> this record?
                    </div>

                    <!-- Footer Buttons -->
                    <div class="modal-footer d-flex justify-content-center gap-2">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-info">Confirm</button>
                    </div>

                </div>
            </div>
        </div>
        <!-- end of edit animation model -->

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

        <!-- start of delete animation model -->
        <div class="modal fade" id="deleteConfirmModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content text-center p-4">

                    <!-- Animated Warning Icon -->
                    <div class="mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="animate-bounce" width="50" height="50"
                            fill="#DC3545" viewBox="0 0 16 16">
                            <path
                                d="M8.982 1.566a1 1 0 0 0-1.964 0L.165 13.233A1 1 0 0 0 1 14.5h14a1 1 0 0 0 .835-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1-2.002 0 1 1 0 0 1 2.002 0z" />
                        </svg>
                    </div>

                    <!-- Message -->
                    <div class="modal-body mb-3">
                        Are you sure you want to <strong>delete</strong> this record? <br>
                        This action cannot be undone.
                    </div>

                    <!-- Footer Buttons -->
                    <div class="modal-footer d-flex justify-content-center gap-2">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <form id="deleteForm" method="POST" action="#">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of delete animation model -->

        <!-- Start Limit Warning Modal -->
        {{-- <div class="modal fade" id="limitWarningModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content text-center p-4">

                    <div class="mb-3">
                        <div class="limit-icon">!</div>
                    </div>

                    <h4 class="text-danger fw-bold">
                        Maximum Limit Reached
                    </h4>

                    <p class="text-muted mb-3">
                        This report is limited to <strong>300 records</strong>.<br>
                        Please contact the developer for larger data export.
                    </p>

                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                        Close
                    </button>
                </div>
            </div>
        </div> --}}
        <!-- End of Limit Warning Modal -->

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
    <!-- start of time top right  -->
    <script>
        function updateNavbarTime() {
            const now = new Date();

            const dayName = now.toLocaleString('default', {
                weekday: 'long'
            }); // Sunday, Monday
            const day = now.getDate();
            const month = now.toLocaleString('default', {
                month: 'long'
            }); // August
            const year = now.getFullYear();

            let hours = now.getHours();
            const minutes = now.getMinutes().toString().padStart(2, '0');
            const seconds = now.getSeconds().toString().padStart(2, '0');
            const ampm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12;
            hours = hours ? hours : 12;

            document.getElementById('navbar-time').innerText =
                `${dayName}, ${day} ${month} ${year} | ${hours}:${minutes}:${seconds} ${ampm}`;
        }

        updateNavbarTime();
        setInterval(updateNavbarTime, 1000);
    </script>
    <!-- end of time top right  -->

    <!-- Start of Login / Logout -->
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

    {{-- <script>
        document.addEventListener('DOMContentLoaded', () => {
            const globalSearchUrl = "{{ route('global.search') }}";

            const navbarForms = document.querySelectorAll('.navbar-search-block form');

            navbarForms.forEach(form => {
                const input = form.querySelector('input[name="term"]');
                if (!input) return;

                const resultBox = document.createElement('ul');
                resultBox.className = 'list-group global-search-results';
                form.appendChild(resultBox);

                // Prevent full-page reload
                form.addEventListener('submit', e => e.preventDefault());

                let timeout;

                input.addEventListener('input', function() {
                    clearTimeout(timeout);
                    const query = this.value.trim();

                    if (query.length < 2) {
                        resultBox.innerHTML = '';
                        return;
                    }

                    timeout = setTimeout(() => {
                        fetch(`${globalSearchUrl}?term=${encodeURIComponent(query)}`)
                            .then(res => res.json())
                            .then(data => {
                                resultBox.innerHTML = '';

                                if (!data.length) {
                                    resultBox.innerHTML =
                                        `<li class="list-group-item text-muted">No results found</li>`;
                                    return;
                                }

                                data.forEach(item => {
                                    const li = document.createElement('li');
                                    li.className =
                                        'list-group-item list-group-item-action';
                                    li.innerHTML = item
                                        .label; // <-- Use innerHTML here
                                    li.onclick = () => window.location.href =
                                        item.url;
                                    resultBox.appendChild(li);
                                });
                            })
                            .catch(() => {
                                resultBox.innerHTML =
                                    `<li class="list-group-item text-danger">Error loading results</li>`;
                            });
                    }, 300);
                });

                // Hide on outside click
                document.addEventListener('click', function(e) {
                    if (!form.contains(e.target)) {
                        resultBox.innerHTML = '';
                    }
                });
            });
        });
    </script> --}}

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
            const limit = 300;
            
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

@section('plugins.Datatables', true)
@stop
