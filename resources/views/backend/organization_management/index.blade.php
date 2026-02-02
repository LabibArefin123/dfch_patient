@extends('adminlte::page')

@section('title', 'Organizations')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h1>Organization List</h1>
        <a href="{{ route('organizations.create') }}" class="btn btn-success btn-sm">
            + Add Organization
        </a>
    </div>
@stop

@section('content')
    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-striped table-hover text-nowrap" id="dataTables">
                <thead class="thead-dark">
                    <tr>
                        <th class="text-center">SL</th>
                        <th class="text-center">Logo</th>
                        <th class="text-center">Logo Name</th>
                        <th>Name</th>
                        <th class="text-center">Location</th>
                        <th class="text-center">Slogun</th>
                        <th style="width: 200px;" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($organizations as $key => $organization)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            {{-- Organization Logo / Document --}}
                            <td class="text-center">
                                @php
                                    $filePath = null;
                                    $fileType = null;

                                    if ($organization->organization_picture) {
                                        foreach (['jpg', 'jpeg', 'png', 'webp', 'pdf'] as $ext) {
                                            $path = public_path(
                                                'uploads/images/backend/organization/' .
                                                    $organization->organization_picture .
                                                    '.' .
                                                    $ext,
                                            );

                                            if (file_exists($path)) {
                                                $filePath = asset(
                                                    'uploads/images/backend/organization/' .
                                                        $organization->organization_picture .
                                                        '.' .
                                                        $ext,
                                                );
                                                $fileType = $ext;
                                                break;
                                            }
                                        }
                                    }
                                @endphp

                                @if ($filePath)
                                    @if ($fileType === 'pdf')
                                        <a href="{{ $filePath }}" target="_blank"
                                            class="badge bg-info text-decoration-none">
                                            PDF
                                        </a>
                                    @else
                                        <a href="{{ $filePath }}" target="_blank">
                                            <img src="{{ $filePath }}" alt="Org Logo" 
                                               style="width:200px; height:50px;">
                                        </a>
                                    @endif
                                @else
                                    <span class="badge bg-danger">No File</span>
                                @endif
                            </td>
                            <td class="text-center">{{ $organization->organization_logo_name }}</td>
                            <td>{{ $organization->name }}</td>
                            <td class="text-center">{{ $organization->organization_location }}</td>
                            <td class="text-center">{{ $organization->organization_slogan }}</td>
                            <td class="text-center">
                                <a href="{{ route('organizations.edit', $organization->id) }}"
                                    class="btn btn-sm btn-primary">
                                    Edit
                                </a>
                                <a href="{{ route('organizations.show', $organization->id) }}"
                                    class="btn btn-sm btn-warning">
                                    Show
                                </a>
                                <form action="{{ route('organizations.destroy', $organization->id) }}" method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Are you sure you want to delete this organization?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted">
                                No organizations found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop
