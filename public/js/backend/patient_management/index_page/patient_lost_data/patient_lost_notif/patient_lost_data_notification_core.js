let currentLostPatientDraft = null;

function initializeLostPatientDataNotification() {
    const notification = $("#patientLostDataNotification");
    if (!notification.length) return;
    window.patientLostDataNotification = {
        notification: notification,
        countElement: $("#lostPatientDataCount"),
        recoverButton: $("#recoverPatientDataBtn"),
        discardButton: $("#discardPatientDataBtn"),
        closeButton: $("#closePatientLostDataNotification"),
    };
}
