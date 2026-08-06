<div class="patient-section-card cancer-reports-section">
    <div class="patient-section-header cancer-header">
        <div class="section-icon danger">
            <i class="fas fa-x-ray"></i>
        </div>

        <div>
            <h5 class="mb-0">
                Cancer Reports
                <span class="badge badge-danger ml-2">{{ $patient->cancerPhotos->count() }}</span>
            </h5>
            <small>Cancer imaging reports and related findings</small>
        </div>
    </div>

    <div class="patient-section-body">
        @forelse($patient->cancerPhotos as $report)

            <div class="cancer-report-card">

                {{-- Report Header --}}
                <div class="cancer-report-header">
                    <div>
                        <span class="report-label">Cancer Report</span>
                        <h6 class="mb-0">Report #{{ $loop->iteration }}</h6>
                    </div>

                    <span class="report-date">
                        <i class="far fa-calendar-alt mr-1"></i>
                        {{ optional($report->created_at)->format('d M Y') }}
                    </span>
                </div>

                {{-- Total Cancer --}}
                <div class="row mb-4">

                    <div class="col-lg-3 col-md-4 mb-3">
                        <div class="cancer-stat-card">
                            <span>Total Cancer</span>
                            <strong>{{ $report->total_cancer }}</strong>
                        </div>
                    </div>

                    {{-- Remarks --}}
                    <div class="col-lg-9 col-md-8">
                        <div class="report-remarks">
                            <span>Remarks</span>

                            @if (!empty($report->cancer_remarks))
                                <div class="mt-2">
                                    {!! $report->cancer_remarks !!}
                                </div>
                            @else
                                <p class="text-muted mb-0">
                                    No remarks available.
                                </p>
                            @endif
                        </div>
                    </div>

                </div>

                {{-- X-Ray Images --}}
                @php
                    $photos = is_array($report->xray_photo) ? $report->xray_photo : [];
                @endphp

                @if (count($photos))
                    <h6 class="font-weight-bold mb-3">
                        <i class="fas fa-images text-danger mr-1"></i>
                        X-Ray Images
                    </h6>

                    <div class="row">

                        @foreach ($photos as $photo)
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-4">

                                <div class="card shadow-sm border-0 h-100">

                                    <img src="{{ asset($photo) }}" class="card-img-top"
                                        style="height:250px;object-fit:contain;" alt="X-Ray Image">

                                    <div class="card-footer bg-white text-center">

                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                            data-bs-toggle="modal" data-bs-target="#imageZoomModal"
                                            data-bs-img-src="{{ asset($photo) }}">

                                            <i class="fas fa-eye"></i>
                                            View Full Image

                                        </button>

                                    </div>

                                </div>

                            </div>
                        @endforeach

                    </div>
                @endif

                {{-- X-Ray Description --}}
                <div class="report-remarks mt-3">

                    <span>X-Ray Description</span>

                    @if (!empty($report->xray_description))
                        <div class="mt-2">
                            {!! $report->xray_description !!}
                        </div>
                    @else
                        <p class="text-muted mb-0">
                            No X-Ray description available.
                        </p>
                    @endif

                </div>

            </div>

        @empty

            <div class="empty-state cancer-empty-state">
                <i class="fas fa-file-medical-alt"></i>

                <strong>No cancer reports found</strong>

                <span>This patient currently has no cancer imaging records.</span>
            </div>

        @endforelse
    </div>
</div>
