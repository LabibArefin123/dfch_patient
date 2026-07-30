/**
 * Initialize Patient Summary Modal*/
function initializePatientSummaryModal() {
    $(document).on("click", ".view-complete-profile-btn", function () {
        const id = $(this).data("id");

        // Reset modal
        $("#viewModalPhoto").attr("src", "/uploads/images/default.jpg");

        $("#viewPatientInfoContainer").html(`
            <div class="col-12 text-center py-5">
                <i class="fas fa-spinner fa-spin fa-2x text-primary mb-2"></i>
                <p class="text-muted mb-0">
                    Fetching patient profile details...
                </p>
            </div>
        `);

        $("#viewPatientDocsContainer").empty();
        $("#viewPatientCancerPhotosContainer").empty();

        // Show modal immediately
        $("#patientViewModal").modal("show");

        // Load patient
        $.ajax({
            url: `/patients/${id}/modal-details`,
            type: "GET",

            success: function (res) {
                if (res.success && res.patient) {
                    populatePatientViewModal(res.patient);
                } else {
                    $("#viewPatientInfoContainer").html(`
                        <div class="col-12 text-danger text-center">
                            Failed to resolve patient records.
                        </div>
                    `);
                }
            },

            error: function () {
                $("#viewPatientInfoContainer").html(`
                    <div class="col-12 text-danger text-center">
                        Error communicating with server records.
                    </div>
                `);
            },
        });
    });
}

/**Populate Modal*/
function populatePatientViewModal(patient) {
    loadPatientInfo(patient);
    loadTreatmentSection(patient);
    loadInvestigationSection(patient);
    loadPatientDocuments(patient);
    loadCancerReports(patient);
}
