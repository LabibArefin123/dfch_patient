<!-- ==========================================
     Left Panel
     - Form Progress
     - Emergency Information
========================================== -->
<div class="col-lg-7">

    <!-- Form Progress -->
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <div class="row align-items-center">

                <!-- Progress Circle -->
                <div class="col-md-4 text-center">

                    <div id="emergencyProgressCircle" class="emergency-progress-circle">

                        <span id="emergencyProgressValue">

                            0%

                        </span>

                    </div>

                    <div class="mt-3">

                        <h6 class="mb-1">

                            Form Progress

                        </h6>

                        <small class="text-muted">

                            Complete all required fields.

                        </small>

                    </div>

                </div>

                <!-- Progress Checklist -->
                <div class="col-md-8">

                    <div class="mb-3">

                        <div class="d-flex justify-content-between align-items-center">

                            <span>

                                Selected Patients

                            </span>

                            <i id="progressPatientIcon" class="fas fa-times-circle text-danger"></i>

                        </div>

                    </div>

                    <div class="mb-3">

                        <div class="d-flex justify-content-between align-items-center">

                            <span>

                                Emergency Status

                            </span>

                            <i id="progressStatusIcon" class="fas fa-times-circle text-danger"></i>

                        </div>

                    </div>

                    <div>

                        <div class="d-flex justify-content-between align-items-center">

                            <span>

                                Reason / Notes

                            </span>

                            <i id="progressReasonIcon" class="fas fa-minus-circle text-secondary"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- Emergency Information -->
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-light">

            <h6 class="mb-0">

                <i class="fas fa-ambulance text-danger me-2"></i>

                Emergency Information

            </h6>

        </div>

        <div class="card-body">

            <!-- Emergency Status -->
            <div class="mb-4">

                <label for="isEmergency" class="form-label fw-semibold">

                    Emergency Status <span class="text-danger">*</span>

                </label>

                <select id="isEmergency" name="is_emergency" class="form-select">

                    <option value="">

                        Select Emergency Status

                    </option>

                    <option value="1">

                        🔴 Emergency

                    </option>

                    <option value="0">

                        🟢 Normal

                    </option>

                </select>

            </div>

            <!-- Reason -->
            <div>

                <label class="form-label fw-semibold">

                    Reason / Notes

                </label>

                <textarea name="reason" rows="7" class="form-control"
                    placeholder="Write the reason for changing emergency status..."></textarea>

                <div class="form-text">

                    This note will be saved in the patient's emergency history.

                </div>

            </div>

        </div>

    </div>

</div>
