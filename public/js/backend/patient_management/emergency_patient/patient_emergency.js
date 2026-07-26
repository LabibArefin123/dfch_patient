window.selectedPatients = [];

function updateSelectedPatients() {
    window.selectedPatients = [];

    let html = "";

    $(".row-checkbox:checked").each(function () {
        const row = $(this).closest("tr");

        window.selectedPatients.push($(this).val());

        html += `
            <div class="border-bottom py-2">

                <strong>${row.find("td:eq(4)").text().trim()}</strong>

                <br>

                <small class="text-muted">

                    ${row.find("td:eq(5)").text().trim()}

                </small>

            </div>
        `;
    });

    $("#selectedPatientCount").text(window.selectedPatients.length);

    $("#selectedPatientBadge").text(window.selectedPatients.length);

    $("#selectedPatients").val(window.selectedPatients.join(","));

    if (!html) {
        html = `
            <div class="text-center text-muted py-5">

                No patients selected.

            </div>
        `;
    }

    $("#selectedPatientList").html(html);
}

$(document).on("change", ".row-checkbox", updateSelectedPatients);

$(document).on("change", "#checkAll", function () {
    $(".row-checkbox").prop("checked", this.checked);

    updateSelectedPatients();
});

$(document).on("click", "#btnEmergency", function () {
    updateSelectedPatients();

    if (!window.selectedPatients.length) {
        toastr.warning("Select at least one patient.");

        return;
    }

    bootstrap.Modal.getOrCreateInstance(
        document.getElementById("patientEmergencyModal"),
    ).show();

    window.patientEmergencyValidator.updateProgress();
});

$(document).on("hidden.bs.modal", "#patientEmergencyModal", function () {
    window.selectedPatients = [];

    $("#patientEmergencyForm")[0].reset();

    $("#checkAll").prop("checked", false);

    $(".row-checkbox").prop("checked", false);

    updateSelectedPatients();

    window.patientEmergencyValidator.updateProgress();

    if (window.patientEmergencySubmit) {
        clearInterval(window.patientEmergencySubmit.interval);

        window.patientEmergencySubmit.submitting = false;
    }
});