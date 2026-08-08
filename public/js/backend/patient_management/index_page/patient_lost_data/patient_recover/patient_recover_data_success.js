function showRecoverySuccess() {
    if (typeof toastr !== "undefined") {
        toastr.success("Your unfinished patient data has been restored.");
        return;
    }
    alert("Your unfinished patient data has been restored.");
}
