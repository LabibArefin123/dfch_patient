{{-- ========================= MEDICAL INFORMATION ========================= --}}

<div class="section-subtitle" id="part_3_medical">

    <span>
        <i class="fas fa-notes-medical"></i>
        Symptoms & Clinical Information
    </span>

    <hr>

</div>

<div class="section-note danger">

    <div class="section-note-icon">
        <i class="fas fa-stethoscope"></i>
    </div>

    <div class="section-note-content">

        <strong>Patient Clinical Information</strong>

        <p>
            Record the patient's current health problem, medication history
            and any additional medical observations that may be important
            for diagnosis and treatment.
        </p>

    </div>

</div>

<div class="row">

    {{-- Patient's Problem --}}
    <div class="form-group col-lg-6">

        <label>
            <i class="fas fa-user-injured text-danger mr-1"></i>
            Patient's Problem
            <span class="text-danger">*</span>
        </label>

        <textarea name="patient_problem_description" id="patient_problem_description" class="form-control" rows="7"
            placeholder="Describe the patient's current problem, symptoms, complaints or diagnosis..."></textarea>

        <small class="text-muted">
            Describe the patient's main complaint, symptoms, diagnosis
            or other relevant medical problems.
        </small>

    </div>


    {{-- Patient's Drug Description --}}
    <div class="form-group col-lg-6">

        <label>
            <i class="fas fa-pills text-primary mr-1"></i>
            Medication / Drug Description
            <span class="text-danger">*</span>
        </label>

        <textarea name="patient_drug_description" id="patient_drug_description" class="form-control" rows="7"
            placeholder="Enter current medicines, dosage, duration or previous medication history..."></textarea>

        <small class="text-muted">
            Record medicines currently being taken, dosage information,
            duration or relevant medication history.
        </small>

    </div>


    {{-- Medical Remarks --}}
    <div class="form-group col-lg-12">

        <label>
            <i class="fas fa-comment-medical text-info mr-1"></i>
            Medical Remarks
        </label>

        <textarea name="remarks" id="remarks" class="form-control" rows="5"
            placeholder="Add additional clinical observations, important notes or recommendations..."></textarea>

        <small class="text-muted">
            Add any additional clinical observations, important notes
            or recommendations that do not belong in the fields above.
        </small>

    </div>

</div>
