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
            <tr><th>Father's Name</th><td>${p.father || "N/A"}</td></tr>
            <tr><th>Mother's Name</th><td>${p.mother || "N/A"}</td></tr>
            <tr><th>Problem Details</th><td>${p.problem || "N/A"}</td></tr>
            <tr><th>Drug Description</th><td>${p.drug || "N/A"}</td></tr>
            <tr><th>Documents</th><td><span class="badge badge-primary">${p.documents || 0}</span></td></tr>
            <tr><th>Cancer Reports</th><td><span class="badge badge-danger">${p.cancer_reports || 0}</span></td></tr>
            <tr><th>Referred Patient</th><td>${p.recommend ? "Yes" : "No"}</td></tr>
            <tr><th>Referred Doctor</th><td>${p.doctor || "N/A"}</td></tr>
            <tr><th>Referred Note</th><td>${p.referred_note || "N/A"}</td></tr>
            <tr><th>Date of Patient Added</th><td>${p.date}</td></tr>
            <tr><th>Remarks</th><td>${p.remarks || "N/A"}</td></tr>
        </table>
    </div>

</div>
`;

    $("#patientSummaryDetail").html(html);
    appendBotMessage("Showing details for <b>" + p.patient_name + "</b>.");
}

function initializePatientSummaryProfile() {
    $(document).on("click", ".patient-summary-show", function () {
        const patientData = $(this).data("patient");

        if (!patientData) return;

        renderPatientDetail(patientData);

        const profileTabLink = $("#profile-tab");

        if (profileTabLink.length) {
            profileTabLink.tab("show");

            profileTabLink
                .find("i")
                .removeClass("text-muted")
                .addClass("text-primary");

            $("#results-tab").find("i").addClass("text-muted");
        }
    });
}

