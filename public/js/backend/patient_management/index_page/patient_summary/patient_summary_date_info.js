function appendDateSearchInfo(patients, keyword) {
    let html = "";

    html += `
        <div class="mb-3 d-flex">
        <div class="bg-light border rounded p-3 w-100">
        <div class="text-success font-weight-bold mb-2">
        <i class="fas fa-check-circle"></i>
        Search completed successfully.
        </div>

        <div class="mb-3">
        I found <strong>${patients.length}</strong> patient(s)
        matching "<strong>${keyword}</strong>".
        </div>
        <div class="border-top pt-2">
        <strong>
        <i class="fas fa-users mr-1"></i>
        Patient List
        </strong>
    `;

    $.each(patients, function (i, p) {
        html += `
        <div class="border rounded p-2 mt-2">
            <div><strong>${p.patient_code}</strong></div>
            <div>
            ${p.patient_name}
            (${p.age} Years)
            </div>
            <div class="text-muted">
            <i class="fas fa-phone"></i>
            ${p.phone}
            </div>
        </div>
        `;
    });

    html += `
        <div class="mt-3 text-primary">
        Please click the <strong>Show</strong> button beside a patient
        to view the complete patient summary.
        </div>
        </div>
        </div>
        </div>
        `;

    $("#patientSummaryChat").append(html);

    scrollPatientChat();
}
