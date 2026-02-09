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
                                        <a href="{{ route('system_users.show', $user->id) }}"
                                            class="btn btn-info btn-sm me-2">View</a>
                                        <a href="{{ route('system_users.edit', $user->id) }}"
                                            class="btn btn-warning btn-sm me-2">Edit</a>
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
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content shadow-lg">
                                <div class="modal-header">
                                    <h5 class="modal-title">
                                        Change Password – <span id="modalUserName"></span>
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal">
                                        <span>&times;</span>
                                    </button>
                                </div>

                                <form method="POST" id="changePasswordForm">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>New Password</label>
                                            <div class="input-group">
                                                <input type="password" name="password" id="password" class="form-control"
                                                    required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text toggle-password" data-target="password">
                                                        <i class="fas fa-eye"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Confirm Password</label>
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

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                            Close
                                        </button>
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
               CHANGE PASSWORD MODAL
            ============================ */
            document.querySelectorAll('.change-password-btn').forEach(button => {
                button.addEventListener('click', function() {

                    const userId = this.dataset.userId;
                    const userName = this.dataset.userName;

                    // Set modal title
                    document.getElementById('modalUserName').innerText = userName;

                    // Set correct form action
                    const form = document.getElementById('changePasswordForm');
                    form.action = `/system-users/${userId}/change-password`;

                    // Reset form fields
                    form.reset();

                    // Show modal (AdminLTE / Bootstrap)
                    $('#changePasswordModal').modal('show');
                });
            });

            /* ============================
               PASSWORD EYE TOGGLE
            ============================ */
            document.addEventListener('click', function(e) {
                if (e.target.closest('.toggle-password')) {

                    const toggle = e.target.closest('.toggle-password');
                    const input = document.getElementById(toggle.dataset.target);
                    const icon = toggle.querySelector('i');

                    if (!input) return;

                    if (input.type === 'password') {
                        input.type = 'text';
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    } else {
                        input.type = 'password';
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    }
                }
            });

        });
    </script>
@endsection
