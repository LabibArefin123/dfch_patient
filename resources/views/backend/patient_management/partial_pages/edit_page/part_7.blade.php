<div class="col-12">

    <div class="patient-section-card remarks-card">

        <div class="section-header">

            <div>

                <h5>
                    <i class="fas fa-notes-medical text-danger"></i>
                    Medical Notes & Prescriptions
                </h5>

                <span>
                    Patient observations, problems and medication history
                </span>

            </div>

            <span class="section-badge remarks-badge">
                Doctor Notes
            </span>

        </div>

        <div class="row">

            <div class="form-group col-md-12">

                <label>
                    <i class="fas fa-clipboard-list mr-1"></i>
                    Remarks
                </label>

                <textarea name="remarks" id="edit_remarks" class="form-control">{!! old('remarks', $patient->remarks) !!}</textarea>

            </div>

            <div class="form-group col-md-12">

                <label>
                    <i class="fas fa-user-injured mr-1"></i>
                    Patient's Problem
                </label>

                <textarea name="patient_problem_description" id="edit_patient_problem_description" class="form-control">{!! old('patient_problem_description', $patient->patient_problem_description) !!}</textarea>

            </div>

            <div class="form-group col-md-12">

                <label>
                    <i class="fas fa-pills mr-1"></i>
                    Drug Description
                </label>

                <textarea name="patient_drug_description" id="edit_patient_drug_description" class="form-control">{!! old('patient_drug_description', $patient->patient_drug_description) !!}</textarea>

            </div>

        </div>

    </div>

</div>
