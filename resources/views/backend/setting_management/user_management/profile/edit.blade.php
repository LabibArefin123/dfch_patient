@extends('adminlte::page')

@section('title', 'Edit User Profile')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Edit User</h1>
        <button class="btn btn-sm btn-warning d-flex align-items-center gap-1" onclick="history.back()">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left"
                viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M15 8a.5.5 0 0 1-.5.5H2.707l4.147 4.146a.5.5 0 0 1-.708.708l-5-5a.5.5 0 0 1 0-.708l5-5a.5.5 0 0 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8z" />
            </svg>
            Go Back
        </button>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>There were some problems with your input:</strong>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('user_profile_update') }}" method="POST" enctype="multipart/form-data"
                id="profileUpdateForm">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="name">Full Name</label>
                        <input type="text" name="name" id="name"
                            class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}"
                            >
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username"
                            class="form-control @error('username') is-invalid @enderror"
                            value="{{ old('username', $user->username) }}" >
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="email">Email Address</label>
                        <input type="email" name="email" id="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email', $user->email) }}" >
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group col-md-6">
                        <label for="phone">Phone</label>
                        <input type="text" name="phone" id="phone"
                            class="form-control @error('phone') is-invalid @enderror"
                            value="{{ old('phone', $user->phone) }}">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="phone_2">Phone 2</label>
                        <input type="text" name="phone_2" id="phone_2"
                            class="form-control @error('phone_2') is-invalid @enderror"
                            value="{{ old('phone_2', $user->phone_2) }}">
                        @error('phone_2')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="profile_picture">Profile Picture</label>
                        <input type="file" name="profile_picture" id="profile_picture"
                            class="form-control @error('profile_picture') is-invalid @enderror">
                        @error('profile_picture')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="current_password">Current Password</label>
                        <div class="input-group">
                            <input type="password" name="current_password" id="current_password" class="form-control"
                                >
                            <button type="button" class="btn btn-outline-secondary toggle-password"
                                data-target="current_password">
                                <i class="fa fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="new_password">New Password</label>
                        <div class="input-group">
                            <input type="password" name="new_password" id="new_password" class="form-control" >
                            <button type="button" class="btn btn-outline-secondary toggle-password"
                                data-target="new_password">
                                <i class="fa fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="confirm_password">Confirm New Password</label>
                        <div class="input-group">
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control"
                                >
                            <button type="button" class="btn btn-outline-secondary toggle-password"
                                data-target="confirm_password">
                                <i class="fa fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" id="updateProfileBtn">Update Profile</button>
                <div class="mt-4" style="height:50px;"></div>
            </form>
        </div>

    </div>
    <script>
        // SweetAlert for Profile Update Button
        document.getElementById('updateProfileBtn').addEventListener('click', function(e) {
            e.preventDefault(); // Prevent form submission

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to update your profile?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, update it!',
                cancelButtonText: 'No, cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('profileUpdateForm').submit(); // Submit the form if confirmed
                }
            });
        });

        // Disable back button and warn user about leaving with unsaved changes
    </script>
@endsection
