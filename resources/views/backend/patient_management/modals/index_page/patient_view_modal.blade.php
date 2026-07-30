<!-- Bootstrap 5 Patient Detail Modal -->
<div class="modal fade" id="patientViewModal" tabindex="-1" aria-labelledby="patientViewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">

            {{-- Header --}}
            <div class="modal-header bg-primary text-white border-0 py-3"
                style="border-top-left-radius: 16px; border-top-right-radius: 16px;">
                <h5 class="modal-title d-flex align-items-center" id="patientViewModalLabel" style="font-weight: 600;">
                    <i class="fas fa-id-card mr-2"></i> Patient Complete Profile
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
                    style="filter: invert(1) grayscale(100%) brightness(200%); border: none; background: transparent; font-size: 1.5rem; line-height: 1;">&times;</button>
            </div>

            {{-- Body --}}
            {{-- ========================= Modal Body ========================= --}}
            <div class="modal-body p-4" style="background-color:#f8fafc; max-height:80vh; overflow-y:auto;">

                {{-- ========================= Patient Information ========================= --}}
                <div class="card border-0 shadow-sm mb-4" style="border-radius:12px; overflow:hidden;">

                    <div class="card-header bg-white border-0 py-3">
                        <h6 class="mb-0 text-primary font-weight-bold">
                            <i class="fas fa-user-injured mr-2"></i>
                            Patient Information
                        </h6>
                    </div>

                    <div class="card-body bg-white">

                        <div class="row align-items-start">

                            <div class="col-lg-3 text-center mb-3">

                                <img id="viewModalPhoto" src="/uploads/images/default.jpg"
                                    class="img-fluid rounded-circle border shadow-sm"
                                    style="width:160px;
                               height:160px;
                               object-fit:cover;
                               background:#f1f5f9;">

                            </div>

                            <div class="col-lg-9">

                                <div class="row" id="viewPatientInfoContainer">
                                    {{-- Loaded by patient_summary_info.js --}}
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                {{-- ========================= Emergency ========================= --}}
                <div id="viewPatientEmergencyContainer">
                    {{-- Loaded by patient_summary_info.js --}}
                </div>

                {{-- ========================= Treatment ========================= --}}
                <div id="viewPatientTreatmentContainer">
                    {{-- Loaded by patient_summary_treatment.js --}}
                </div>

                {{-- ========================= Investigation ========================= --}}
                <div id="viewPatientInvestigationContainer">
                    {{-- Loaded by patient_summary_investigation.js --}}
                </div>

                {{-- ========================= Referred Documents ========================= --}}
                <div class="card border-0 shadow-sm mb-4" style="border-radius:12px; overflow:hidden;">

                    <div class="card-header bg-white border-0 py-3">

                        <h6 class="mb-0 text-success font-weight-bold">

                            <i class="fas fa-file-medical mr-2"></i>

                            Referred Documents

                        </h6>

                    </div>

                    <div class="card-body bg-white">

                        <div class="row" id="viewPatientDocsContainer">
                            {{-- Loaded by patient_summary_cancer.js --}}
                        </div>

                    </div>

                </div>

                {{-- ========================= Cancer & X-Ray Reports ========================= --}}
                <div class="card border-0 shadow-sm" style="border-radius:12px; overflow:hidden;">

                    <div class="card-header bg-white border-0 py-3">

                        <h6 class="mb-0 text-danger font-weight-bold">

                            <i class="fas fa-images mr-2"></i>

                            Cancer & X-Ray Reports

                        </h6>

                    </div>

                    <div class="card-body bg-white">

                        <div class="row" id="viewPatientCancerPhotosContainer">
                            {{-- Loaded by patient_summary_cancer.js --}}
                        </div>

                    </div>

                </div>

            </div>

            {{-- Footer --}}
            <div class="modal-footer border-0 bg-light py-3"
                style="border-bottom-left-radius: 16px; border-bottom-right-radius: 16px;">
                <button type="button" class="btn btn-secondary px-4 shadow-sm" data-bs-dismiss="modal"
                    style="border-radius: 8px;">Close</button>
            </div>

        </div>
    </div>
</div>
