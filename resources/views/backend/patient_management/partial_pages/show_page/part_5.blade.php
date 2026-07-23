@if ($patient->is_treatment)

    <div class="patient-section-card recommendation-card">

        <div class="patient-section-header recommendation-header">

            <div class="section-icon danger">

                <i class="fas fa-procedures"></i>

            </div>

            <div>

                <h5 class="mb-0">
                    Treatment Information
                </h5>

                <small>
                    Patient treatment history and medical records
                </small>

            </div>

        </div>

        <div class="patient-section-body">

            <div class="row">

                <div class="col-md-6 mb-3">

                    <div class="recommendation-detail">

                        <span>

                            <i class="fas fa-hospital mr-1"></i>

                            Treatment Type

                        </span>

                        <strong>

                            {{ $patient->treatment_type ?: 'N/A' }}

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

                            Treatment Available

                        </strong>

                    </div>

                </div>

            </div>

            <div class="medical-note-box mb-4">

                <div class="medical-note-title">

                    <i class="fas fa-notes-medical mr-1"></i>

                    Treatment Information

                </div>

                <div class="medical-note-content">

                    {!! $patient->treatment_information ?: '<span class="text-muted">No treatment information available.</span>' !!}

                </div>

            </div>

            <div>

                <div class="documents-title mb-3">

                    <i class="fas fa-images mr-1"></i>

                    Treatment Images

                </div>

                @if (!empty($patient->treatment_images))

                    <div class="row">

                        @foreach ($patient->treatment_images as $image)
                            <div class="col-lg-3 col-md-4 col-6 mb-3">

                                <a href="#" data-bs-toggle="modal" data-bs-target="#imageZoomModal"
                                    data-bs-img-src="{{ asset($image) }}" class="text-decoration-none">

                                    <img src="{{ asset($image) }}" class="img-fluid rounded shadow border magnify-img"
                                        style="height:180px;width:100%;object-fit:contain;">

                                </a>

                            </div>
                        @endforeach

                    </div>
                @else
                    <div class="empty-state">

                        <i class="fas fa-image"></i>

                        <span>

                            No treatment images available

                        </span>

                    </div>

                @endif

            </div>

        </div>

    </div>

@endif
