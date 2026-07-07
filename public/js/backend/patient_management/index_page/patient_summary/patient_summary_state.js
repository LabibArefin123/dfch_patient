$(function () {
    // "Yes" button click handler - resets field and focus for search
    $("#patientSearchAgain").on("click", function () {
        $("#patientSummarySearch").val("").focus();
        $("#patientSummaryAction").addClass("d-none");
    });

    // "No" button click handler - closes modal
    $("#patientSummaryClose").on("click", function () {
        $("#patientSummaryModal").modal("hide");
    });
});
