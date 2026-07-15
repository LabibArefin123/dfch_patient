@extends('adminlte::page')

@section('title', 'Specialists')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>
            <i class="fas fa-user-md text-danger"></i>
            Specialist List
        </h1>

        <a href="{{ route('specialists.create') }}" class="btn btn-success">
            <i class="fas fa-plus-circle"></i>
            Add Specialist
        </a>
    </div>
@stop

@section('content')

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

        <div class="card-body table-responsive p-0">

            <table class="table table-hover table-bordered text-nowrap">

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

                                <a href="{{ route('specialists.show', $specialist->id) }}" class="btn btn-sm btn-warning">

                                    <i class="fas fa-eye"></i>

                                </a>

                                <a href="{{ route('specialists.edit', $specialist->id) }}" class="btn btn-sm btn-primary">

                                    <i class="fas fa-edit"></i>

                                </a>

                                <form action="{{ route('specialists.destroy', $specialist->id) }}" method="POST"
                                    class="d-inline" onsubmit="return confirm('Delete this specialist?')">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-sm btn-danger">

                                        <i class="fas fa-trash"></i>

                                    </button>

                                </form>

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
