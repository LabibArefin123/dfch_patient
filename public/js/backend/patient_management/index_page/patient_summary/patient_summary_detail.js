function renderPatientDetail(p) {
    let html = `
<div class="row">

    <div class="col-md-4 text-center mb-3">
        <img src="${p.patient_photo || "/uploads/images/default.jpg"}" 
             class="img-fluid rounded border shadow-sm mb-3" 
             style="height:220px; width:100%; object-fit:contain; background:#f8f9fa;">
             
        <!-- View Full Profile Button -->
        <button class="btn btn-primary btn-block view-complete-profile-btn" data-id="${p.id}" style="border-radius: 8px; font-weight: 500;">
            <i class="fas fa-expand-arrows-alt mr-1"></i> Full Profile Modal
        </button>
    </div>

    <div class="col-md-8">
        <table class="table table-bordered table-sm text-dark">
            <tr><th width="35%">Patient Code</th><td>${p.patient_code}</td></tr>
            <tr><th>Name</th><td>${p.patient_name}</td></tr>
            <tr><th>Age</th><td>${p.age} Years</td></tr>
            <tr><th>Gender</th><td>${p.gender}</td></tr>
            <tr><th>Phone</th><td>${p.phone}</td></tr>
            <tr><th>Father</th><td>${p.father || "N/A"}</td></tr>
            <tr><th>Mother</th><td>${p.mother || "N/A"}</td></tr>
            <tr><th>Problem</th><td>${p.problem || "N/A"}</td></tr>
            <tr><th>Drug</th><td>${p.drug || "N/A"}</td></tr>
            <tr><th>Documents</th><td><span class="badge badge-primary">${p.documents || 0}</span></td></tr>
            <tr><th>Cancer Reports</th><td><span class="badge badge-danger">${p.cancer_reports || 0}</span></td></tr>
            <tr><th>Recommended</th><td>${p.recommend ? "Yes" : "No"}</td></tr>
            <tr><th>Doctor</th><td>${p.doctor || "N/A"}</td></tr>
            <tr><th>Recommendation</th><td>${p.recommend_note || "N/A"}</td></tr>
            <tr><th>Date Added</th><td>${p.date}</td></tr>
            <tr><th>Remarks</th><td>${p.remarks || "N/A"}</td></tr>
        </table>
    </div>

</div>
`;

    $("#patientSummaryDetail").html(html);
    appendBotMessage("Showing details for <b>" + p.patient_name + "</b>.");
}

// Single click handler instance bound to document (covers dynamic ajax rows)
$(document).on("click", ".patient-summary-show", function () {
    const patientData = $(this).data("patient");
    if (patientData) {
        renderPatientDetail(patientData);
        
        // 🆕 Shift tabs dynamically to the Profile tab when clicked
        const profileTabLink = $('#profile-tab');
        if (profileTabLink.length) {
            profileTabLink.tab('show');
            profileTabLink.find('i').removeClass('text-muted').addClass('text-primary');
            $('#results-tab').find('i').addClass('text-muted');
        }
    }
});

// Trigger dynamic AJAX fetch for complete patient details and open modal
$(document).on("click", ".view-complete-profile-btn", function () {
    const id = $(this).data("id");

    // Initialize loading states in Modal fields
    $("#viewModalPhoto").attr("src", "/uploads/images/default.jpg");
    $("#viewPatientInfoContainer").html(`
        <div class="col-12 text-center py-5">
            <i class="fas fa-spinner fa-spin fa-2x text-primary mb-2"></i>
            <p class="text-muted mb-0">Fetching patient profile details...</p>
        </div>
    `);
    $("#viewPatientDocsContainer").empty();
    $("#viewPatientCancerPhotosContainer").empty();

    // Show modal instantly
    $("#patientViewModal").modal("show");

    // Load full patient properties dynamically
    $.ajax({
        url: `/patients/${id}/modal-details`,
        type: "GET",
        success: function (res) {
            if (res.success && res.patient) {
                populatePatientViewModal(res.patient);
            } else {
                $("#viewPatientInfoContainer").html(
                    '<div class="col-12 text-danger text-center">Failed to resolve patient records.</div>',
                );
            }
        },
        error: function () {
            $("#viewPatientInfoContainer").html(
                '<div class="col-12 text-danger text-center">Error communicating with server records.</div>',
            );
        },
    });
});

/**
 * Helper method to format fields and append to view modal
 */
