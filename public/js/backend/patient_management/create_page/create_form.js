document.addEventListener("DOMContentLoaded", function () {
    initializeLocationToggle();
    initializeRecommendToggle();
});

/*
|--------------------------------------------------------------------------
| Location
|--------------------------------------------------------------------------
*/

function toggleLocation() {
    $(".location").addClass("d-none");
    $(".location-" + $("#location_type").val()).removeClass("d-none");
}

function initializeLocationToggle() {
    toggleLocation();
    $("#location_type").on("change", toggleLocation);
}

/*
|--------------------------------------------------------------------------
| Recommendation
|--------------------------------------------------------------------------
*/

function toggleRecommend() {
    if ($("#is_recommend").val() == 1) {
        $(".recommend-section").removeClass("d-none");
    } else {
        $(".recommend-section").addClass("d-none");
    }
}

function initializeRecommendToggle() {
    toggleRecommend();
    $("#is_recommend").on("change", toggleRecommend);
}
