@extends('adminlte::page')

@section('title', 'Profile Management')

@section('content')
    <div class="container">
        <h2 class="mb-4">Profile Management</h2>

        <!-- Users Section -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h4>All Users</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="text-center">Profile</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone 1</th>
                                <th>Phone 2</th>
                                <th>Age</th>
                                <th>National ID</th>
                                <th>Gender</th>
                                <th>Marital Status</th>
                                <th>User Type</th> {{-- Display user type name, not ID --}}
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr class="py-2">
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="text-center">
                                        <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('images/default.jpg') }}"
                                            alt="Profile Picture" class="rounded-circle mx-auto d-block" width="50"
                                            height="50">
                                    </td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone_1 ?? 'N/A' }}</td>
                                    <td>{{ $user->phone_2 ?? 'N/A' }}</td>
                                    <td>
                                        @if ($user->dob)
                                            {{ \Carbon\Carbon::parse($user->dob)->age }}
                                        @else
                                            Not Provided
                                        @endif
                                    </td>
                                    <td>{{ $user->nid ?? 'N/A' }}</td>
                                    <td>{{ ucfirst($user->gender ?? 'N/A') }}</td>
                                    <td>{{ ucfirst($user->marital_status ?? 'N/A') }}</td>
                                    <td>{{ $user->userType->name ?? 'N/A' }}</td> {{-- Display user type name --}}
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="12" class="text-center">No users found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Employees Section -->
      
    </div>
@endsection
