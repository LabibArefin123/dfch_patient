function showLostPatientDataNotification(count, draft) {
    if (!window.patientLostDataNotification) return;
    currentLostPatientDraft = draft;
    const notification = window.patientLostDataNotification.notification;
    window.patientLostDataNotification.countElement.text(count);
    notification.stop(true, true).fadeIn(300);
}

function hideLostPatientDataNotification() {
    if (!window.patientLostDataNotification) return;
    window.patientLostDataNotification.notification
        .stop(true, true)
        .fadeOut(300);
    currentLostPatientDraft = null;
}
