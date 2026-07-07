<div class="modal fade" id="patientSummaryModal" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">

        <div class="modal-content shadow-lg">

            {{-- Header --}}
            <div class="modal-header bg-primary text-white">

                <h5 class="modal-title">

                    <i class="fas fa-user-md mr-2"></i>

                    Patient Summary Assistant

                </h5>

                <button type="button" class="close text-white" data-dismiss="modal">

                    <span>&times;</span>

                </button>

            </div>

            {{-- Body --}}
            <div class="modal-body p-0">

                <div class="row no-gutters">

                    {{-- =========================
                    CHAT
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

                        {{-- Search --}}
                        <div class="border-top p-3">

                            <div class="input-group">

                                <input type="text" id="patientSummarySearch" class="form-control"
                                    placeholder="Search patient...">

                                <div class="input-group-append">

                                    <button class="btn btn-primary" id="patientSummarySearchBtn">

                                        <i class="fas fa-search"></i>

                                    </button>

                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- =========================
                    RIGHT PANEL
                    ========================== --}}
                    <div class="col-lg-7">

                        {{-- Search Result --}}
                        <div id="patientSearchResult" class="border-bottom p-3">

                            <div class="text-muted">

                                Search results will appear here.

                            </div>

                        </div>

                        {{-- Patient Detail --}}
                        <div id="patientSummaryDetail"
                            style="
                                height:520px;
                                overflow-y:auto;
                                padding:20px;
                            ">

                            <div class="text-center text-muted mt-5">

                                <i class="fas fa-user-injured fa-4x mb-3">
                                </i>

                                <h5>

                                    No Patient Selected

                                </h5>

                                <p>

                                    Search and select a patient
                                    to view the complete summary.

                                </p>

                            </div>

                        </div>

                        {{-- Yes / No --}}
                        <div id="patientSummaryAction" class="border-top p-3 d-none">

                            <div class="mb-2">

                                Search another patient?

                            </div>

                            <button class="btn btn-success btn-sm" id="patientSearchAgain">

                                Yes

                            </button>

                            <button class="btn btn-secondary btn-sm" id="patientSummaryClose">

                                No

                            </button>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
