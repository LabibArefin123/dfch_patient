@extends('adminlte::page')

@section('title', 'Participated Tender Letter')

@section('css')
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endsection

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Participated Tender Letter</h1>
        <a href="{{ route('participated_tenders.index') }}" class="btn btn-success btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Back to List
        </a>
    </div>
@stop

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong class="mb-2">Please fix the following errors:</strong>
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li class="small">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Start Row --}}
    <div class="row">

        {{-- Letters List --}}
        <div class="col-lg-{{ isset($editLetter) ? '6' : '8' }} mb-4">
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-secondary text-white py-2">
                    <strong>
                        Participated Letters for Tender →
                        {{ $tParticipate->title ?? '' }} [{{ $tParticipate->tender_no ?? '' }}]
                    </strong>
                </div>

                <div class="card-header bg-dark text-white py-2">
                    <strong>Uploaded Letters</strong>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-striped table-hover table-bordered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 60px;">SL</th>
                                <th>Ref No</th>
                                <th>Remarks</th>
                                <th class="text-center" style="width: 140px;">Date</th>
                                <th>Value</th>
                                <th class="text-center">PDF</th>
                                <th class="text-center" style="width: 120px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($letters as $key => $letter)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $letter->reference_no }}</td>
                                    <td>{{ $letter->remarks }}</td>
                                    <td class="text-center">{{ \Carbon\Carbon::parse($letter->date)->format('d M, Y') }}
                                    </td>
                                    <td>{{ $letter->value }}</td>
                                    <td class="text-center">
                                        <a href="{{ asset('uploads/documents/tender_letters/participate/' . $letter->document) }}"
                                            target="_blank" class="btn btn-sm btn-primary">
                                            <i class="fas fa-file-pdf"></i> View
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('participated_tenders.letter.edit', $letter->id) }}"
                                            class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('participated_tenders.letter.destroy', $letter->id) }}"
                                            method="POST" style="display:inline-block;"
                                            onsubmit="return confirm('Are you sure you want to delete this letter?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">No letters uploaded yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Form Section (Right Side) --}}
        <div class="col-lg-{{ isset($editLetter) ? '6' : '4' }} mb-4">
            <div class="card shadow-sm border-{{ isset($editLetter) ? 'warning' : 'primary' }}">
                <div
                    class="card-header {{ isset($editLetter) ? 'bg-warning' : 'bg-primary' }} text-white py-2 d-flex justify-content-between align-items-center">
                    <strong>{{ isset($editLetter) ? 'Edit Letter' : 'Add New Letter' }}</strong>
                    @if (isset($editLetter))
                        <a href="{{ route('participated_tenders.letter', $editLetter->tender_id) }}"
                            class="btn btn-sm btn-light text-dark">Cancel</a>
                    @endif
                </div>
                <div class="card-body">
                    <form
                        action="{{ isset($editLetter)
                            ? route('participated_tenders.letter.update', $editLetter->id)
                            : route('participated_tenders.letter.store', $tParticipate->id) }}"
                        method="POST" enctype="multipart/form-data">

                        @csrf
                        @if (isset($editLetter))
                            @method('PUT')
                        @else
                            <input type="hidden" name="type" value="1">
                        @endif

                        <div class="mb-3">
                            <label class="form-label">Reference No <span class="text-danger">*</span></label>
                            <input type="text" name="reference_no"
                                value="{{ old('reference_no', $editLetter->reference_no ?? '') }}"
                                class="form-control @error('reference_no') is-invalid @enderror">
                            @error('reference_no')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Remarks <span class="text-danger">*</span></label>
                            <textarea name="remarks" rows="3" class="form-control @error('remarks') is-invalid @enderror">{{ old('remarks', $editLetter->remarks ?? '') }}</textarea>
                            @error('remarks')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Date <span class="text-danger">*</span></label>
                            <input type="date" name="date"
                                value="{{ old('date', $editLetter->date ?? now()->toDateString()) }}"
                                class="form-control @error('date') is-invalid @enderror">
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Value </label>
                            <input type="text" name="value" value="{{ old('value', $editLetter->value ?? '') }}"
                                class="form-control @error('value') is-invalid @enderror">
                            @error('value')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ isset($editLetter) ? 'Replace PDF (optional)' : 'Upload PDF' }}
                                <span class="text-danger">*</span></label>
                            <input type="file" name="document" accept="application/pdf"
                                class="form-control @error('document') is-invalid @enderror">
                            @error('document')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-{{ isset($editLetter) ? 'warning' : 'primary' }} w-100">
                            <i class="fas fa-{{ isset($editLetter) ? 'save' : 'upload' }} me-1"></i>
                            {{ isset($editLetter) ? 'Update Letter' : 'Upload Letter' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div> {{-- End Row --}}
@stop


@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $(function() {
            $('#participatedTable').DataTable({
                paging: true,
                lengthChange: false,
                searching: false,
                ordering: false,
                info: false,
                autoWidth: false,
                responsive: true,
            });
        });

        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if (session('error'))
            toastr.error("{{ session('error') }}");
        @endif
    </script>
@endsection
