<!-- ==========================================
     Submit Progress Modal
========================================== -->
<div class="modal fade" id="submitProgressModal" tabindex="-1" aria-labelledby="submitProgressModalLabel" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">

    <div class="modal-dialog modal-dialog-centered modal-sm">

        <div class="modal-content border-0 shadow">

            <div class="modal-body text-center py-5">

                <!-- Loading Spinner -->
                <div class="spinner-border text-danger mb-4" role="status" style="width:70px;height:70px;">

                    <span class="visually-hidden">

                        Loading...

                    </span>

                </div>

                <!-- Title -->
                <h5 id="submitProgressModalLabel" class="fw-bold mb-2">

                    Saving Emergency Status

                </h5>

                <p id="submitProgressText" class="text-muted mb-4">

                    Preparing request...

                </p>

                <!-- Progress Bar -->
                <div class="progress" style="height:18px;">

                    <div id="submitProgressBar"
                        class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar"
                        style="width:0%;" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">

                    </div>

                </div>

                <!-- Percentage -->
                <div id="submitProgressPercent" class="fw-bold fs-5 mt-3">

                    0%

                </div>

            </div>

        </div>

    </div>

</div>
