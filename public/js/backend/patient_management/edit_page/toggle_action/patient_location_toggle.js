/**
 * --------------------------------------------------------------------------
 * Location
 * --------------------------------------------------------------------------
 */

function toggleLocation() {
    $(".location").hide();

    $(".location-" + $("#location_type").val()).show();
}

function initializeLocationToggle() {
    toggleLocation();

    $("#location_type").on("change", toggleLocation);
}
