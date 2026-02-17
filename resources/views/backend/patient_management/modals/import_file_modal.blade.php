<div class="modal fade" id="importFileModal" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form id="importFileForm" method="POST" enctype="multipart/form-data" class="w-100">
            @csrf
            <div class="modal-content p-0 overflow-hidden">

                <div class="row g-0">

                    <!-- LEFT SIDE -->
                    <div class="col-md-6 bg-light d-flex align-items-center justify-content-center p-4">

                        <label for="importFileInput"
                            class="w-100 border border-2 border-primary rounded text-center p-5 cursor-pointer"
                            style="border-style: dashed; transition: 0.3s;">

                            <div class="mb-3">
                                <i class="fas fa-file-excel fa-3x text-success"></i> / <i class="fas fa-file-word fa-3x text-info"></i>
                            </div>

                            <h5 class="fw-bold mb-2">Upload Excel File/Upload Word File</h5>
                            <p class="text-muted small mb-0">
                                Click here to select file
                            </p>

                            <input type="file" name="file" id="importFileInput" class="d-none" accept=".xlsx,.xls"
                                required>
                        </label>

                    </div>

                    <!-- RIGHT SIDE -->
                    <div class="col-md-6 d-flex flex-column justify-content-center p-5">

                        <h4 id="importModalTitle" class="mb-4">
                            Import Patients
                        </h4>

                        <div class="d-grid gap-3">

                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-upload me-2"></i> Upload
                            </button>

                            <button type="button" class="btn btn-secondary btn-lg" data-bs-dismiss="modal">
                                Cancel
                            </button>

                        </div>

                        <!-- Progress -->
                        <div class="mt-5 text-center">

                            <div class="position-relative d-inline-block">
                                <svg width="120" height="120">
                                    <circle cx="60" cy="60" r="52" stroke="#e6e6e6" stroke-width="10"
                                        fill="none" />
                                    <circle id="importProgressCircle" cx="60" cy="60" r="52"
                                        stroke="#007bff" stroke-width="10" fill="none" stroke-dasharray="327"
                                        stroke-dashoffset="327" stroke-linecap="round" transform="rotate(-90 60 60)" />
                                </svg>
                                <div class="position-absolute w-100 h-100 d-flex align-items-center justify-content-center"
                                    style="top:0; left:0;">
                                    <span id="importProgressPercent"
                                        style="font-size: 20px; font-weight: bold;">0%</span>
                                </div>
                            </div>

                            <p id="importProgressText" class="mt-3 text-muted fw-bold">
                                Waiting for upload...
                            </p>

                        </div>

                    </div>

                </div>

            </div>
        </form>
    </div>
</div>
