/**
 * --------------------------------------------------------------------------
 * Recommendation
 * --------------------------------------------------------------------------
 */

function toggleRecommend() {
    if ($("#is_referred").val() == "1") {
        $(".recommend-section").removeClass("d-none");
    } else {
        $(".recommend-section").addClass("d-none");
    }
}

function initializeRecommendToggle() {
    toggleRecommend();

    $("#is_referred").on("change", function () {
        toggleRecommend();
    });
}
