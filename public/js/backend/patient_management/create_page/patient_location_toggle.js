/**
 * --------------------------------------------------------------------------
 * Location
 * --------------------------------------------------------------------------
 */

function toggleLocation() {
    $(".location").addClass("d-none");

    $(".location-" + $("#location_type").val()).removeClass("d-none");
}

function initializeLocationToggle() {
    toggleLocation();

    $("#location_type").on("change", function () {
        toggleLocation();
    });
}
