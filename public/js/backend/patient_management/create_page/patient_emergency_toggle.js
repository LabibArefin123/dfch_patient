/**
 * ==========================================================================
 * Patient Emergency Toggle
 * ==========================================================================
 */

function toggleEmergency() {
    // Reserved for future emergency fields.
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
