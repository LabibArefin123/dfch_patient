window.PatientSearch = window.PatientSearch || {};

window.PatientSearch.bindEvents = function () {
    $("#dateFilter").on("change", function () {
        PatientSearch.toggleDateFilter();
    });

    $("select[name=location_type]").on("change", function () {
        PatientSearch.toggleLocationField();
    });

    $("#patientFilterForm").on("submit", function (e) {
        if (window.patientTable) {
            window.patientTable.ajax.reload();
        }
    });
};
