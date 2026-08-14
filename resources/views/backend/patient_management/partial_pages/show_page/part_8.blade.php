<div class="patient-section-card cancer-reports-section">

    {{-- Section Header --}}
    <div class="patient-section-header cancer-header">
        <div class="section-icon danger">
            <i class="fas fa-x-ray"></i>
        </div>

        <div class="flex-grow-1">
            <h5 class="mb-1">
                Cancer Reports
                <span class="badge badge-danger ml-2">
                    {{ $patient->cancerPhotos->count() }}
                </span>
            </h5>

            <small class="text-muted">
                Diagnostic imaging, cancer findings and clinical observations
            </small>
        </div>
    </div>

    <div class="patient-section-body">

        @forelse($patient->cancerPhotos as $report)

            @php
                $photos = is_array($report->xray_photo) ? $report->xray_photo : [];

                $xrayDescription = $report->xray_description;
                $cancerRemarks = $report->cancer_remarks;

                if (!empty($xrayDescription)) {
                    $decoded = json_decode($xrayDescription, true);

                    $xrayDescription = is_array($decoded) ? $decoded['content'] ?? '' : $xrayDescription;
                }

                if (!empty($cancerRemarks)) {
                    $decoded = json_decode($cancerRemarks, true);

                    $cancerRemarks = is_array($decoded) ? $decoded['content'] ?? '' : $cancerRemarks;
                }
            @endphp

            <div class="cancer-report-card">

                {{-- Report Header --}}
                <div class="cancer-report-header">

                    <div>
                        <span class="report-label">
                            <i class="fas fa-file-medical-alt mr-1"></i>
                            Cancer Report
                        </span>

                        <h6 class="mb-0 mt-1">
                            Report #{{ $loop->iteration }}
                        </h6>
                    </div>

                    <div class="text-right">

                        <span class="report-date d-block">
                            <i class="far fa-calendar-alt mr-1"></i>
                            {{ optional($report->created_at)->format('d M Y') }}
                        </span>

                        @if ($report->updated_at && $report->updated_at != $report->created_at)
                            <small class="text-muted">
                                Updated {{ $report->updated_at->format('d M Y') }}
                            </small>
                        @endif

                    </div>

                </div>


                {{-- Report Summary --}}
                <div class="row mb-4">

                    {{-- Total Cancer --}}
                    <div class="col-lg-3 col-md-4 mb-3">

                        <div class="cancer-stat-card">

                            <span>
                                <i class="fas fa-ribbon text-danger mr-1"></i>
                                Total Cancer
                            </span>

                            <strong>
                                {{ $report->total_cancer ?? 0 }}
                            </strong>

                            <small class="text-muted d-block mt-1">
                                Recorded cancer count
                            </small>

                        </div>

                    </div>


                    {{-- Report Status --}}
                    <div class="col-lg-12 col-md-8 mb-3">

                        <div class="report-remarks h-100">

                            <span>
                                <i class="fas fa-notes-medical text-danger mr-1"></i>
                                Clinical Remarks
                            </span>

                            @if (!empty($cancerRemarks))
                                <div class="mt-2">
                                    {!! $cancerRemarks !!}
                                </div>
                            @else
                                <p class="text-muted mb-0 mt-2">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    No clinical remarks were recorded for this report.
                                </p>
                            @endif

                        </div>

                    </div>

                </div>


                {{-- X-Ray / CT Images --}}
                @if (count($photos))
                    <div class="section-divider my-3"></div>

                    <div class="d-flex align-items-center mb-3">

                        <div class="mr-2 text-danger">
                            <i class="fas fa-images"></i>
                        </div>

                        <div>
                            <h6 class="mb-0 font-weight-bold">
                                Diagnostic Images
                            </h6>

                            <small class="text-muted">
                                {{ count($photos) }}
                                {{ count($photos) === 1 ? 'image' : 'images' }}
                                attached to this report
                            </small>
                        </div>

                    </div>


                    <div class="row">

                        @foreach ($photos as $photo)
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-4">

                                <div class="card shadow-sm border-0 h-100">

                                    <div class="card-body p-2">

                                        <a href="#" data-bs-toggle="modal" data-bs-target="#imageZoomModal"
                                            data-bs-img-src="{{ asset($photo) }}" class="d-block">

                                            <img src="{{ asset($photo) }}" class="img-fluid w-100"
                                                style="height:250px;object-fit:contain;" alt="Cancer Diagnostic Image">

                                        </a>

                                    </div>

                                    <div class="card-footer bg-white border-0 text-center pt-0">

                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                            data-bs-toggle="modal" data-bs-target="#imageZoomModal"
                                            data-bs-img-src="{{ asset($photo) }}">

                                            <i class="fas fa-search-plus mr-1"></i>
                                            View Full Image

                                        </button>

                                    </div>

                                </div>

                            </div>
                        @endforeach

                    </div>
                @else
                    <div class="alert alert-light border">
                        <i class="fas fa-image text-muted mr-1"></i>
                        No diagnostic images are attached to this report.
                    </div>
                @endif


                {{-- X-Ray / CT Findings --}}
                <div class="section-divider my-3"></div>

                <div class="report-remarks">

                    <span>
                        <i class="fas fa-file-medical-alt text-danger mr-1"></i>
                        X-Ray / CT Scan Findings
                    </span>

                    @if (!empty($xrayDescription))
                        <div class="mt-2">
                            {!! $xrayDescription !!}
                        </div>
                    @else
                        <p class="text-muted mb-0 mt-2">
                            <i class="fas fa-info-circle mr-1"></i>
                            No X-Ray or CT scan findings were recorded.
                        </p>
                    @endif

                </div>


            </div>

        @empty

            {{-- Empty State --}}
            <div class="empty-state cancer-empty-state text-center">

                <i class="fas fa-file-medical-alt"></i>

                <strong class="d-block mt-2">
                    No Cancer Reports Found
                </strong>

                <span class="text-muted">
                    This patient currently has no cancer imaging or diagnostic records.
                </span>

            </div>

        @endforelse

    </div>
</div>
