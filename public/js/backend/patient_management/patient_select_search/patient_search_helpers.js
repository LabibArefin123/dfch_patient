window.PatientSearch = window.PatientSearch || {};

window.PatientSearch.loadFromUrl = function () {
    const params = new URLSearchParams(window.location.search);

    if (params.has("date_filter")) {
        $("#dateFilter").val(params.get("date_filter"));
    }

    if (params.has("location_type")) {
        $("select[name=location_type]").val(params.get("location_type"));
    }
};
