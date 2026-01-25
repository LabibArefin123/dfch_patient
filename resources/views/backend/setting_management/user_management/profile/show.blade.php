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
                    <img src="{{ $user->profile_picture ? asset($user->profile_picture) : asset('uploads/images/default.jpg') }}"
                        class="rounded-circle img-fluid shadow" alt="Profile Picture"
                        style="width: 150px; height: 150px; object-fit: cover;">
                </div>

                <!-- User Info -->
                <div class="col-md-9">
                    <h4 class="mb-3">{{ $user->name }}</h4>
                    <div class="row">
                        <div class="col-md-6 mb-2"><strong>Username:</strong> {{ $user->username }}</div>
                        <div class="col-md-6 mb-2"><strong>Company Name:</strong> {{ $organization->name }}</div>
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
        <div class="card mt-4 shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">Company Documents</h5>
            </div>

            @php
                $documentTypes = [
                    'trade' => 'Trade Documents',
                    'tax' => 'Tax Documents',
                    'bin' => 'BIN Documents',
                    'irc' => 'IRC Documents',
                    'erc' => 'ERC Documents',
                    'irc_indent' => 'IRC Indenting Documents',
                    'nid' => 'NID Documents',
                    'org_member' => 'Organization Member Documents',
                ];
            @endphp

            @foreach ($documentTypes as $type => $label)
                <div class="card mb-4">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">{{ $label }}</h5>
                    </div>
                    <div class="card-body">
                        @php $index = 1; @endphp
                        @if ($organization->documents->where('type', $type)->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped align-middle">
                                    <thead class="table-dark">
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">{{ ucfirst($type) }} No</th>
                                            <th class="text-center">Validity</th>
                                            <th class="text-center">Financial Year</th>
                                            <th class="text-center">Document</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($organization->documents->where('type', $type) as $document)
                                            <tr>
                                                <td class="text-center">{{ $index }}</td>
                                                <td class="text-center">{{ $document->number ?? '-' }}</td>
                                                <td class="text-center">
                                                    @if ($document->validity)
                                                        {{ \Carbon\Carbon::parse($document->validity)->format('d F Y') }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td class="text-center">{{ $document->financial_year ?? '-' }}</td>
                                                <td class="text-center">
                                                    @php
                                                        $path =
                                                            'uploads/documents/company_documents/' .
                                                            $type .
                                                            '/' .
                                                            ($document->document ?? '');
                                                    @endphp
                                                    @if ($document->document && file_exists(public_path($path)))
                                                        <a href="{{ asset($path) }}" target="_blank"
                                                            class="btn btn-sm btn-primary">
                                                            View
                                                        </a>
                                                    @else
                                                        <span class="text-muted">No document</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @php $index++; @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted">No {{ strtolower($label) }} available.</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        <div class="card-header">
            <h5 class="mb-0">Company Enlistments</h5>
        </div>
        <div class="card-body">
            @if ($organization->enlistments->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-center">#</th>
                                <th>Customer Name</th>
                                <th class="text-center">Validity</th>
                                <th class="text-center">Security Deposit</th>
                                <th class="text-center">Financial Year</th>
                                <th class="text-center">Document</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($organization->enlistments as $key => $enlistment)
                                <tr>
                                    <td class="text-center">{{ $key + 1 }}</td>
                                    <td>{{ $enlistment->customer_name ?? '-' }}</td>
                                    <td class="text-center">
                                        @if ($enlistment->validity)
                                            {{ \Carbon\Carbon::parse($enlistment->validity)->format('d F Y') }}
                                        @else
                                            -
                                        @endif
                                    </td>

                                    <td class="text-center">{{ $enlistment->security_deposit ?? '-' }}</td>
                                    <td class="text-center">{{ $enlistment->financial_year ?? '-' }}</td>
                                    <td class="text-center">
                                        @if ($enlistment->document && file_exists(public_path('uploads/documents/company_enlistments/' . $enlistment->document)))
                                            <a href="{{ asset('uploads/documents/company_enlistments/' . $enlistment->document) }}"
                                                target="_blank" class="btn btn-sm btn-primary">
                                                View
                                            </a>
                                        @else
                                            <span class="text-muted">No document</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted">No enlistments available.</p>
            @endif
        </div>
{{-- 
        <div class="card mt-4">
            <div class="card-body" style="height:5px;">
                <!-- Intentionally left blank -->
            </div>
        </div> --}}

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
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.toggle-password').forEach(toggle => {
                toggle.addEventListener('click', function() {
                    const target = document.querySelector(this.dataset.target);
                    const icon = this.querySelector('i');
                    if (target.type === 'password') {
                        target.type = 'text';
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    } else {
                        target.type = 'password';
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    }
                });
            });
        });
    </script>
@endsection
