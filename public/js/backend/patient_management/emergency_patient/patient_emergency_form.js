$(document).on("submit", "#patientEmergencyForm", function (e) {
    e.preventDefault();

    // Prevent duplicate submit
    if (window.patientEmergencySubmit.submitting) {
        return;
    }

    // Require selected patients
    if (!window.selectedPatients.length) {
        toastr.warning("Please select at least one patient.");
        return;
    }

    // Validate form
    const validation = window.patientEmergencyValidator.validate();

    if (!validation.valid) {
        validation.errors.forEach((msg) => toastr.warning(msg));
        return;
    }

    // Prepare form data
    const formData = new FormData(this);

    window.selectedPatients.forEach((id) => {
        formData.append("patient_ids[]", id);
    });

    // Send request
    window.patientEmergencyAjax.submit(formData);
});
