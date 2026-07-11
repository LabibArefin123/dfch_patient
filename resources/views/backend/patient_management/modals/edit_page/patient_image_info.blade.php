<div class="modal fade" id="patientPhotoInfoModal" tabindex="-1" role="dialog" aria-labelledby="patientPhotoInfoModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="patientPhotoInfoModalLabel">
                    Patient Photo Information
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"
                    style="opacity:1;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 text-center mb-3">
                        <img src="{{ $patientImageUrl }}" alt="Patient Image" class="patient-photo-modal-preview">
                    </div>

                    <div class="col-md-6">
                        <table class="table table-bordered patient-photo-meta-table">
                            <tbody>
                                <tr>
                                    <td width="40%"><strong>Image Name</strong></td>
                                    <td>{{ $patientImageName }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Image Size</strong></td>
                                    <td>{{ $patientImageSize }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Dimensions</strong></td>
                                    <td>
                                        @if ($patientImageWidth && $patientImageHeight)
                                            {{ $patientImageWidth }} × {{ $patientImageHeight }} px
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Image Type</strong></td>
                                    <td>{{ strtoupper($patientImageExtension ?: 'N/A') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>MIME Type</strong></td>
                                    <td>{{ $patientImageMime ?: 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Orientation</strong></td>
                                    <td>{{ $patientImageOrientation }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Shape / Format</strong></td>
                                    <td>{{ $patientImageAspectCategory }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Preview</strong></td>
                                    <td>
                                        <a href="{{ $patientImageUrl }}" target="_blank" class="btn btn-sm btn-primary">
                                            Open Full Image
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
