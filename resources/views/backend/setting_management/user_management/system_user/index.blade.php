@extends('adminlte::page')

@section('title', 'System Users')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <h1 class="mb-0">System Users</h1>
        <a href="{{ route('system_users.create') }}" class="btn btn-success btn-sm">
            Add
        </a>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Role</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone 1</th>
                                <th>Phone 2</th>
                                <th>Username</th>
                                <th>Password</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->roles->pluck('name')->join(', ') }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone ?? 'Not Provided' }}</td>
                                    <td>{{ $user->phone_2 ?? 'Not Provided' }}</td>
                                    <td>{{ $user->username ?? 'Not Provided' }}</td>
                                    <td>{{ $user->decrypted_password ?? 'Not Provided' }}</td>
                                    <td>
                                        <span class="badge {{ $user->is_online ? 'bg-success' : 'bg-danger' }}">
                                            <i class="fas fa-circle me-1" style="font-size:8px;"></i>
                                            {{ $user->is_online ? 'Online' : 'Offline' }}
                                        </span>

                                        <div class="small text-muted">
                                            {{ $user->last_seen ? $user->last_seen->diffForHumans() : 'Never active' }}
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ route('system_users.show', $user->id) }}"
                                            class="btn btn-info btn-sm me-1">View</a>

                                        <a href="{{ route('system_users.edit', $user->id) }}"
                                            class="btn btn-warning btn-sm me-1">Edit</a>

                                        @if (auth()->user()->hasRole('admin'))
                                            <button class="btn btn-danger btn-sm change-password-btn"
                                                data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}">
                                                Change Password
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- Change Password Modal -->
                    <div class="modal fade" id="changePasswordModal" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered modal-lg"> {{-- wider --}}
                            <div class="modal-content shadow-lg rounded-4">

                                {{-- HEADER --}}
                                <div class="modal-header bg-dark text-white">
                                    <h5 class="modal-title">
                                        🔐 Change Password – <span id="modalUserName"></span>
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <form method="POST" id="changePasswordForm">
                                    @csrf

                                    <div class="modal-body">
                                        <div class="row">

                                            {{-- LEFT : FORM --}}
                                            <div class="col-md-7">

                                                {{-- PASSWORD --}}
                                                <div class="form-group">
                                                    <label class="fw-bold">New Password</label>
                                                    <div class="input-group">
                                                        <input type="password" name="password" id="password"
                                                            class="form-control" required>

                                                        <div class="input-group-append">
                                                            <span class="input-group-text toggle-password"
                                                                data-target="password">
                                                                <i class="fas fa-eye"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- CONFIRM --}}
                                                <div class="form-group">
                                                    <label class="fw-bold">Confirm Password</label>
                                                    <div class="input-group">
                                                        <input type="password" name="password_confirmation"
                                                            id="password_confirmation" class="form-control" required>

                                                        <div class="input-group-append">
                                                            <span class="input-group-text toggle-password"
                                                                data-target="password_confirmation">
                                                                <i class="fas fa-eye"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            {{-- RIGHT : PASSWORD PREVIEW --}}
                                            {{-- RIGHT : PASSWORD PREVIEW --}}
                                            <div class="col-md-5 border-left">
                                                <h6 class="fw-bold mb-3">🔎 Password Strength</h6>

                                                <div id="strengthText" class="mb-2 text-muted">
                                                    Enter password to see strength
                                                </div>

                                                <div class="progress mb-3" style="height:8px;">
                                                    <div id="strengthBar" class="progress-bar" role="progressbar"
                                                        style="width:0%"></div>
                                                </div>

                                                <ul class="small pl-3">
                                                    <li id="rule-length">❌ At least 8 characters</li>
                                                    <li id="rule-upper">❌ Uppercase letter</li>
                                                    <li id="rule-lower">❌ Lowercase letter</li>
                                                    <li id="rule-number">❌ Number</li>
                                                    <li id="rule-special">❌ Special character</li>
                                                </ul>

                                                {{-- New Password Confirmation Message --}}
                                                <div id="passwordMatchMessage" class="mt-3 text-success fw-bold"
                                                    style="display:none;">
                                                    ✅ Your new password is: <span id="newPasswordPreview"></span>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    {{-- FOOTER --}}
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-danger">
                                            Update Password
                                        </button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@stop
