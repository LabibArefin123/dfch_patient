/**
 * --------------------------------------------------------------------------
 * Investigation
 * --------------------------------------------------------------------------
 */

function toggleInvestigation() {
    if ($("#is_investigated").val() == "1") {
        $("#investigationSection").stop(true, true).slideDown(300);
    } else {
        $("#investigationSection").stop(true, true).slideUp(300);
    }
}

function initializeInvestigationToggle() {
    toggleInvestigation();

    $("#is_investigated").on("change", function () {
        toggleInvestigation();
    });
}
