<div class="modal fade" id="patientEmergencyModal" tabindex="-1" aria-labelledby="patientEmergencyModalLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-xl modal-dialog-centered">

        <form id="patientEmergencyForm" class="w-100">

            @csrf

            <input type="hidden" id="selectedPatients">

            <div class="modal-content border-0 shadow">

                <!-- Header -->
                <div class="modal-header bg-danger text-white">

                    <div>

                        <h4 class="modal-title mb-1" id="patientEmergencyModalLabel">
                            <i class="fas fa-ambulance me-2"></i>
                            Emergency Patient Management
                        </h4>

                        <small class="opacity-75">
                            Update emergency status for selected patients.
                        </small>

                    </div>

                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal">
                    </button>

                </div>

                <!-- Body -->
                <div class="modal-body">

                    <div class="row g-4">

                        <!-- LEFT -->
                        <div class="col-lg-7">

                            <div class="card shadow-sm border-0 h-100">

                                <div class="card-header bg-light">

                                    <h6 class="mb-0">
                                        <i class="fas fa-edit text-danger me-2"></i>
                                        Emergency Information
                                    </h6>

                                </div>

                                <div class="card-body">

                                    <div class="mb-4">

                                        <label class="form-label fw-semibold">

                                            Emergency Status

                                        </label>

                                        <select class="form-select" id="isEmergency" name="is_emergency">

                                            <option value="1">
                                                🔴 Emergency
                                            </option>

                                            <option value="0">
                                                🟢 Normal
                                            </option>

                                        </select>

                                    </div>

                                    <div>

                                        <label class="form-label fw-semibold">

                                            Reason / Notes

                                        </label>

                                        <textarea class="form-control" name="reason" rows="8"
                                            placeholder="Explain why these patients are being marked as emergency..."></textarea>

                                        <div class="form-text">

                                            This information will be saved in the emergency history.

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <!-- RIGHT -->
                        <div class="col-lg-5">

                            <div class="card shadow-sm border-danger h-100">

                                <div
                                    class="card-header bg-danger text-white d-flex justify-content-between align-items-center">

                                    <div>

                                        <i class="fas fa-users me-2"></i>

                                        Selected Patients

                                    </div>

                                    <span class="badge bg-light text-danger" id="selectedPatientBadge">

                                        0

                                    </span>

                                </div>

                                <div class="card-body d-flex flex-column">

                                    <div class="alert alert-light border">

                                        <strong id="selectedPatientCount">0</strong>

                                        patient(s) selected

                                    </div>

                                    <div id="selectedPatientList" class="border rounded bg-light flex-grow-1 p-2"
                                        style="min-height:320px;max-height:420px;overflow-y:auto;">

                                        <div class="text-center text-muted pt-5">

                                            <i class="fas fa-user-slash fa-3x mb-3"></i>

                                            <p class="mb-0">

                                                No patients selected.

                                            </p>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- Footer -->
                <div class="modal-footer">

                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">

                        <i class="fas fa-times me-1"></i>

                        Cancel

                    </button>

                    <button class="btn btn-danger" type="submit">

                        <i class="fas fa-save me-2"></i>

                        Save Emergency Status

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>
