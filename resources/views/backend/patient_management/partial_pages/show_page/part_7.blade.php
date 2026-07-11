<div class="card mt-4">
    <div class="card-header bg-danger text-white">
        <h5 class="mb-0">
            <i class="fas fa-x-ray"></i>
            Cancer Reports
            <span class="badge badge-light">
                {{ $patient->cancerPhotos->count() }}
            </span>
        </h5>
    </div>

    <div class="card-body">
        @forelse($patient->cancerPhotos as $report)
            <div class="border rounded p-3 mb-4">
                <div class="row mb-3">
                    <div class="col-md-3">
                        <strong>Total Cancer</strong>

                        <div class="form-control bg-light">
                            {{ $report->total_cancer }}
                        </div>
                    </div>

                    <div class="col-md-9">
                        <strong>Remarks</strong>
                        <div class="form-control bg-light" style="min-height:60px">
                            {{ $report->remarks ?: 'N/A' }}
                        </div>
                    </div>
                </div>

                @if (!empty($report->xray_photo))
                    <div class="row">
                        @foreach ($report->xray_photo as $index => $photo)
                            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                <div class="card h-100">
                                    <a href="{{ asset($photo) }}" target="_blank">

                                        <img src="{{ asset($photo) }}" class="card-img-top img-fluid"
                                            style="height:220px;object-fit:cover;">

                                    </a>

                                    <div class="card-body">
                                        <strong>Description</strong>
                                        <p class="mb-0">
                                            {{ $report->xray_description[$index] ?? 'N/A' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @empty
            <div class="alert alert-warning mb-0">
                No cancer reports found for this patient.
            </div>
        @endforelse
    </div>
</div>
