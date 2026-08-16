$(function () {
    "use strict";

    $(document).on("click", ".patient-full-reason-btn", function () {
        const reason = $(this).attr("data-reason") || "-";
        $("#patientFullReasonContent").text(reason);
        $("#patientFullReasonModal").modal("show");
    });
});
