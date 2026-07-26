window.patientEmergencyClose = {
    close() {
        // Stop submit animation if running
        if (window.patientEmergencySubmit) {
            clearInterval(window.patientEmergencySubmit.interval);

            window.patientEmergencySubmit.submitting = false;
        }

        // Enable submit button
        $("#btnEmergencySubmit").prop("disabled", false);

        // Hide submit progress modal if visible
        const progressModal = bootstrap.Modal.getInstance(
            document.getElementById("submitProgressModal"),
        );

        if (progressModal) {
            progressModal.hide();
        }

        // Hide emergency modal
        const emergencyModal = bootstrap.Modal.getInstance(
            document.getElementById("patientEmergencyModal"),
        );

        if (emergencyModal) {
            emergencyModal.hide();
        }

        // Reset form
        const form = document.getElementById("patientEmergencyForm");

        if (form) {
            form.reset();
        }

        // Reset selected patients
        window.selectedPatients = [];

        $(".row-checkbox").prop("checked", false);

        $("#checkAll").prop("checked", false);

        if (typeof updateSelectedPatients === "function") {
            updateSelectedPatients();
        }

        if (window.patientEmergencyValidator) {
            window.patientEmergencyValidator.updateProgress();
        }
    },
};

// Cancel button
$(document).on("click", "#btnEmergencyCancel", function (e) {
    e.preventDefault();
    e.stopPropagation();

    window.patientEmergencyClose.close();
});

// Close icon (X)
$(document).on("click", ".btn-close", function (e) {
    e.preventDefault();
    e.stopPropagation();

    window.patientEmergencyClose.close();
});
