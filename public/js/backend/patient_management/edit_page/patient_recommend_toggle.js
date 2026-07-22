/**
 * --------------------------------------------------------------------------
 * Recommendation
 * --------------------------------------------------------------------------
 */

function toggleRecommend() {
    if ($("#is_recommend").val() == "1") {
        $(".recommend-section").stop(true, true).slideDown(250);
    } else {
        $(".recommend-section").stop(true, true).slideUp(250);
    }
}

function initializeRecommendToggle() {
    toggleRecommend();

    $("#is_recommend").on("change", toggleRecommend);
}
