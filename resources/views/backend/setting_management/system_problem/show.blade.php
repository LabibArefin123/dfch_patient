@extends('adminlte::page')

@section('title', 'View System Problem')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <h1 class="mb-0">System Problem Details</h1>

        <div class="btn-group">
            <a href="{{ route('system_problems.edit', $systemProblem->id) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Edit
            </a>

            <a href="{{ route('system_problems.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Go Back
            </a>
        </div>
    </div>
@stop

@section('content')

    <div class="card shadow-sm">
        <div class="card-body">

            <div class="row">

                {{-- Problem ID --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Problem ID</label>
                    <input type="text" class="form-control" value="{{ $systemProblem->problem_uid }}" readonly>
                </div>

                {{-- Priority --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Priority</label>
                    <input type="text" class="form-control" value="{{ ucfirst($systemProblem->status) }}" readonly>
                </div>

                {{-- Title --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Problem Title</label>
                    <input type="text" class="form-control" value="{{ $systemProblem->problem_title }}" readonly>
                </div>

                {{-- Reported Date --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Reported At</label>
                    <input type="text" class="form-control"
                        value="{{ $systemProblem->created_at->format('d M Y, h:i A') }}" readonly>
                </div>

                {{-- Description --}}
                <div class="col-md-12 mb-3">
                    <label class="form-label fw-semibold">Problem Description</label>
                    <textarea class="form-control" rows="5" readonly>{{ $systemProblem->problem_description }}</textarea>
                </div>

                {{-- Attachment --}}
                <div class="col-md-12 mb-3">
                    <label class="form-label fw-semibold">Attachment</label>

                    @if ($systemProblem->problem_file)
                        @php
                            $ext = pathinfo($systemProblem->problem_file, PATHINFO_EXTENSION);
                            $isImage = in_array(strtolower($ext), ['jpg', 'jpeg', 'png']);
                            $filePath = $isImage
                                ? asset('uploads/problem/images/' . $systemProblem->problem_file)
                                : asset('uploads/problem/files/' . $systemProblem->problem_file);
                        @endphp

                        @if ($isImage)
                            <div class="mt-2">
                                <a href="{{ $filePath }}" target="_blank">
                                    <img src="{{ $filePath }}" class="img-thumbnail" style="max-height:200px;">
                                </a>
                            </div>
                        @else
                            <a href="{{ $filePath }}" target="_blank" class="btn btn-outline-info mt-2">
                                <i class="fas fa-file"></i> View Attachment
                            </a>
                        @endif
                    @else
                        <p class="text-muted">No attachment provided.</p>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <div class="mb-4"></div>

@stop
