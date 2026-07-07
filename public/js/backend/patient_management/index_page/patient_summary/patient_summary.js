$(function () {
    // Focus search input when modal opens
    $("#patientSummaryModal").on("shown.bs.modal", function () {
        $("#patientSummarySearch").focus();
    });

    // Trigger search on "Enter" keypress
    $("#patientSummarySearch").on("keypress", function (e) {
        if (e.which == 13) {
            $("#patientSummarySearchBtn").click();
        }
    });

    // Trigger search on button click
    $("#patientSummarySearchBtn").on("click", function () {
        patientSummarySearch();
    });
});
