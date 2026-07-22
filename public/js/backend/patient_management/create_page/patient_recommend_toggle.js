/**
 * --------------------------------------------------------------------------
 * Recommendation
 * --------------------------------------------------------------------------
 */

function toggleRecommend() {
    if ($("#is_recommend").val() == "1") {
        $(".recommend-section").removeClass("d-none");
    } else {
        $(".recommend-section").addClass("d-none");
    }
}

function initializeRecommendToggle() {
    toggleRecommend();

    $("#is_recommend").on("change", function () {
        toggleRecommend();
    });
}
