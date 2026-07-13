/**
|--------------------------------------------------------------------------
| Patient Chat Validator
|--------------------------------------------------------------------------
*/

function patientChatClosedWarning() {
    if (!window.PatientSummaryState.chatClosed) {
        return false;
    }

    $("#patientChatClosedModal").modal("show");

    return true;
}
