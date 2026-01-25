@extends('adminlte::page')

@section('title', 'Progress Tender Letter')

@section('css')
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endsection

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Edit Progress Tender Letter</h1>
        <a href="{{ route('tender_progress.index') }}" class="btn btn-success btn-sm">
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
        {{-- Edit Form --}}

        <div class="col">
            <div class="card border-warning shadow-sm">
                <div class="card-header bg-warning text-white py-2 d-flex justify-content-end align-items-center">
                    <a href="{{ route('tender_progress.letter', $editLetter->tender_id) }}"
                        class="btn btn-sm btn-light text-dark">Cancel</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('tender_progress.letter.update', $editLetter->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="reference_no" class="form-label">Reference</label>
                            <input type="text" name="reference_no" class="form-control"
                                value="{{ old('reference_no', $editLetter->reference_no) }}">
                        </div>

                        <div class="mb-3">
                            <label for="remarks" class="form-label">Remarks</label>
                            <textarea name="remarks" rows="3" class="form-control">{{ old('remarks', $editLetter->remarks) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="value" class="form-label">Value</label>
                            <input type="value" name="value" class="form-control"
                                value="{{ old('value', $editLetter->value) }}">
                        </div>

                        <div class="mb-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" name="date" class="form-control"
                                value="{{ old('date', $editLetter->date) }}">
                        </div>

                        <div class="mb-3">
                            <label for="document" class="form-label">Replace PDF (optional)</label>
                            <input type="file" name="document" class="form-control" accept="application/pdf">
                        </div>

                        <div class=" d-flex justify-content-end align-items-center">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Update Letter
                            </button>
                        </div>
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
            $('#progressTable').DataTable({
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
