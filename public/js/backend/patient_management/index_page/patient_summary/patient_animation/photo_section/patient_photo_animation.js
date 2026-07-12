(function () {
    function animate() {
        const wrapper = $(".patient-ai-photo-wrapper");

        wrapper.removeClass("d-none").hide().fadeIn(500);

        setTimeout(() => {
            $("#patientAnimationPhoto").css({
                opacity: 1,
                transform: "scale(1)",
            });
        }, 250);
    }

    function complete() {
        $(".patient-ai-status")
            .removeClass("text-warning")
            .addClass("text-success").html(`
            <i class="fas fa-check-circle mr-1"></i>
            Patient Profile Loaded Successfully
        `);
    }

    window.PatientPhotoAnimate.animate = animate;
    window.PatientPhotoAnimate.complete = complete;
})();
    