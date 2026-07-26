window.patientEmergencyAjax = {
    submit(formData) {
        $.ajax({
            url: patientEmergencyUrl,

            type: "POST",

            data: formData,

            processData: false,

            contentType: false,

            beforeSend() {
                if (window.patientEmergencySubmit.submitting) {
                    return false;
                }

                window.patientEmergencySubmit.start();
            },

            success(response) {
                window.patientEmergencyHandler.success(response);
            },

            error(xhr) {
                window.patientEmergencyHandler.error(xhr);
            },
        });
    },
};
