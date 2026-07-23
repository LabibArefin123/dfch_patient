@if ($patient->is_investigated)

    <div class="patient-section-card recommendation-card">

        <div class="patient-section-header recommendation-header">

            <div class="section-icon info">

                <i class="fas fa-microscope"></i>

            </div>

            <div>

                <h5 class="mb-0">
                    Investigation Information
                </h5>

                <small>
                    Diagnostic reports and investigation records
                </small>

            </div>

        </div>

        <div class="patient-section-body">

            <div class="row">

                <div class="col-md-6 mb-3">

                    <div class="recommendation-detail">

                        <span>

                            <i class="fas fa-vial mr-1"></i>

                            Investigation Type

                        </span>

                        <strong>

                            {{ $patient->investigation_type ?: 'N/A' }}

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

                            Investigation Available

                        </strong>

                    </div>

                </div>

            </div>

            <div class="medical-note-box mb-4">

                <div class="medical-note-title">

                    <i class="fas fa-file-medical-alt mr-1"></i>

                    Investigation Information

                </div>

                <div class="medical-note-content">

                    {!! $patient->investigation_information ?:
                        '<span class="text-muted">No investigation information available.</span>' !!}

                </div>

            </div>

            <div>

                <div class="documents-title mb-3">

                    <i class="fas fa-images mr-1"></i>

                    Investigation Images

                </div>

                @if (!empty($patient->investigation_images))

                    <div class="row">

                        @foreach ($patient->investigation_images as $image)
                            <div class="col-lg-3 col-md-4 col-6 mb-3">

                                  <a href="#" data-bs-toggle="modal" data-bs-target="#imageZoomModal"
                                    data-bs-img-src="{{ asset($image) }}" class="text-decoration-none">

                                    <img src="{{ asset($image) }}" class="img-fluid rounded shadow border magnify-image"
                                        style="height:180px;width:100%;object-fit:contain;">

                                </a>

                            </div>
                        @endforeach

                    </div>
                @else
                    <div class="empty-state">

                        <i class="fas fa-image"></i>

                        <span>

                            No investigation images available

                        </span>

                    </div>

                @endif

            </div>

        </div>

    </div>

@endif
