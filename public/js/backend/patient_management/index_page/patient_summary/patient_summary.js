$(function () {
    $("#patientSummaryModal").on("shown.bs.modal", function () {
        $("#patientSummarySearch").focus();
    });

    $("#patientSummarySearch").on("keypress", function (e) {
        if (e.which == 13) {
            $("#patientSummarySearchBtn").click();
        }
    });

    $("#patientSummarySearchBtn").on("click", function () {
        patientSummarySearch();
    });

    $("#patientSearchAgain").on("click", function () {
        $("#patientSummarySearch").val("").focus();

        $("#patientSummaryAction").addClass("d-none");
    });

    $("#patientSummaryClose").on("click", function () {
        $("#patientSummaryModal").modal("hide");
    });
});
