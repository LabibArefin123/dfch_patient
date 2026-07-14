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

    // Recommendation tab
    if (Number(patient.is_recommend) === 1) {
        $("#documents-tab-item").removeClass("d-none");
    }

    // Old X-Ray tab
    if (
        Number(patient.cancer_photos_count || 0) > 0 ||
        (Array.isArray(patient.cancer_photos) &&
            patient.cancer_photos.length > 0)
    ) {
        $("#cancer-tab-item").removeClass("d-none");
    }
}

function resetPatientTabs() {
    $("#documents-tab-item").addClass("d-none");

    $("#cancer-tab-item").addClass("d-none");

    $("#results-tab").tab("show");
}

function resetPatientTabs() {
    $("#documents-tab-item").addClass("d-none");
    $("#cancer-tab-item").addClass("d-none");

    $("#results-tab").tab("show");
}
