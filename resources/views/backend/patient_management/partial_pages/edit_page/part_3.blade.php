{{-- Recommendation --}}
<div class="form-group col-md-6">
    <label>Recommended?</label>
    <select name="is_recommend" id="is_recommend" class="form-control">
        <option value="0" {{ !$patient->is_recommend ? 'selected' : '' }}>No</option>
        <option value="1" {{ $patient->is_recommend ? 'selected' : '' }}>Yes</option>
    </select>
</div>

<div class="recommend-section col-12">
    <div class="row">
        <!-- Doctor Name -->
        <div class="form-group col-md-6">
            <label>Doctor Name</label>
            <input type="text" name="recommend_doctor_name" class="form-control"
                value="{{ $patient->recommend_doctor_name }}">
        </div>

        <!-- Doctor Note -->
        <div class="form-group col-md-6">
            <label>Doctor's Note</label>
            <textarea name="recommend_note" id="edit_recommend_note" class="form-control">{!! $patient->recommend_note !!}</textarea>
        </div>
        {{-- Existing Documents --}}
        <div class="form-group col-md-12">
            <label>Patient Documents</label>

            <div class="card shadow-sm border-0">
                <div class="card-body">
                    @if ($documents->count() > 0)
                        <div class="row">
                            @foreach ($documents as $doc)
                                <div class="col-md-4 col-lg-3 mb-3">
                                    <div class="card h-100 shadow-sm border document-card">

                                        {{-- 3:2 Preview --}}
                                        <div
                                            class="document-preview-3x2 bg-light border-bottom d-flex align-items-center justify-content-center overflow-hidden">
                                            @if ($doc->is_image)
                                                <img src="{{ $doc->file_url }}" alt="{{ $doc->document_name }}"
                                                    class="img-fluid w-100 h-100 document-preview-image">
                                            @else
                                                <div class="document-file-placeholder">
                                                    <div class="document-file-placeholder-inner">
                                                        <i class="fas fa-file-alt document-file-icon"></i>
                                                        <span class="document-file-ext">
                                                            {{ $doc->extension ?: 'FILE' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="card-body">
                                            <div class="document-title" title="{{ $doc->document_name }}">
                                                {{ $doc->document_name }}
                                            </div>

                                            <div class="document-meta">
                                                <span class="document-meta-line">
                                                    {{ strtoupper($doc->extension ?: 'FILE') }} •
                                                    {{ $doc->file_size_formatted }}
                                                </span>

                                                @if ($doc->is_image && $doc->width && $doc->height)
                                                    <span class="document-meta-line">
                                                        {{ $doc->width }} × {{ $doc->height }} px
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="document-actions">
                                                <a href="{{ $doc->file_url }}" target="_blank"
                                                    class="btn btn-sm btn-primary">
                                                    View
                                                </a>

                                                <a href="{{ $doc->file_url }}" download class="btn btn-sm btn-success">
                                                    Download
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center text-muted py-4">
                            No file available
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Upload New Documents --}}
        <div class="form-group col-md-6">
            <label>Add More Documents</label>
            <input type="file" name="documents[]" multiple class="form-control">
        </div>

        <div class="form-group col-md-6">
            <label>Date</label>

            <input type="date" name="date_of_patient_added"
                class="form-control @error('date_of_patient_added') is-invalid @enderror"
                value="{{ old('date_of_patient_added', $patient->date_of_patient_added ? \Carbon\Carbon::parse($patient->date_of_patient_added)->format('Y-m-d') : '') }}">

            @error('date_of_patient_added')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

    </div>
</div>
