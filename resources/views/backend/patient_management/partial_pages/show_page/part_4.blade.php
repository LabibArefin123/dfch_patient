@if ($patient->is_recommend)
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-user-md me-2"></i>Doctor Recommendation</h5>
        </div>

        <div class="card-body">
            {{-- Doctor Name --}}
            <div class="mb-3 row">
                <label class="col-md-3 col-form-label text-muted">Doctor Name:</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" value="{{ $patient->recommend_doctor_name }}" disabled>
                </div>
            </div>

            {{-- Doctor Note --}}
            <div class="mb-3 row">
                <label class="col-md-3 col-form-label text-muted">Doctor's Note:</label>
                <div class="col-md-9">
                    <div class="form-control" style="height:auto; min-height:100px;">
                        {!! $patient->recommend_note ?? '<span class="text-muted">No note provided</span>' !!}
                    </div>
                </div>
            </div>

            {{-- Patient Documents --}}
            <div class="mb-3 row">
                <label class="col-md-3 col-form-label text-muted">Documents:</label>
                <div class="col-md-9">
                    @php
                        $documents = $patient->documents->where('document_type', 'recommendation');
                    @endphp

                    @if ($documents->count() > 0)
                        <ul class="list-group">
                            @foreach ($documents as $doc)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>{{ $doc->document_name }}</span>
                                    <a href="{{ asset($doc->file_path) }}" target="_blank"
                                        class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye me-1"></i> View
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="text-center text-muted py-2">
                            No files available
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endif
