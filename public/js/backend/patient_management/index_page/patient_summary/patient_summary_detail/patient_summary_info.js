/**
 * ==========================================================
 * Patient Summary - Profile Information
 * ==========================================================
 */

function loadPatientInfo(patient) {
    // Profile Photo
    $("#viewModalPhoto").attr(
        "src",
        patient.patient_photo
            ? "/" + patient.patient_photo
            : "/uploads/images/default.jpg",
    );

    const infoContainer = $("#viewPatientInfoContainer");

    const fields = [
        {
            label: "Patient Code",
            val: patient.patient_code,
        },
        {
            label: "Patient Name",
            val: patient.patient_name,
        },
        {
            label: "Age",
            val: patient.age ? patient.age + " Years" : "N/A",
        },
        {
            label: "Gender",
            val: patient.gender,
        },
        {
            label: "Primary Phone",
            val: patient.phone_1 || patient.phone || "N/A",
        },
        {
            label: "Alternative Phone",
            val: patient.phone_2 || "N/A",
        },
        {
            label: "Father Name",
            val: patient.patient_f_name || patient.father || "N/A",
        },
        {
            label: "Mother Name",
            val: patient.patient_m_name || patient.mother || "N/A",
        },
        {
            label: "Problem Description",
            val:
                patient.patient_problem_description || patient.problem || "N/A",
        },
        {
            label: "Drug Description",
            val: patient.patient_drug_description || patient.drug || "N/A",
        },
        {
            label: "Referred Patient",
            val:
                patient.is_referred || patient.recommend
                    ? '<span class="badge badge-success">Yes</span>'
                    : '<span class="badge badge-secondary">No</span>',
        },
        {
            label: "Referred Doctor",
            val: patient.referred_doctor_name || patient.doctor || "N/A",
        },
        {
            label: "Referred Note",
            val: patient.referred_note || "N/A",
        },
        {
            label: "Remarks",
            val: patient.remarks || "N/A",
        },
        {
            label: "Patient Added",
            val: patient.date_of_patient_added || patient.date || "N/A",
        },
    ];

    let html = "";

    fields.forEach((field) => {
        html += `
            <div class="col-sm-6 col-md-4 mb-2">

                <div class="border rounded bg-white h-100 p-3">

                    <small
                        class="text-muted d-block mb-1"
                        style="
                            font-size:11px;
                            text-transform:uppercase;
                            font-weight:600;
                            letter-spacing:.5px;
                        ">
                        ${field.label}
                    </small>

                    <div
                        class="text-dark"
                        style="
                            font-size:14px;
                            font-weight:500;
                            word-break:break-word;
                        ">
                        ${field.val || "N/A"}
                    </div>

                </div>

            </div>
        `;
    });

    infoContainer.html(html);

    // Append Emergency Section
    loadEmergencySection(patient);
}

/**
 * ==========================================================
 * Emergency Information
 * ==========================================================
 */

function loadEmergencySection(patient) {
    const emergencyContainer = $("#viewPatientEmergencyContainer");

    const emergency =
        patient.latest_emergency || patient.latestEmergency || null;

    let html = `
        <div class="col-12 mt-4">

            <div class="card border-danger shadow-sm">

                <div class="card-header bg-danger text-white">

                    <i class="fas fa-ambulance mr-2"></i>

                    Emergency Information

                </div>

                <div class="card-body">
    `;

    if (emergency) {
        html += `

            <div class="row">

                <div class="col-md-4 mb-3">

                    <label class="font-weight-bold">
                        Status
                    </label>

                    <div class="form-control">

                        ${
                            emergency.is_emergency
                                ? '<span class="badge badge-danger">Emergency</span>'
                                : '<span class="badge badge-success">Normal</span>'
                        }

                    </div>

                </div>

                <div class="col-md-4 mb-3">

                    <label class="font-weight-bold">
                        Emergency Date
                    </label>

                    <div class="form-control">

                        ${emergency.emergency_date || "N/A"}

                    </div>

                </div>

                <div class="col-md-4 mb-3">

                    <label class="font-weight-bold">
                        Total Emergency Records
                    </label>

                    <div class="form-control">

                        ${patient.emergency_records || 1}

                    </div>

                </div>

                <div class="col-12">

                    <label class="font-weight-bold">
                        Emergency Reason
                    </label>

                    <div
                        class="form-control"
                        style="
                            min-height:80px;
                            height:auto;
                            white-space:pre-wrap;
                        ">

                        ${emergency.reason || "No reason provided."}

                    </div>

                </div>

            </div>

        `;
    } else {
        html += `

            <div class="alert alert-success mb-0">

                <i class="fas fa-check-circle mr-2"></i>

                No emergency records found for this patient.

            </div>

        `;
    }

    html += `
                </div>

            </div>

        </div>
    `;

    emergencyContainer.html(html);
}
