@extends('adminlte::page')

@section('title', 'Specialists Information')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>
            <i class="fas fa-user-md text-danger"></i>
            Specialist List
        </h1>
        <div class="d-flex gap-2">
            <a href="{{ route('specialists.create') }}" class="btn btn-success">
                <i class="fas fa-plus-circle"></i>
                Add Specialist
            </a>
            <a href="{{ route('specialist-cards.index') }}" class="btn btn-primary">
                See Specialist Card
            </a>
        </div>
    </div>
@stop

@section('content')
    <link rel="stylesheet" href="{{ asset('css/backend/specialist_card/index_page/index_action.css') }}">
    <div class="card card-outline card-primary shadow">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-stethoscope"></i>
                Hospital Specialists
            </h3>

            <div class="card-tools">
                <span class="badge badge-primary">
                    Total : {{ $specialists->total() }}
                </span>
            </div>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-hover table-bordered text-nowrap" id="dataTables">
                <thead class="bg-primary text-center">
                    <tr>
                        <th width="60">SL</th>
                        <th width="110">Photo</th>
                        <th>Name</th>
                        <th>Designation</th>
                        <th>Degree</th>
                        <th width="80">Position</th>
                        <th width="90">Status</th>
                        <th width="200">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($specialists as $specialist)
                        @php
                            $filePath = null;
                            foreach (['jpg', 'jpeg', 'png', 'webp'] as $ext) {
                                $path = public_path(
                                    'uploads/images/welcome_page/doctors/' . $specialist->photo . '.' . $ext,
                                );
                                if (file_exists($path)) {
                                    $filePath = asset(
                                        'uploads/images/welcome_page/doctors/' . $specialist->photo . '.' . $ext,
                                    );
                                    break;
                                }
                            }
                        @endphp

                        <tr>
                            <td class="text-center align-middle">
                                {{ $loop->iteration }}
                            </td>
                            <td class="text-center align-middle">
                                @php
                                    $image = asset('uploads/images/welcome_page/doctors/' . $specialist->photo);
                                @endphp
                                <img src="{{ $image }}" alt="{{ $specialist->name }}" class="img-thumbnail zoomable"
                                    style="width:80px;height:80px;object-fit:contain;cursor:pointer;" data-bs-toggle="modal"
                                    data-bs-target="#imageZoomModal" data-bs-img-src="{{ $image }}">
                            </td>

                            <td class="align-middle">
                                <strong>{{ $specialist->name }}</strong>
                            </td>

                            <td class="align-middle">
                                {{ $specialist->designation }}
                            </td>

                            <td class="align-middle">
                                {{ $specialist->degree }}
                            </td>

                            <td class="text-center align-middle">
                                <span class="badge badge-info">
                                    {{ $specialist->position }}
                                </span>
                            </td>

                            <td class="text-center align-middle">
                                @if ($specialist->is_active)
                                    <span class="badge badge-success">
                                        Active
                                    </span>
                                @else
                                    <span class="badge badge-secondary">
                                        Inactive
                                    </span>
                                @endif
                            </td>

                            <td class="text-center align-middle">
                                <div class="specialist-action-grid">

                                    {{-- View Profile --}}
                                    <a href="{{ route('specialists.show', $specialist->id) }}"
                                        class="specialist-action-btn btn-profile" title="View Specialist Profile">
                                        <i class="fas fa-user-md"></i>
                                        <span>Profile</span>
                                    </a>

                                    {{-- View Card --}}
                                    <a href="{{ route('specialist-cards.show', $specialist->id) }}"
                                        class="specialist-action-btn btn-card" title="View Specialist Card">
                                        <i class="fas fa-id-card"></i>
                                        <span>Card</span>
                                    </a>

                                    {{-- Edit --}}
                                    <a href="{{ route('specialists.edit', $specialist->id) }}"
                                        class="specialist-action-btn btn-edit" title="Edit Specialist Information">
                                        <i class="fas fa-edit"></i>
                                        <span>Edit</span>
                                    </a>

                                    {{-- Delete --}}
                                    <form action="{{ route('specialists.destroy', $specialist->id) }}" method="POST"
                                        class="specialist-action-form">
                                        @csrf
                                        @method('DELETE')

                                        <button type="button" class="specialist-action-btn btn-delete"
                                            title="Delete Specialist"
                                            onclick="triggerDeleteModal('{{ route('specialists.destroy', $specialist->id) }}')">
                                            <i class="fas fa-trash-alt"></i>
                                            <span>Delete</span>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty

                        <tr>

                            <td colspan="8" class="text-center text-muted py-5">

                                <i class="fas fa-user-md fa-3x mb-3"></i>

                                <br>

                                No Specialists Found.

                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>
    </div>

    <div style="height: 50px;"></div>
@stop
