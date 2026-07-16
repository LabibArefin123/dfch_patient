$(document).on("submit", "#patientEmergencyForm", function (e) {
    e.preventDefault();

    if (window.selectedPatients.length === 0) {
        toastr.warning("Please select at least one patient.");
        return;
    }

    const formData = new FormData(this);

    formData.delete("patient_ids");

    window.selectedPatients.forEach(function (id) {
        formData.append("patient_ids[]", id);
    });

    $.ajax({
        url: window.patientRoutes.index,
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        beforeSend() {
            $("#patientEmergencyForm button[type='submit']").prop(
                "disabled",
                true,
            );
        },

        success(res) {
            toastr.success(res.message);

            bootstrap.Modal.getInstance(
                document.getElementById("patientEmergencyModal"),
            ).hide();

            $("#patientsTable").DataTable().ajax.reload(null, false);

            window.selectedPatients = [];

            $("#patientEmergencyForm")[0].reset();

            $("#selectedPatientCount").text(0);

            $("#selectedPatientBadge").text("0 Selected");

            $("#selectedPatientList").html(`
                <div class="text-center text-muted py-4">
                    No patients selected.
                </div>
            `);

            $(".row-checkbox").prop("checked", false);

            $("#checkAll").prop("checked", false);
        },

        error(xhr) {
            if (xhr.status === 422) {
                $.each(xhr.responseJSON.errors, function (_, value) {
                    toastr.error(value[0]);
                });

                return;
            }

            toastr.error("Unable to update emergency status.");
        },

        complete() {
            $("#patientEmergencyForm button[type='submit']").prop(
                "disabled",
                false,
            );
        },
    });
});
