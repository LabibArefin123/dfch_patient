(function () {
    function animate() {
        $(".patient-document-wrapper").removeClass("d-none").hide().fadeIn(700);
    }

    function complete() {
        $(".patient-document-status")
            .removeClass("text-warning")
            .addClass("text-success").html(`
            <i class="fas fa-check-circle mr-1"></i>
            Recommendation Analysis Completed Successfully
        `);
    }

    window.PatientDocumentAnimate.animate = animate;
    window.PatientDocumentAnimate.complete = complete;
})();
