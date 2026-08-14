@if ($patient->is_referred)
    <div class="patient-section-card recommendation-card">
        <div class="patient-section-header recommendation-header">
            <div class="section-icon purple">
                <i class="fas fa-user-md"></i>
            </div>

            <div>
                <h5 class="mb-0">
                    Referred Doctors
                </h5>
                <small>
                    Clinical referred doctor and supporting documents
                </small>
            </div>
        </div>

        <div class="patient-section-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="recommendation-detail">
                        <span>
                            <i class="fas fa-user-md mr-1"></i>
                            Referred By
                        </span>
                        <strong> {{ $patient->referred_doctor_name ?: 'N/A' }} </strong>
                    </div>
                </div>
            </div>

            <div class="medical-note-box mb-4">
                <div class="medical-note-title">
                    <i class="fas fa-comment-medical mr-1"></i>
                    Referred Doctor's Note
                </div>

                <div class="medical-note-content">
                    {!! $patient->referred_note ?: '<span class="text-muted">No note provided</span>' !!}
                </div>
            </div>

            @php
                $documents = $patient->documents->where('document_type', 'recommendation');

                $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg', 'jfif'];
            @endphp

            <div>
                <div class="documents-title mb-3">
                    <i class="fas fa-paperclip mr-1"></i>
                    Supporting Documents
                </div>

                @if ($documents->count() > 0)

                    <div class="row">

                        @foreach ($documents as $doc)
                            @php
                                $file = asset($doc->file_path);
                                $extension = strtolower(pathinfo($doc->file_path, PATHINFO_EXTENSION));
                                $isImage = in_array($extension, $imageExtensions);
                            @endphp
                            <div class="col-lg-3 col-md-6 mb-3">
                                <div class="card h-100 shadow-sm border">
                                    @if ($isImage)
                                        <div class="p-2">
                                            <img src="{{ $file }}" alt="{{ $doc->document_name }}"
                                                class="img-fluid rounded border w-100"
                                                style="height:180px; object-fit:contain; cursor:pointer;"
                                                data-bs-toggle="modal" data-bs-target="#imageZoomModal"
                                                data-bs-img-src="{{ $file }}">
                                        </div>
                                    @else
                                        <div class="d-flex align-items-center justify-content-center border-bottom"
                                            style="height:180px;">
                                            <div class="text-center">
                                                <i class="fas fa-file-pdf text-danger" style="font-size:70px;"></i>
                                                <div class="small text-muted mt-2">
                                                    {{ strtoupper($extension) }}
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="card-body d-flex flex-column">
                                        <h6 class="mb-2 text-truncate" title="{{ $doc->document_name }}">
                                            {{ $doc->document_name }}
                                        </h6>
                                        <div class="mt-auto">
                                            @if ($isImage)
                                                <button class="btn btn-outline-primary btn-sm btn-block"
                                                    data-bs-toggle="modal" data-bs-target="#imageZoomModal"
                                                    data-bs-img-src="{{ $file }}">

                                                    <i class="fas fa-image mr-1"></i>
                                                    View Image
                                                </button>
                                            @else
                                                <a href="{{ $file }}" target="_blank"
                                                    class="btn btn-outline-danger btn-sm btn-block">
                                                    <i class="fas fa-file-pdf mr-1"></i>
                                                    Preview
                                                </a>
                                            @endif
                                        </div>

                                    </div>

                                </div>

                            </div>
                        @endforeach

                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-folder-open"></i>
                        <span> No referred documents available </span>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endif
