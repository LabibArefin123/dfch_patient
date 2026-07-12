(function () {
    function render(patient) {
        $("#patientAnimationCancerContainer").html(
            window.PatientCancerAnimate.template(patient),
        );
    }

    window.PatientCancerAnimate.render = render;
})();
