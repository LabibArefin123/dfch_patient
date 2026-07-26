window.PatientSearch = window.PatientSearch || {};

window.PatientSearch.init = function () {
    PatientSearch.bindEvents();
    PatientSearch.toggleDateFilter();
    PatientSearch.toggleLocationField();
    PatientSearch.loadFromUrl();
};
