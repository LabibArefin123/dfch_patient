/**
 * --------------------------------------------------------------------------
 * Cancer
 * --------------------------------------------------------------------------
 */

function toggleCancer() {
    if ($("#is_old_cancer").val() == "1") {
        $("#cancerSection").stop(true, true).slideDown(300);
    } else {
        $("#cancerSection").stop(true, true).slideUp(300);
    }
}

function initializeCancerToggle() {
    toggleCancer();

    $("#is_old_cancer").on("change", function () {
        toggleCancer();
    });
}
