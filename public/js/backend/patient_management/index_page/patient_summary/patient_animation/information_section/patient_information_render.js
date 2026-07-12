(function () {
    function render(patient) {
        $("#patientAnimationInformationContainer").html(
            window.PatientInformationAnimate.template(patient),
        );
    }

    window.PatientInformationAnimate.render = render;
})();
