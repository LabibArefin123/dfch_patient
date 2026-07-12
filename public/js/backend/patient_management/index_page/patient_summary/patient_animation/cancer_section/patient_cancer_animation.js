/**
|--------------------------------------------------------------------------
| Patient Cancer Animation
|--------------------------------------------------------------------------
| Responsible for:
| - Show Animation
| - Complete Status
| - Clear Container
|--------------------------------------------------------------------------
*/

(function () {
    /**
     * Animate Section
     */
    function animate() {
        $(".patient-cancer-wrapper").removeClass("d-none").hide().fadeIn(700);
    }

    /**
     * Completed
     */
    function complete() {
        $(".patient-cancer-status")
            .removeClass("text-warning")
            .addClass("text-success").html(`
                <i class="fas fa-check-circle mr-1"></i>
                Cancer Report Analysis Completed Successfully
            `);
    }

    /**
     * Clear
     */
    function clear() {
        $("#patientAnimationCancerContainer").empty();
    }

    window.PatientCancerAnimate.animate = animate;
    window.PatientCancerAnimate.complete = complete;
    window.PatientCancerAnimate.clear = clear;
})();
