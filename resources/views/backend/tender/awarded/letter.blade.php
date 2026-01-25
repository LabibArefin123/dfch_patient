@extends('adminlte::page')

@section('title', 'Participated Tender Letter')

@section('css')
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endsection

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Awarded Tender Letter</h1>
        <a href="{{ route('awarded_tenders.index') }}" class="btn btn-success btn-sm">
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

    <div class="row">
        {{-- Letters List --}}
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white py-2">
                    <strong>
                        Awarded Letters for Tender →
                        {{ $tAwarded->tenderParticipate->tender->title ?? '' }}
                        [{{ $tAwarded->tenderParticipate->tender->tender_no ?? '' }}]
                    </strong>
                </div>
                <div class="card-header bg-dark text-white py-2 d-flex justify-content-between align-items-center">
                    <strong>Uploaded Letters</strong>
                </div>
                <div class="card-body table-responsive p-0">
                    <table id="awardedTable" class="table table-striped table-hover table-bordered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 60px;">SL</th>
                                <th>Ref No</th>
                                <th>Remarks</th>
                                <th>Value</th>
                                <th class="text-center" style="width: 140px;">Date</th>
                                <th class="text-center">PDF</th>
                                <th class="text-center" style="width: 120px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tenderLetters as $key => $letter)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $letter->reference_no }}</td>
                                    <td>{{ $letter->remarks }}</td>
                                    <td>{{ $letter->value }}</td>
                                    <td class="text-center">{{ \Carbon\Carbon::parse($letter->date)->format('d M, Y') }}
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ asset('uploads/documents/tender_letters/awarded/' . $letter->document) }}"
                                            target="_blank" class="btn btn-sm btn-primary">
                                            <i class="fas fa-file-pdf"></i> View
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('awarded_tenders.letter.edit', $letter->id) }}"
                                            class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('awarded_tenders.letter.destroy', $letter->id) }}"
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

        {{-- Add Form --}}
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white py-2">
                    <strong>Add New Letter</strong>
                </div>
                <div class="card-body">
                    <form action="{{ route('awarded_tenders.letter.store', $tenderId) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="type" value="1">

                        <div class="mb-3">
                            <label for="reference_no" class="form-label">Reference No <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="reference_no"
                                class="form-control @error('reference_no') is-invalid @enderror"
                                value="{{ old('reference_no') }}">
                            @error('reference_no')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="remarks" class="form-label">Remarks <span class="text-danger">*</span></label>
                            <textarea name="remarks" rows="3" class="form-control @error('remarks') is-invalid @enderror">{{ old('remarks') }}</textarea>
                            @error('remarks')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="date" class="form-label">Date <span class="text-danger">*</span></label>
                            <input type="date" name="date" value="{{ old('date', now()->toDateString()) }}"
                                class="form-control @error('date') is-invalid @enderror">
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="value" class="form-label">Value </label>
                            <input name="value" rows="3" class="form-control @error('remarks') is-invalid @enderror"
                                value="{{ old('value') }}"></input>
                            @error('value')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="document" class="form-label">Upload PDF <span class="text-danger">*</span></label>
                            <input type="file" name="document" accept="application/pdf"
                                class="form-control @error('document') is-invalid @enderror">
                            @error('document')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-upload me-1"></i> Upload Letter
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>

@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $(function() {
            $('#awardedTable').DataTable({
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
