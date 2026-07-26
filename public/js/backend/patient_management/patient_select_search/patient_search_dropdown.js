window.PatientSearch = window.PatientSearch || {};

window.PatientSearch.toggleLocationField = function () {
    const type = $("select[name=location_type]").val();

    const wrapper = $("#locationValueWrapper");

    if (type === "") {
        wrapper.hide();
        $("input[name=location_value]").val("");
    } else {
        wrapper.show();
    }
};
