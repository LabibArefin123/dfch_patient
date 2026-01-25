@extends('adminlte::page')

@section('title', 'Edit Profile Picture')

@section('content')
<div class="container">
    <h2>Edit Profile Picture</h2>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('profile_picture_update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Display the current profile picture -->
                <div class="text-center mb-3">
                    <img src="{{ asset('storage/' . $user->profile_picture) }}" 
                         alt="Profile Picture" 
                         class="img-fluid rounded-circle" 
                         style="width: 150px; height: 150px; object-fit: cover;">
                </div>

                <div class="form-group">
                    <label for="profile_picture">Upload New Profile Picture</label>
                    <input type="file" name="profile_picture" id="profile_picture"
                           class="form-control @error('profile_picture') is-invalid @enderror" required>
                    @error('profile_picture')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Update Picture</button>
                <a href="{{ route('profile') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
