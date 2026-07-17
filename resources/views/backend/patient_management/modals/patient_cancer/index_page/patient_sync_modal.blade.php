{{-- ============================================================
    Cancer Patient Synchronization Modal
============================================================ --}}

<div class="modal fade" id="cancerPatientSyncModal" tabindex="-1" role="dialog" aria-labelledby="syncModalTitle"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content border-0 shadow-lg">

            {{-- Header --}}
            <div class="modal-header border-0">

                <h5 class="modal-title">

                    <i class="fas fa-sync-alt text-primary mr-2" id="syncModalIcon"></i>

                    <span id="syncModalTitle">
                        Synchronizing Cancer Patients
                    </span>

                </h5>

                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">
                        &times;
                    </span>

                </button>

            </div>


            {{-- Body --}}
            <div class="modal-body text-center">

                {{-- Animation --}}
                <div id="syncAnimation" class="mb-4">

                    <div class="sync-spinner">

                        <i class="fas fa-dna"></i>

                    </div>

                </div>


                {{-- Status --}}
                <h5 id="syncStatusText" class="font-weight-bold">

                    Preparing synchronization...

                </h5>


                {{-- Description --}}
                <p id="syncDescription" class="text-muted mb-3">

                    Please wait while cancer patients are being synchronized.

                </p>


                {{-- Progress --}}
                <div class="progress" style="height: 8px;">

                    <div id="syncProgressBar" class="progress-bar progress-bar-striped progress-bar-animated"
                        role="progressbar" style="width: 0%;">

                    </div>

                </div>


                {{-- Counter --}}
                <div id="syncCounter" class="mt-3 text-muted">

                    Starting...

                </div>

            </div>


            {{-- Footer --}}
            <div id="syncModalFooter" class="modal-footer border-0 justify-content-center">

                <button type="button" class="btn btn-secondary d-none" data-bs-dismiss="modal" id="syncCloseBtn">

                    Close

                </button>

            </div>

        </div>

    </div>

</div>
