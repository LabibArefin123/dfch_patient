$(function () {
    if (!window.patientLostDataNotification) return;
    setupLostPatientDataActions();
    setTimeout(checkPendingPatientDrafts, 800);
});
