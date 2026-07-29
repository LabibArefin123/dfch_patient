//PATIENT SELECT + INFORMATION
$(function () {
    const patientSelect = $("#patientSelect");
    const patientInfo = $("#patientInformation");
    const patientCard = $("#patientInfoCard");

    if (!patientSelect.length || !patientInfo.length) {
        console.error(
            "Patient select or patient information container not found.",
        );

        return;
    }

    //INITIALIZE SELECT2
    if (!patientSelect.hasClass("select2-hidden-accessible")) {
        patientSelect.select2({
            theme: "bootstrap4",
            width: "100%",
            placeholder: "Select Patient",
            allowClear: true,
            minimumResultsForSearch: 0,
            dropdownAutoWidth: false,
            dropdownParent: $("body"),
        });
    }

    // SELECT PATIENT
    patientSelect.on("change", function () {
        const patientId = $(this).val();
        //No patient selected
        if (!patientId) {
            resetPatient();
            patientCard.stop(true, true).slideUp(180);
            return;
        }

        //Close Select2 immediately
        patientSelect.select2("close");

        //Show patient card
        patientCard.stop(true, true).slideDown(180);

        //Loading state
        showPatientLoading();

        //Load patient
        $.ajax({
            url: "/ajax/patients/" + patientId,
            type: "GET",
            dataType: "json",
            success: function (response) {
                renderPatient(response);
            },

            error: function (xhr) {
                console.error("Patient information error:", xhr);
                patientInfo.html(`
                    <div class="patient-empty-state">
                        <div class="patient-empty-state-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>

                        <h5>Unable to Load Patient</h5>
                        <p>
                            Patient information could not be loaded.
                            Please try again.
                        </p>
                    </div>
                `);

                if (typeof Swal !== "undefined") {
                    Swal.fire(
                        "Error",
                        "Unable to load patient information.",
                        "error",
                    );
                }
            },
        });
    });

    //SELECT2 CLEAR
    patientSelect.on("select2:clear", function () {
        resetPatient();
        patientCard.stop(true, true).slideUp(180);
    });

    //LOADING
    function showPatientLoading() {
        patientInfo.html(`
            <div class="patient-info-loading">
                <i class="fas fa-spinner fa-spin fa-2x"></i>
                <div>Loading patient information...</div>
            </div>
        `);
    }

    // SAFE VALUE
    function value(v) {
        if (v !== null && v !== undefined && String(v).trim() !== "") {
            return escapeHtml(String(v));
        }
        return "-";
    }

    // ESCAPE HTML
    function escapeHtml(value) {
        return value
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    // STATUS;
    function statusIcon(status) {
        if (status) {
            return `
                <span class="patient-status-yes">
                    <i class="fas fa-check-circle"></i>
                    Yes
                </span>
            `;
        }

        return `
            <span class="patient-status-no">
                <i class="fas fa-times-circle"></i>
                No
            </span>
        `;
    }

    //DOCUMENTS
    function renderDocuments(documents) {
        if (!documents || !documents.length) {
            return `
                <div class="text-muted text-center py-3">
                    <i class="far fa-folder-open fa-2x mb-2"></i>
                    <div>No documents uploaded. </div>
                </div>
            `;
        }

        let html = `
            <div class="patient-documents-list">
        `;

        $.each(documents, function (_, doc) {
            html += `
                <a href="${doc.url}"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="patient-document-btn">
                    <i class="fas fa-file-alt"></i>
                    ${value(doc.name)}
                </a>
            `;
        });

        html += `</div>`;
        return html;
    }

    //RENDER PATIENT
    function renderPatient(patient) {
        if (!patient) {
            resetPatient();

            return;
        }

        patientInfo.html(`
            <div class="row patient-info-grid">
                <div class="col-md-6 col-lg-3 mb-3">
                    <div class="patient-info-item">
                        <div class="patient-info-label">
                            <i class="fas fa-user"></i>
                            Patient Name
                        </div>

                        <div class="patient-info-value">
                            ${value(patient.patient_name)}
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3 mb-3">
                    <div class="patient-info-item">
                        <div class="patient-info-label">
                            <i class="fas fa-id-card"></i>
                            Patient Code
                        </div>

                        <div class="patient-info-value">
                            ${value(patient.patient_code)}
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3 mb-3">
                    <div class="patient-info-item">
                        <div class="patient-info-label">
                            <i class="fas fa-map-marker-alt"></i>
                            Location
                        </div>

                        <div class="patient-info-value">
                            ${value(patient.location)}
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3 mb-3">
                    <div class="patient-info-item">
                        <div class="patient-info-label">
                            <i class="fas fa-birthday-cake"></i>
                            Age
                        </div>

                        <div class="patient-info-value">
                            ${value(patient.age)}
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3 mb-3">
                    <div class="patient-info-item">
                        <div class="patient-info-label">
                            <i class="fas fa-calendar-alt"></i>
                            Date Of Patient Added
                        </div>
                        <div class="patient-info-value">
                            ${value(patient.date_added)}
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3 mb-3">
                    <div class="patient-info-item">
                        <div class="patient-info-label">
                            <i class="fas fa-user"></i>
                            Patient's Father Name
                        </div>

                        <div class="patient-info-value">
                            ${value(patient.father_name)}
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3 mb-3">
                    <div class="patient-info-item">
                        <div class="patient-info-label">
                            <i class="fas fa-user"></i>
                            Patient's Mother Name
                        </div>

                        <div class="patient-info-value">
                            ${value(patient.mother_name)}
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3 mb-3">
                    <div class="patient-info-item">
                        <div class="patient-info-label">
                            <i class="fas fa-phone"></i>
                           Patient's Father Phone
                        </div>

                        <div class="patient-info-value">
                            ${value(patient.father_phone)}
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="patient-info-item">
                        <div class="patient-info-label">
                            <i class="fas fa-phone"></i>
                            Patient's Mother Phone
                        </div>

                        <div class="patient-info-value">
                            ${value(patient.mother_phone)}
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-md-6 mb-3 mb-md-0">
                    <div class="patient-status-card">
                        <div class="card-header">
                            <strong>
                                <i class="fas fa-heartbeat mr-1"></i>
                                Patient Status
                            </strong>
                        </div>

                        <div class="card-body">
                            <div class="patient-status-row">
                                <span class="patient-status-label">
                                    Referred Patient
                                </span>
                                ${statusIcon(patient.is_referred)}
                            </div>

                            <div class="patient-status-row">
                                <span class="patient-status-label">
                                    Treatment Started
                                </span>
                                ${statusIcon(patient.is_treatment)}
                            </div>


                            <div class="patient-status-row">
                                <span class="patient-status-label">
                                    Investigation Completed
                                </span>
                                ${statusIcon(patient.is_investigated)}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="patient-documents-card">
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

    //RESET;
    function resetPatient() {
        patientInfo.html(`
            <div class="patient-empty-state">
                <div class="patient-empty-state-icon">
                    <i class="fas fa-user-injured"></i>
                </div>
                <h5>No Patient Selected</h5>
                <p>
                    Search and select a patient to view complete
                    information.
                </p>
            </div>
        `);
    }

    // INITIAL STATE
    resetPatient();
});
