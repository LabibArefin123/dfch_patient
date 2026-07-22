/**
 * --------------------------------------------------------------------------
 * Investigation
 * --------------------------------------------------------------------------
 */

function toggleInvestigation() {
    if ($("#is_investigated").val() == "1") {
        $(".investigation-section").stop(true, true).slideDown(250);
    } else {
        $(".investigation-section").stop(true, true).slideUp(250);
    }
}

function initializeInvestigationToggle() {
    toggleInvestigation();

    $("#is_investigated").on("change", toggleInvestigation);
}
