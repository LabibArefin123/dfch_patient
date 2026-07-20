<div class="patient-section-card cancer-reports-section">

    <div class="patient-section-header cancer-header">

        <div class="section-icon danger">

            <i class="fas fa-x-ray"></i>

        </div>

        <div>

            <h5 class="mb-0">

                Cancer Reports

                <span class="badge badge-danger ml-2">

                    {{ $patient->cancerPhotos->count() }}

                </span>

            </h5>

            <small>
                Cancer imaging reports and related findings
            </small>

        </div>

    </div>


    <div class="patient-section-body">

        @forelse ($patient->cancerPhotos as $report)

            <div class="cancer-report-card">

                <div class="cancer-report-header">

                    <div>

                        <span class="report-label">
                            Cancer Report
                        </span>

                        <h6 class="mb-0">

                            Report #{{ $loop->iteration }}

                        </h6>

                    </div>

                    <span class="report-date">

                        <i class="far fa-calendar-alt mr-1"></i>

                        {{ optional($report->created_at)->format('d M Y') }}

                    </span>

                </div>


                <div class="row mb-4">

                    <div class="col-md-4 mb-3 mb-md-0">

                        <div class="cancer-stat-card">

                            <span>
                                Total Cancer
                            </span>

                            <strong>
                                {{ $report->total_cancer }}
                            </strong>

                        </div>

                    </div>


                    <div class="col-md-8">

                        <div class="report-remarks">

                            <span>
                                Remarks
                            </span>

                            <p class="mb-0">

                                {{ $report->remarks ?: 'No remarks available' }}

                            </p>

                        </div>

                    </div>

                </div>


                @if (!empty($report->xray_photo))
                    <div class="cancer-image-grid">

                        @foreach ($report->xray_photo as $index => $photo)
                            <div class="cancer-image-card">

                                <a href="{{ asset($photo) }}" target="_blank" class="cancer-image-link">

                                    <img src="{{ asset($photo) }}" alt="Cancer Report Image"
                                        class="cancer-report-image">

                                    <div class="image-overlay">

                                        <i class="fas fa-search-plus"></i>

                                    </div>

                                </a>


                                <div class="cancer-image-description">

                                    <small>
                                        Image Description
                                    </small>

                                    <p class="mb-0">

                                        {{ $report->xray_description[$index] ?? 'N/A' }}

                                    </p>

                                </div>

                            </div>
                        @endforeach

                    </div>
                @endif

            </div>

        @empty

            <div class="empty-state cancer-empty-state">

                <i class="fas fa-file-medical-alt"></i>

                <strong>
                    No cancer reports found
                </strong>

                <span>
                    This patient currently has no cancer imaging records.
                </span>

            </div>

        @endforelse

    </div>

</div>
