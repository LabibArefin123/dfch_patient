window.patientEmergencyHandler = {
    success(response) {
        window.patientEmergencySubmit.finish(() => {
            toastr.success(response.message);

            this.resetForm();

            window.patientTable.ajax.reload(null, false);
        });
    },

    error(xhr) {
        window.patientEmergencySubmit.failed();

        if (xhr.status === 422) {
            $.each(xhr.responseJSON.errors, function (_, value) {
                toastr.error(value[0]);
            });

            return;
        }

        toastr.error("Unable to update emergency status.");
    },
    
    resetForm() {
        window.selectedPatients = [];

        $("#patientEmergencyForm")[0].reset();

        $(".row-checkbox").prop("checked", false);

        $("#checkAll").prop("checked", false);

        updateSelectedPatients();

        window.patientEmergencyValidator.updateProgress();
    },
};
