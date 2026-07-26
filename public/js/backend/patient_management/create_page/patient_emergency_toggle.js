/**
|--------------------------------------------------------------------------
| Patient Emergency Toggle
|--------------------------------------------------------------------------
*/

function toggleEmergency() {
    if ($("#is_emergency").val() == "1") {
        $("#emergencyDetailsSection")
            .stop(true, true)
            .slideDown(250)
            .removeClass("d-none");
    } else {
        $("#emergencyDetailsSection")
            .stop(true, true)
            .slideUp(250, function () {
                $(this).addClass("d-none");
            });
    }
}

function initializeEmergencyToggle() {
    toggleEmergency();

    $("#is_emergency").on("change", function () {
        toggleEmergency();
    });
}

$(function () {
    initializeEmergencyToggle();
});
