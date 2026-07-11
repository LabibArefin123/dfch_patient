<div class="modal fade" id="patientAnimationModal" tabindex="-1">

    <div class="modal-dialog modal-xl modal-dialog-scrollable">

        <div class="modal-content border-0 shadow-lg" style="border-radius:16px; overflow:hidden;">

            {{-- Header --}}
            <div class="modal-header bg-primary text-white">

                <div class="d-flex align-items-center">

                    <div class="mr-3">

                        <div class="rounded-circle bg-white text-primary d-flex align-items-center justify-content-center shadow"
                            style="width:55px;height:55px;">

                            <i class="fas fa-robot fa-lg"></i>

                        </div>

                    </div>

                    <div>

                        <h4 class="mb-0 font-weight-bold">
                            DFCH Medical AI Assistant
                        </h4>

                        <small id="patientAIStatusText" class="text-white-50">
                            Initializing Medical Analysis...
                        </small>

                    </div>

                </div>

                <button type="button" class="close text-white ml-auto" data-dismiss="modal">

                    <span>&times;</span>

                </button>

            </div>

            {{-- Body --}}
            <div class="modal-body bg-light">

                {{-- Progress --}}
                <div class="card shadow-sm border-0 mb-4">

                    <div class="card-body">

                        <div class="d-flex justify-content-between mb-2">

                            <strong>
                                <i class="fas fa-microchip text-primary mr-1"></i>
                                AI Progress
                            </strong>

                            <span id="patientAIProgressPercent">
                                0%
                            </span>

                        </div>

                        <div class="progress" style="height:12px;border-radius:20px;">

                            <div id="patientAIProgressBar"
                                class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                style="width:0%;">

                            </div>

                        </div>

                    </div>

                </div>

                {{-- Timeline --}}
                <div id="patientAITimeline" class="mb-4">

                    <div class="alert alert-secondary border-0 shadow-sm mb-2">

                        <i class="fas fa-spinner fa-spin text-primary mr-2"></i>

                        Preparing AI engine...

                    </div>

                </div>

                {{-- Patient Photo --}}
                <div id="patientAnimationPhotoContainer">

                </div>

                {{-- Patient Information --}}
                <div id="patientAnimationInformationContainer">

                </div>

                {{-- Recommendation Documents --}}
                <div id="patientAnimationDocumentContainer">

                </div>

                {{-- Cancer Reports --}}
                <div id="patientAnimationCancerContainer">

                </div>

                {{-- Final Summary --}}
                <div id="patientAnimationFinishContainer">

                </div>

            </div>

            {{-- Footer --}}
            <div class="modal-footer bg-white">

                <div class="mr-auto text-muted">

                    <small>

                        <i class="fas fa-clock mr-1"></i>

                        Generated :
                        <span id="patientAISummaryGeneratedTime">

                            --

                        </span>

                    </small>

                </div>

                <button class="btn btn-secondary" data-dismiss="modal">

                    <i class="fas fa-times mr-1"></i>

                    Close

                </button>

            </div>

        </div>

    </div>

</div>
