function renderPatientDetail(p) {
    let html = `
<div class="row">

    <div class="col-md-4 text-center mb-3">
        <img src="${p.patient_photo || "/images/default-avatar.png"}" 
             class="img-fluid rounded border shadow-sm" 
             style="height:260px; width:100%; object-fit:contain; background:#f8f9fa;">
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

    // Bot messages when a patient card detail is opened
    appendBotMessage("Showing details for <b>" + p.patient_name + "</b>.");
}

// Single click handler instance bound to document (covers dynamic ajax rows)
$(document).on("click", ".patient-summary-show", function () {
    const patientData = $(this).data("patient");
    if (patientData) {
        renderPatientDetail(patientData);
    }
});
