<div class="modal fade" id="patientSummaryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content shadow-lg border-0" style="border-radius: 12px;">

            {{-- Header --}}
            <div class="modal-header bg-primary text-white py-3">
                <h5 class="modal-title font-weight-bold">
                    <i class="fas fa-user-md mr-2"></i>
                    Patient Summary Assistant
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>

            {{-- Body --}}
            <div class="modal-body p-0">
                <div class="row no-gutters">

                    {{-- =========================
                    CHAT PANEL (LEFT)
                    ========================== --}}
                    <div class="col-lg-5 border-right">
                        <div class="bg-light border-bottom p-3">
                            <strong>
                                <i class="fas fa-comments text-primary"></i>
                                Conversation
                            </strong>
                        </div>
                        <div id="patientSummaryChat"
                            style="
                                height:600px;
                                overflow-y:auto;
                                background:#f8f9fa;
                                padding:20px;
                            ">
                            {{-- Welcome --}}
                            <div class="mb-3">
                                <div class="alert alert-primary mb-0">
                                    👋 Welcome.
                                    <br><br>
                                    Search by
                                    <ul class="mb-0 mt-2">
                                        <li>Patient Name</li>
                                        <li>Patient Code</li>
                                        <li>Phone Number</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        {{-- Typing --}}
                        <div id="patientTyping" class="px-3 pb-2 small text-muted d-none">
                            <i class="fas fa-spinner fa-spin"></i>
                            Searching patient...
                        </div>

                        {{-- Search Input block --}}
                        <div class="border-top p-3">
                            <div class="input-group">
                                <input type="text" id="patientSummarySearch" class="form-control"
                                    placeholder="Search patient...">
                                <div class="input-group-append">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-outline-success" id="patientPhotoBtn"
                                            title="Search Patient by Photo">

                                            <i class="fas fa-camera"></i>

                                        </button>

                                        <input type="file" id="patientPhotoInput" accept=".jpg,.jpeg,.png,.webp"
                                            hidden>
                                        {{-- Search by Recommendation Document --}}
                                        <button type="button" class="btn btn-outline-info" id="patientDocumentBtn"
                                            title="Search Patient by Recommendation Document" data-toggle="tooltip"
                                            data-placement="top">

                                            <i class="fas fa-file-medical mr-1"></i>

                                            <span class="d-none d-md-inline">
                                                Document
                                            </span>

                                        </button>

                                    </div>

                                    <input type="file" id="patientDocumentInput" accept=".pdf,.jpg,.jpeg,.png,.webp"
                                        hidden>
                                    <button class="btn btn-primary" id="patientSummarySearchBtn">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- =========================
                    RIGHT PANEL WITH NAV TABS
                    ========================== --}}
                    <div class="col-lg-7 d-flex flex-column" style="height: 694px;">

                        <!-- Tabs Header (Top Left Navigation) -->
                        <ul class="nav nav-tabs border-bottom px-3 pt-2 bg-light" id="patientSummaryTabs"
                            role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active font-weight-bold" id="results-tab" data-toggle="tab"
                                    data-bs-toggle="tab" href="#results-tab-pane" role="tab"
                                    aria-controls="results-tab-pane" aria-selected="true"
                                    style="border-top-left-radius: 8px; border-top-right-radius: 8px;">
                                    <i class="fas fa-search-plus mr-1"></i> Original
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" data-bs-toggle="tab"
                                    href="#profile-tab-pane" role="tab" aria-controls="profile-tab-pane"
                                    aria-selected="false" title="Patient Profile details"
                                    style="border-top-left-radius: 8px; border-top-right-radius: 8px; padding: 10px 18px;">
                                    <i class="fas fa-user text-muted"></i>
                                </a>
                            </li>
                        </ul>

                        <!-- Tabs Content Container -->
                        <div class="tab-content flex-grow-1 overflow-auto bg-white">

                            <!-- Tab Pane 1: Default UI Search Results -->
                            <div class="tab-pane fade show active p-3" id="results-tab-pane" role="tabpanel"
                                aria-labelledby="results-tab">
                                <div id="patientSearchResult">
                                    <div class="text-muted">
                                        Search results will appear here.
                                    </div>
                                </div>
                            </div>

                            <!-- Tab Pane 2: Patient Profile Details (Hidden under Profile icon tab) -->
                            <div class="tab-pane fade p-3" id="profile-tab-pane" role="tabpanel"
                                aria-labelledby="profile-tab">
                                <div id="patientSummaryDetail"
                                    style="
                                        height:500px;
                                        overflow-y:auto;
                                    ">
                                    <div class="text-center text-muted mt-5">
                                        <i class="fas fa-user-injured fa-4x mb-3"></i>
                                        <h5>No Patient Selected</h5>
                                        <p>Search and select a patient to view the complete summary.</p>
                                    </div>
                                </div>
                            </div>

                        </div>

                        {{-- Yes / No Action Confirm Block --}}
                        <div id="patientSummaryAction" class="border-top p-3 bg-light">
                            <div class="mb-2 font-weight-bold">
                                Search another patient?
                            </div>
                            <button class="btn btn-success btn-sm px-3 mr-2" id="patientSearchAgain">
                                Yes
                            </button>
                            <button class="btn btn-secondary btn-sm px-3" id="patientSummaryClose">
                                No
                            </button>
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
