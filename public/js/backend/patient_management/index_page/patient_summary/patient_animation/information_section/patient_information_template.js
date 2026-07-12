(function () {
    function field(title, value) {
        return `
        <div class="col-md-6 mb-3">

            <div class="border rounded shadow-sm h-100 p-3 bg-white">

                <small class="text-muted d-block mb-1">

                    ${title}

                </small>

                <strong class="text-dark">

                    ${value || "N/A"}

                </strong>

            </div>

        </div>
    `;
    }

    function template(patient) {
        return `

        <div class="patient-information-wrapper d-none">

            <div class="card shadow-sm border-0 mb-4">

                <div class="card-header bg-info text-white">

                    <div class="d-flex align-items-center">

                        <div class="rounded-circle bg-white text-info d-flex align-items-center justify-content-center mr-3"
                             style="width:42px;height:42px;">

                            <i class="fas fa-user-injured"></i>

                        </div>

                        <div>

                            <h5 class="mb-0">

                                Patient Information Analysis

                            </h5>

                            <small class="patient-information-status">

                                Preparing information...

                            </small>

                        </div>

                    </div>

                </div>

                <div class="card-body">

                    <div class="row">

                        ${field("Patient Code", patient.patient_code)}

                        ${field("Patient Name", patient.patient_name)}

                        ${field("Age", patient.age ? patient.age + " Years" : "N/A")}

                        ${field("Gender", patient.gender)}

                        ${field("Primary Phone", patient.phone_1 || patient.phone || "N/A")}

                        ${field("Secondary Phone", patient.phone_2 || "N/A")}

                        ${field("Father Name", patient.patient_f_name || patient.father || "N/A")}

                        ${field("Mother Name", patient.patient_m_name || patient.mother || "N/A")}

                        ${field("Doctor", patient.doctor || patient.recommend_doctor_name || "N/A")}

                        ${field("Recommendation", patient.recommend_note || "N/A")}

                        ${field("Remarks", patient.remarks || "N/A")}

                        ${field("Date Added", patient.date_of_patient_added || patient.date || "N/A")}

                    </div>

                </div>

            </div>

        </div>

    `;
    }

    window.PatientInformationAnimate.field = field;
    window.PatientInformationAnimate.template = template;
})();
