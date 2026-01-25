@extends('adminlte::page')

@section('title', 'User Profile')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>User Profile</h1>
        <a href="{{ route('user_profile_edit') }}" class="btn btn-warning" id="editProfileBtn">
            <i class="fas fa-edit me-1"></i> Edit Profile
        </a>
    </div>
@stop


@section('content')


    <div class="container-fluid">
        <!-- Profile Card -->
        <div class="card shadow-sm">
            <div class="card-body row align-items-center">
                <!-- Profile Image -->
                <div class="col-md-3 text-center">
                    <img src="{{ $user->getProfilePictureUrl() }}" class="rounded-circle img-fluid shadow"
                        alt="Profile Picture" style="width: 150px; height: 150px; object-fit: cover;">
                </div>

                <!-- User Info -->
                <div class="col-md-9">
                    <h4 class="mb-3">{{ $user->name }}</h4>
                    <div class="row">
                        <div class="col-md-6 mb-2"><strong>Company Name:</strong> {{ $user->company_name }}</div>
                        <div class="col-md-6 mb-2"><strong>Username:</strong> {{ $user->username }}</div>
                        <div class="col-md-6 mb-2"><strong>Email:</strong> {{ $user->email }}</div>
                        <div class="col-md-6 mb-2"><strong>Phone:</strong> {{ $user->phone ?? 'Not Provided' }}</div>
                        <div class="col-md-6 mb-2"><strong>Phone 2:</strong> {{ $user->phone_2 ?? 'Not Provided' }}</div>
                        @if ($user->user_type == 1)
                            <div class="col-md-6 mb-2"><strong>User Role:</strong>
                                {{ $user->role->name ?? 'Not Assigned' }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-4 shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-key me-2"></i>Change Password</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('user_password_update') }}" method="POST" id="updatePasswordForm">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="current_password">Current Password</label>
                        <input type="password" name="current_password" id="current_password" class="form-control" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="new_password">New Password</label>
                        <input type="password" name="new_password" id="new_password" class="form-control" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="confirm_password">Confirm New Password</label>
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success" id="updatePasswordBtn">
                        <i class="fas fa-save me-1"></i> Update Password
                    </button>
                </div>
            </form>
        </div>
    </div>
    </div>

@endsection

@section('js')
    <script>
        // Edit Profile Confirmation
        document.getElementById('editProfileBtn').addEventListener('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Do you want to edit your profile?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, edit it!',
                cancelButtonText: 'No, cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('user_profile_edit') }}";
                }
            });
        });

        // Update Password Confirmation
        document.getElementById('updatePasswordBtn').addEventListener('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to update your password?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, update it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('updatePasswordForm').submit();
                }
            });
        });
    </script>
@endsection
