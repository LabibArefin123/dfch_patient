/**
 * --------------------------------------------------------------------------
 * Treatment
 * --------------------------------------------------------------------------
 */

function toggleTreatment() {
    if ($("#is_treatment").val() == "1") {
        $("#treatmentSection").stop(true, true).slideDown(300);
    } else {
        $("#treatmentSection").stop(true, true).slideUp(300);
    }
}

function initializeTreatmentToggle() {
    toggleTreatment();

    $("#is_treatment").on("change", function () {
        toggleTreatment();
    });
}
