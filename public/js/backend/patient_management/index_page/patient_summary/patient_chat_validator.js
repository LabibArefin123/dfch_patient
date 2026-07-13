/**
|--------------------------------------------------------------------------
| Patient Chat Validator
|--------------------------------------------------------------------------
*/

function patientChatClosedWarning() {
    if (!window.PatientSummaryState.chatClosed) {
        return false;
    }

    const modal = document.getElementById("patientChatClosedModal");

    if (typeof bootstrap !== "undefined" && bootstrap.Modal) {
        bootstrap.Modal.getOrCreateInstance(modal).show();
    } else {
        $("#patientChatClosedModal").modal("show");
    }

    return true;
}