function populatePatientViewModal(patient) {
    // 1. Profile photo
    $("#viewModalPhoto").attr("src", patient.patient_photo ? "/" + patient.patient_photo : "/uploads/images/default.jpg");

    // 2. Info grid
    const infoContainer = $("#viewPatientInfoContainer");
    const fields = [
        { label: "Code", val: patient.patient_code },
        { label: "Name", val: patient.patient_name },
        { label: "Age", val: patient.age ? patient.age + " Years" : "N/A" },
        { label: "Gender", val: patient.gender },
        { label: "Phone Primary", val: patient.phone_1 || patient.phone },
        { label: "Phone Secondary", val: patient.phone_2 || "N/A" },
        { label: "Father Name", val: patient.patient_f_name || patient.father },
        { label: "Mother Name", val: patient.patient_m_name || patient.mother },
        { label: "Problem", val: patient.patient_problem_description || patient.problem || "N/A" },
        { label: "Drug", val: patient.patient_drug_description || patient.drug || "N/A" },
        { label: "Doctor", val: patient.doctor || "N/A" },
        { label: "Recommendation", val: patient.recommend_note || "N/A" },
        { label: "Remarks", val: patient.remarks || "N/A" },
        { label: "Added Date", val: patient.date_of_patient_added || patient.date }
    ];

    let infoHtml = "";
    fields.forEach(f => {
        infoHtml += `
            <div class="col-sm-6 col-md-4">
                <div class="p-2 border-bottom">
                    <small class="text-muted d-block mb-1" style="font-size: 11px; text-transform: uppercase; font-weight: 600;">${f.label}</small>
                    <span class="text-dark" style="font-size: 14px; font-weight: 500;">${f.val || 'N/A'}</span>
                </div>
            </div>
        `;
    });
    infoContainer.html(infoHtml);

    // 3. Recommendation Documents
    const docsContainer = $("#viewPatientDocsContainer");
    docsContainer.empty();

    const docs = patient.documents || [];
    if (docs.length > 0) {
        docs.forEach(doc => {
            const fileName = doc.document_name || "Document";
            const filePath = "/" + doc.file_path;
            docsContainer.append(`
                <div class="col-md-6 mb-2">
                    <div class="p-2 border rounded d-flex align-items-center justify-content-between bg-light">
                        <span class="text-truncate mr-2" style="font-size: 13.5px; max-width: 70%;" title="${fileName}">
                            <i class="fas fa-file-pdf text-danger mr-2"></i>${fileName}
                        </span>
                        <a href="${filePath}" target="_blank" class="btn btn-outline-success btn-xs px-2 py-1">
                            <i class="fas fa-download"></i> View
                        </a>
                    </div>
                </div>
            `);
        });
    } else {
        docsContainer.html('<div class="col-12 text-muted p-2">No recommendation documents uploaded.</div>');
    }

    // 4. Cancer & X-Ray Reports list (eager loaded via relation: cancerPhotos)
    const photosContainer = $("#viewPatientCancerPhotosContainer");
    photosContainer.empty();

    const reports = patient.cancer_photos || patient.cancerPhotos || [];

    if (reports.length > 0) {
        reports.forEach((report) => {
            const totalCancer = report.total_cancer ?? 0;
            const remarks = report.remarks || 'N/A';
            const xrayPhotos = report.xray_photo || [];
            const xrayDescriptions = report.xray_description || [];

            let reportHtml = `
                <div class="border rounded p-3 mb-4 w-100 bg-light shadow-sm">
                    <div class="row mb-3 align-items-center">
                        <div class="col-md-3 mb-2 mb-md-0">
                            <strong>Total Cancer</strong>
                            <div class="form-control bg-white border" style="font-weight: 500;">
                                ${totalCancer}
                            </div>
                        </div>
                        <div class="col-md-9">
                            <strong>Remarks</strong>
                            <div class="form-control bg-white border" style="min-height: 40px; height: auto;">
                                ${remarks}
                            </div>
                        </div>
                    </div>
            `;

            if (xrayPhotos.length > 0) {
                reportHtml += `<div class="row">`;
                xrayPhotos.forEach((photo, pIndex) => {
                    const fullPath = "/" + photo;
                    const description = xrayDescriptions[pIndex] || 'N/A';
                    reportHtml += `
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                            <div class="card h-100 border shadow-xs" style="border-radius: 8px; overflow: hidden;">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#imageZoomModal" data-bs-img-src="${fullPath}">
                                    <img src="${fullPath}" class="card-img-top img-fluid" style="height: 160px; object-fit: cover; cursor: zoom-in;" alt="Cancer X-ray Image">
                                </a>
                                <div class="card-body p-2 bg-white border-top">
                                    <strong>Description</strong>
                                    <p class="mb-0 text-muted" style="font-size: 13px; line-height: 1.4;">${description}</p>
                                </div>
                            </div>
                        </div>
                    `;
                });
                reportHtml += `</div>`;
            } else {
                reportHtml += `<div class="text-muted small">No photos uploaded for this report.</div>`;
            }

            reportHtml += `</div>`;
            photosContainer.append(reportHtml);
        });
    } else {
        photosContainer.html('<div class="alert alert-warning mb-0 w-100">No cancer reports found for this patient.</div>');
    }
}
