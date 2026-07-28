$(function () {
    const patientSelect = $("#patientSelect");
    const patientInfo = $("#patientInformation");
    const patientCard = $("#patientInfoCard");

    if (!patientInfo.length) {
        console.error("#patientInformation not found.");
        return;
    }

    $("#patientSelect").select2({
        theme: "bootstrap4",
        width: "100%",
        placeholder: "Select Patient",
        allowClear: true,
    });

    patientSelect.on("select2:select", function (e) {
        patientCard.slideDown(200);

        renderPatient(e.params.data.patient);
    });

    patientSelect.on("select2:clear", function () {
        resetPatient();

        patientCard.slideUp(200);
    });

    $("#patientSelect").on("change", function () {
        let id = $(this).val();

        if (!id) {
            resetPatient();

            return;
        }

        patientCard.show();

        $.ajax({
            url: "/ajax/patients/" + id,
            type: "GET",

            beforeSend: function () {
                patientInfo.html(`
                <div class="text-center py-5">
                    <i class="fas fa-spinner fa-spin fa-2x"></i>
                    <br>
                    Loading patient...
                </div>
            `);
            },

            success: function (response) {
                renderPatient(response);
            },

            error: function () {
                Swal.fire(
                    "Error",
                    "Unable to load patient information.",
                    "error",
                );
            },
        });
    });

    function value(v) {
        return v && v !== "" ? v : "-";
    }

    function statusIcon(status) {
        return status
            ? `<span class="text-success font-weight-bold">
                    <i class="fas fa-check-circle mr-1"></i>Yes
               </span>`
            : `<span class="text-danger font-weight-bold">
                    <i class="fas fa-times-circle mr-1"></i>No
               </span>`;
    }

    function renderDocuments(documents) {
        if (!documents || documents.length === 0) {
            return `
                <div class="text-muted text-center py-3">
                    <i class="far fa-folder-open fa-2x mb-2"></i><br>
                    No documents uploaded.
                </div>
            `;
        }

        let html = "";

        $.each(documents, function (_, doc) {
            html += `
                <a href="${doc.url}"
                    target="_blank"
                    class="btn btn-outline-primary btn-sm mr-2 mb-2">

                    <i class="fas fa-file-alt mr-1"></i>
                    ${value(doc.name)}

                </a>
            `;
        });

        return html;
    }

    function renderPatient(patient) {
        patientInfo.html(`

            <div class="row">

                <div class="col-lg-6">

                    <table class="table table-bordered table-hover table-sm">

                        <tbody>

                            <tr>
                                <th width="180">Patient Name</th>
                                <td>${value(patient.patient_name)}</td>
                            </tr>

                            <tr>
                                <th>Patient Code</th>
                                <td>${value(patient.patient_code)}</td>
                            </tr>

                            <tr>
                                <th>Location</th>
                                <td>${value(patient.location)}</td>
                            </tr>

                            <tr>
                                <th>Age</th>
                                <td>${value(patient.age)}</td>
                            </tr>

                            <tr>
                                <th>Date Added</th>
                                <td>${value(patient.date_added)}</td>
                            </tr>

                            <tr>
                                <th>Father Name</th>
                                <td>${value(patient.father_name)}</td>
                            </tr>

                            <tr>
                                <th>Mother Name</th>
                                <td>${value(patient.mother_name)}</td>
                            </tr>

                            <tr>
                                <th>Father Phone</th>
                                <td>${value(patient.father_phone)}</td>
                            </tr>

                            <tr>
                                <th>Mother Phone</th>
                                <td>${value(patient.mother_phone)}</td>
                            </tr>

                        </tbody>

                    </table>

                </div>

                <div class="col-lg-6">

                    <div class="card shadow-sm border">

                        <div class="card-header">

                            <strong>
                                <i class="fas fa-heartbeat mr-1"></i>
                                Patient Status
                            </strong>

                        </div>

                        <div class="card-body">

                            <div class="d-flex justify-content-between mb-3">

                                <span>Referred Patient</span>

                                ${statusIcon(patient.is_referred)}

                            </div>

                            <div class="d-flex justify-content-between mb-3">

                                <span>Treatment Started</span>

                                ${statusIcon(patient.is_treatment)}

                            </div>

                            <div class="d-flex justify-content-between">

                                <span>Investigation Completed</span>

                                ${statusIcon(patient.is_investigated)}

                            </div>

                        </div>

                    </div>

                    <div class="card shadow-sm border mt-3">

                        <div class="card-header">

                            <strong>

                                <i class="fas fa-folder-open mr-1"></i>

                                Patient Documents

                            </strong>

                        </div>

                        <div class="card-body">

                            ${renderDocuments(patient.documents)}

                        </div>

                    </div>

                </div>

            </div>

        `);
    }

    function resetPatient() {
        patientInfo.html(`

            <div class="text-center text-muted py-5">

                <i class="fas fa-user-injured fa-3x mb-3"></i>

                <h5>No Patient Selected</h5>

                <p class="mb-0">
                    Search and select a patient to view complete information.
                </p>

            </div>

        `);
    }

    resetPatient();
});
