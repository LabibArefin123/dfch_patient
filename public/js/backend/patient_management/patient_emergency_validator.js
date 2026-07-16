window.patientEmergencyValidator = {
    validate() {
        const errors = [];

        if (window.selectedPatients.length === 0) {
            errors.push("Please select at least one patient.");
        }

        if ($("#isEmergency").val() === "") {
            errors.push("Please select an emergency status.");
        }

        return {
            valid: errors.length === 0,
            errors: errors,
        };
    },

    updateProgress() {
        let percent = 0;

        if (window.selectedPatients.length > 0) percent += 40;

        if ($("#isEmergency").val() !== "") percent += 40;

        if ($.trim($("textarea[name='reason']").val()).length > 0)
            percent += 20;

        $("#emergencyProgressValue").text(percent + "%");

        $("#emergencyProgressCircle").css("--progress", percent);

        return percent;
    },
};

$(document).on(
    "change input",
    "#isEmergency, textarea[name='reason'], .row-checkbox",
    function () {
        window.patientEmergencyValidator.updateProgress();
    },
);
