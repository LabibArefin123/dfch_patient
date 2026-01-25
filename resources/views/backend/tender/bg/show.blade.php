@extends('adminlte::page')

@section('title', 'Tender BG Details')

@section('content_header')
    <h1 class="mb-0">Tender Guarantee (BG) Details</h1>
@stop

@section('content')
    <div class="card shadow rounded-4">

        <div class="card-body bg-light rounded-bottom-4">
            <div class="row">

                {{-- Tender Title --}}
                <div class="form-group col-md-6">
                    <label class="text-dark fw-semibold">Tender Title:</label>
                    <div class="form-control bg-white">{{ $bg->tender->title ?? '-' }}</div>
                </div>

                {{-- Tender No --}}
                <div class="form-group col-md-6">
                    <label class="text-dark fw-semibold">Tender Number:</label>
                    <div class="form-control bg-white">{{ $bg->tender->tender_no ?? '-' }}</div>
                </div>

                {{-- BG Number --}}
                <div class="form-group col-md-6">
                    <label class="text-dark fw-semibold">BG Number:</label>
                    <div class="form-control bg-white">{{ $bg->bg->bg_no ?? '-' }}</div>
                </div>

                {{-- Issue Bank --}}
                <div class="form-group col-md-6">
                    <label class="text-dark fw-semibold">Issue Bank:</label>
                    <div class="form-control bg-white">{{ $bg->bg->issue_in_bank ?? '-' }}</div>
                </div>

                {{-- Issue Branch --}}
                <div class="form-group col-md-6">
                    <label class="text-dark fw-semibold">Issue Branch:</label>
                    <div class="form-control bg-white">{{ $bg->bg->issue_in_branch ?? '-' }}</div>
                </div>

                {{-- Issue Date --}}
                <div class="form-group col-md-6">
                    <label class="text-dark fw-semibold">Issue Date:</label>
                    <div class="form-control bg-white">{{ $bg->bg->issue_date ?? '-' }}</div>
                </div>

                {{-- Expiry Date --}}
                <div class="form-group col-md-6">
                    <label class="text-dark fw-semibold">Expiry Date:</label>
                    <div class="form-control bg-white">{{ $bg->bg->expiry_date ?? '-' }}</div>
                </div>

                {{-- Amount --}}
                <div class="form-group col-md-6">
                    <label class="text-dark fw-semibold">Amount:</label>
                    <div class="form-control bg-white">{{ $bg->bg->amount ?? '-' }}</div>
                </div>

                {{-- Attachment --}}
                <div class="form-group col-md-6">
                    <label class="text-dark fw-semibold">Attachment:</label>
                    <div>
                        @if (!empty($bg->bg->attachment))
                            <a href="{{ asset('uploads/documents/bg_attachments/' . $bg->bg->attachment) }}" target="_blank"
                                class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-file-download"></i> View File
                            </a>
                        @else
                            <div class="form-control bg-white text-muted">No file</div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

@stop
