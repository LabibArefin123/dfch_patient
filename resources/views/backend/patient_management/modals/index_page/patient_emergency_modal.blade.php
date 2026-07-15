<div class="modal fade" id="patientEmergencyModal" tabindex="-1">

    <div class="modal-dialog modal-dialog-centered modal-lg">

        <form id="patientEmergencyForm">

            @csrf

            <input type="hidden" id="selectedPatients" name="patient_ids">

            <div class="modal-content shadow">

                <div class="modal-header bg-danger">

                    <h4 class="modal-title">

                        <i class="fas fa-ambulance mr-2"></i>

                        Emergency Patient Management

                    </h4>

                    <button type="button" class="close" data-dismiss="modal">

                        &times;

                    </button>

                </div>

                <div class="modal-body">

                    <div class="alert alert-info">

                        <strong id="selectedPatientCount">0</strong>

                        patient(s) selected.

                    </div>

                    <div class="form-group">

                        <label>

                            Emergency Status

                        </label>

                        <select class="form-control" name="is_emergency" id="isEmergency">

                            <option value="1">

                                🔴 Emergency

                            </option>

                            <option value="0">

                                🟢 Normal

                            </option>

                        </select>

                    </div>

                    <div class="form-group">

                        <label>

                            Reason

                        </label>

                        <textarea class="form-control" rows="4" name="reason" placeholder="Why are these patients marked as emergency?"></textarea>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">

                        Cancel

                    </button>

                    <button class="btn btn-danger">

                        <i class="fas fa-save"></i>

                        Save Emergency Status

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>
