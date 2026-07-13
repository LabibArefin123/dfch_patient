/**
|--------------------------------------------------------------------------
| Patient Summary Tabs Helper
|--------------------------------------------------------------------------
*/

function updatePatientTabs(patient) {
    $("#documents-tab-item").addClass("d-none");
    $("#cancer-tab-item").addClass("d-none");

    if (!patient) {
        return;
    }

    if (Number(patient.is_recommend) === 1) {
        $("#documents-tab-item").removeClass("d-none");
    }

    if (Number(patient.is_old_cancer) === 1) {
        $("#cancer-tab-item").removeClass("d-none");
    }
}

function resetPatientTabs() {
    $("#documents-tab-item").addClass("d-none");
    $("#cancer-tab-item").addClass("d-none");

    $("#results-tab").tab("show");
}
