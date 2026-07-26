window.PatientSearch = window.PatientSearch || {};

window.PatientSearch.toggleDateFilter = function () {
    const value = $("#dateFilter").val();

    if (value === "custom") {
        $("#startDateDiv").removeClass("d-none");
        $("#endDateDiv").removeClass("d-none");
    } else {
        $("#startDateDiv").addClass("d-none");
        $("#endDateDiv").addClass("d-none");

        $("input[name=from_date]").val("");
        $("input[name=to_date]").val("");
    }
};