@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            /* ============================
               OPEN MODAL
            ============================ */
            document.querySelectorAll('.change-password-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const userId = this.dataset.userId;
                    const userName = this.dataset.userName;

                    document.getElementById('modalUserName').innerText = userName;

                    const form = document.getElementById('changePasswordForm');
                    form.action = `/system-users/${userId}/change-password`;
                    form.reset();

                    // reset strength UI
                    updateStrength('');
                    hidePasswordMatchMessage();

                    $('#changePasswordModal').modal('show');
                });
            });

            /* ============================
               EYE TOGGLE
            ============================ */
            document.querySelectorAll('.toggle-password').forEach(toggle => {
                toggle.addEventListener('click', function() {
                    const input = document.getElementById(this.dataset.target);
                    const icon = this.querySelector('i');

                    if (!input) return;

                    if (input.type === 'password') {
                        input.type = 'text';
                        icon.classList.replace('fa-eye', 'fa-eye-slash');
                    } else {
                        input.type = 'password';
                        icon.classList.replace('fa-eye-slash', 'fa-eye');
                    }
                });
            });

            /* ============================
               PASSWORD STRENGTH & MATCH
            ============================ */
            const passwordInput = document.getElementById('password');
            const confirmInput = document.getElementById('password_confirmation');

            passwordInput.addEventListener('keyup', handlePasswordInput);
            confirmInput.addEventListener('keyup', handlePasswordInput);

            function handlePasswordInput() {
                const pwd = passwordInput.value;
                const confirmPwd = confirmInput.value;

                updateStrength(pwd);
                checkPasswordMatch(pwd, confirmPwd);
            }

            function updateStrength(password) {
                let score = 0;
                const rules = {
                    length: password.length >= 8,
                    upper: /[A-Z]/.test(password),
                    lower: /[a-z]/.test(password),
                    number: /[0-9]/.test(password),
                    special: /[^A-Za-z0-9]/.test(password),
                };

                Object.values(rules).forEach(val => val && score++);

                // Update rules UI
                document.getElementById('rule-length').innerText = rules.length ? '✅ At least 8 characters' :
                    '❌ At least 8 characters';
                document.getElementById('rule-upper').innerText = rules.upper ? '✅ Uppercase letter' :
                    '❌ Uppercase letter';
                document.getElementById('rule-lower').innerText = rules.lower ? '✅ Lowercase letter' :
                    '❌ Lowercase letter';
                document.getElementById('rule-number').innerText = rules.number ? '✅ Number' : '❌ Number';
                document.getElementById('rule-special').innerText = rules.special ? '✅ Special character' :
                    '❌ Special character';

                // Update bar & text
                const bar = document.getElementById('strengthBar');
                const text = document.getElementById('strengthText');
                let percent = (score / 5) * 100;
                bar.style.width = percent + '%';

                if (score <= 2) {
                    bar.className = 'progress-bar bg-danger';
                    text.innerText = 'Weak Password';
                } else if (score <= 4) {
                    bar.className = 'progress-bar bg-warning';
                    text.innerText = 'Medium Strength';
                } else {
                    bar.className = 'progress-bar bg-success';
                    text.innerText = 'Strong Password';
                }
            }

            function checkPasswordMatch(password, confirmPassword) {
                const messageDiv = document.getElementById('passwordMatchMessage');
                const previewSpan = document.getElementById('newPasswordPreview');

                if (password && confirmPassword && password === confirmPassword) {
                    messageDiv.style.display = 'block';
                    previewSpan.innerText = password;
                } else {
                    hidePasswordMatchMessage();
                }
            }

            function hidePasswordMatchMessage() {
                document.getElementById('passwordMatchMessage').style.display = 'none';
                document.getElementById('newPasswordPreview').innerText = '';
            }

        });
    </script>
@endsection
