(function () {
    function animate() {
        $(".patient-information-wrapper")
            .removeClass("d-none")
            .hide()
            .fadeIn(700);
    }

    function complete() {
        $(".patient-information-status")
            .removeClass("text-warning")
            .addClass("text-success").html(`
            <i class="fas fa-check-circle mr-1"></i>
            Patient Information Loaded Successfully
        `);
    }

    window.PatientInformationAnimate.animate = animate;
    window.PatientInformationAnimate.complete = complete;
})();
