@if ($patient->is_recommend)

    <div class="patient-section-card recommendation-card">

        <div class="patient-section-header recommendation-header">

            <div class="section-icon purple">

                <i class="fas fa-user-md"></i>

            </div>

            <div>

                <h5 class="mb-0">
                    Doctor Recommendation
                </h5>

                <small>
                    Clinical recommendation and supporting documents
                </small>

            </div>

        </div>


        <div class="patient-section-body">

            <div class="row">

                <div class="col-md-6 mb-3">

                    <div class="recommendation-detail">

                        <span>
                            <i class="fas fa-user-md mr-1"></i>
                            Recommended By
                        </span>

                        <strong>
                            {{ $patient->recommend_doctor_name ?: 'N/A' }}
                        </strong>

                    </div>

                </div>


                <div class="col-md-6 mb-3">

                    <div class="recommendation-detail">

                        <span>
                            <i class="fas fa-check-circle mr-1"></i>
                            Status
                        </span>

                        <strong class="text-success">
                            Active Recommendation
                        </strong>

                    </div>

                </div>

            </div>


            <div class="medical-note-box mb-4">

                <div class="medical-note-title">

                    <i class="fas fa-comment-medical mr-1"></i>

                    Doctor's Note

                </div>

                <div class="medical-note-content">

                    {!! $patient->recommend_note ?: '<span class="text-muted">No note provided</span>' !!}

                </div>

            </div>


            @php
                $documents = $patient->documents->where('document_type', 'recommendation');
            @endphp


            <div>

                <div class="documents-title mb-2">

                    <i class="fas fa-paperclip mr-1"></i>

                    Supporting Documents

                </div>


                @if ($documents->count() > 0)

                    <div class="recommendation-documents">

                        @foreach ($documents as $doc)
                            <div class="document-item">

                                <div class="document-info">

                                    <div class="document-icon">

                                        <i class="fas fa-file-medical"></i>

                                    </div>

                                    <span>
                                        {{ $doc->document_name }}
                                    </span>

                                </div>


                                <a href="{{ asset($doc->file_path) }}" target="_blank"
                                    class="btn btn-sm btn-outline-primary">

                                    <i class="fas fa-eye mr-1"></i>
                                    View

                                </a>

                            </div>
                        @endforeach

                    </div>
                @else
                    <div class="empty-state">

                        <i class="fas fa-folder-open"></i>

                        <span>
                            No recommendation documents available
                        </span>

                    </div>

                @endif

            </div>

        </div>

    </div>

@endif
