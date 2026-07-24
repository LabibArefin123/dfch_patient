<div class="col-12">
    <div class="patient-section-card recommend-card">
        <div class="section-header">
            <div>
                <h5><i class="fas fa-user-md text-success"></i>Reffered Information </h5>
                <span> Doctor referral & patient documents archive </span>
            </div>
            <span class="section-badge recommend-badge">
                Referral Record
            </span>
        </div>

        <div class="row">
            <div class="form-group col-md-6">
                <label>Is Patient Referred?</label>
                <select name="is_recommend" id="is_recommend" class="form-control">
                    <option value="0" {{ old('is_recommend', $patient->is_recommend) == 0 ? 'selected' : '' }}>
                        No
                    </option>
                    <option value="1" {{ old('is_recommend', $patient->is_recommend) == 1 ? 'selected' : '' }}>
                        Yes
                    </option>
                </select>
            </div>
        </div>

        <div class="recommend-section">
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Referred Doctor Name</label>
                    <input type="text" name="recommend_doctor_name" class="form-control"
                        value="{{ old('recommend_doctor_name', $patient->recommend_doctor_name) }}">
                </div>

                {{-- Doctor Note --}}
                <div class="form-group col-md-6">
                    <label>Referred Doctor's Note</label>
                    <textarea name="recommend_note" id="edit_recommend_note" class="form-control">{!! old('recommend_note', $patient->recommend_note) !!}</textarea>
                </div>

                {{-- Existing Documents --}}
                <div class="form-group col-md-12">
                    <label>Patient Documents</label>
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            @if ($documents->count() > 0)
                                <div class="row">
                                    @foreach ($documents as $doc)
                                        <div class="col-md-4 col-lg-3 mb-4">
                                            <div class="card h-100 border-0 recommendation-document-card">
                                                <div class="document-preview-3x2">
                                                    @if ($doc->is_image)
                                                        <img src="{{ $doc->file_url }}" alt="{{ $doc->document_name }}"
                                                            class="document-preview-image">
                                                    @else
                                                        <div class="document-file-placeholder">
                                                            <div class="document-file-placeholder-inner">
                                                                <i
                                                                    class="fas fa-file-medical-alt document-file-icon"></i>
                                                                <span class="document-file-ext">
                                                                    {{ strtoupper($doc->extension ?: 'FILE') }}
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
                                                            {{ strtoupper($doc->extension ?: 'FILE') }}
                                                            •
                                                            {{ $doc->file_size_formatted }}
                                                        </span>

                                                        @if ($doc->is_image && $doc->width && $doc->height)
                                                            <span class="document-meta-line">
                                                                {{ $doc->width }}
                                                                ×
                                                                {{ $doc->height }} px
                                                            </span>
                                                        @endif
                                                    </div>

                                                    <div class="document-actions">
                                                        <a href="{{ $doc->file_url }}" target="_blank"
                                                            class="btn btn-sm btn-primary">
                                                            <i class="fas fa-eye mr-1"></i>
                                                            View
                                                        </a>

                                                        <a href="{{ $doc->file_url }}" download
                                                            class="btn btn-sm btn-success">

                                                            <i class="fas fa-download mr-1"></i>
                                                            Download
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="empty-document-box">
                                    <i class="fas fa-file-medical"></i>
                                    <h6>No Documents Available</h6>
                                    <p>
                                        Patient referred files have not been uploaded.
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Upload --}}
                <div class="form-group col-md-6">

                    <label>Add More Documents</label>

                    <input type="file" name="documents[]" multiple class="form-control">

                </div>
                <div id="referPreviewContainer" class="refer-preview-container mt-3"></div>
                {{-- Date --}}
                <div class="form-group col-md-6">

                    <label>Date of Patient Added</label>

                    <input type="date" name="date_of_patient_added"
                        class="form-control @error('date_of_patient_added') is-invalid @enderror"
                        value="{{ old(
                            'date_of_patient_added',
                            $patient->date_of_patient_added ? \Carbon\Carbon::parse($patient->date_of_patient_added)->format('Y-m-d') : '',
                        ) }}">

                    @error('date_of_patient_added')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

            </div>

        </div>

    </div>

</div>
