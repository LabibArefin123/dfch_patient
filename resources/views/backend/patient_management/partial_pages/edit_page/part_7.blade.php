<div class="form-group col-md-12">
    <label>Remarks</label>
    <textarea name="remarks" id="edit_remarks" class="form-control">{!! $patient->remarks !!}</textarea>
</div>

<div class="form-group col-md-12">
    <label>Patient's Problem</label>
    <textarea name="patient_problem_description" id="edit_patient_problem_description" class="form-control">{!! $patient->patient_problem_description !!}</textarea>
</div>

<div class="form-group col-md-12">
    <label>Patient's Drug Description</label>
    <textarea name="patient_drug_description" id="edit_patient_drug_description" class="form-control">{!! $patient->patient_drug_description !!}</textarea>
</div>
<div class="form-group col-md-12">
    <style>
        .progress-circle {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            margin: auto;
            background: conic-gradient(#28a745 0%, #e9ecef 0%);
            transition: 0.4s ease;
        }
    </style>

    <label class="font-weight-bold">Patient Photo</label>

    <div class="card shadow-sm p-3 text-center">

        <!-- Image Preview -->
        <div class="mb-3">
            <img id="mainPreview"
                src="{{ $patient->patient_photo && file_exists(public_path($patient->patient_photo))
                    ? asset($patient->patient_photo)
                    : asset('uploads/images/default.jpg') }}"
                class="rounded-circle shadow" style="width:140px;height:140px;object-fit:cover;border:3px solid #eee;">
        </div>

        <!-- Hidden REAL input (IMPORTANT) -->
        <input type="file" name="patient_photo" id="hiddenPhotoInput" hidden>

        <!-- Action Button -->
        <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#photoModal">
            <i class="fa fa-upload"></i> Change Photo
        </button>
    </div>
</div>
