/** Treatment */

function toggleTreatment() {
    if ($("#is_treatment").val() == "1") {
        $(".treatment-section").stop(true, true).slideDown(250);
    } else {
        $(".treatment-section").stop(true, true).slideUp(250);
    }
}

function initializeTreatmentToggle() {
    toggleTreatment();

    $("#is_treatment").on("change", toggleTreatment);
}
