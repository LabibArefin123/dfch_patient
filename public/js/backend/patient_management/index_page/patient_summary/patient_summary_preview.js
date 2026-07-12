/**
|--------------------------------------------------------------------------
| Patient Summary Preview
|--------------------------------------------------------------------------
| Opens AI Preview Modal and performs sequential medical analysis.
|--------------------------------------------------------------------------
*/

$(document).on("click", ".patient-summary-preview", async function () {
    const patient = $(this).data("patient");

    if (!patient) return;

    /*
    |--------------------------------------------------------------------------
    | Open Modal
    |--------------------------------------------------------------------------
    */

    $("#patientAnimationModal").modal("show");

    /*
    |--------------------------------------------------------------------------
    | Reset AI Dashboard
    |--------------------------------------------------------------------------
    */

    updateProgress(0, "Initializing Medical Analysis...");

    $("#patientAISummaryGeneratedTime").text("--");
    $("#patientAITimeline").empty();

    /*
    |--------------------------------------------------------------------------
    | Clear Previous Sections
    |--------------------------------------------------------------------------
    */

    PatientPhotoAnimate.clear();
    PatientInformationAnimate.clear();
    PatientDocumentAnimate.clear();
    PatientCancerAnimate.clear();

    /*
    |--------------------------------------------------------------------------
    | Render All Sections
    |--------------------------------------------------------------------------
    */

    PatientPhotoAnimate.render(patient);
    PatientInformationAnimate.render(patient);
    PatientDocumentAnimate.render(patient);
    PatientCancerAnimate.render(patient);

    /*
    |--------------------------------------------------------------------------
    | PHOTO ANALYSIS
    |--------------------------------------------------------------------------
    */

    updateProgress(25, "Loading Patient Profile...");

    PatientPhotoAnimate.animate();

    await PatientPhotoAnimate.typing("Initializing AI engine...");
    await PatientPhotoAnimate.thinking(3);
    PatientPhotoAnimate.complete();

    /*
    |--------------------------------------------------------------------------
    | INFORMATION ANALYSIS
    |--------------------------------------------------------------------------
    */

    updateProgress(50, "Analyzing Patient Information...");

    PatientInformationAnimate.animate();

    await PatientInformationAnimate.typing("Reading patient information...");

    await PatientInformationAnimate.thinking(3);

    PatientInformationAnimate.complete();

    /*
    |--------------------------------------------------------------------------
    | RECOMMENDATION ANALYSIS
    |--------------------------------------------------------------------------
    */

    updateProgress(75, "Analyzing Doctor Recommendation...");

    PatientDocumentAnimate.animate();

    await PatientDocumentAnimate.typing("Reading doctor's recommendation...");

    await PatientDocumentAnimate.thinking(3);

    PatientDocumentAnimate.complete();

    /*
    |--------------------------------------------------------------------------
    | CANCER REPORT ANALYSIS
    |--------------------------------------------------------------------------
    */

    updateProgress(90, "Analyzing Cancer Reports...");

    PatientCancerAnimate.animate();

    await PatientCancerAnimate.typing("Scanning cancer reports...");

    await PatientCancerAnimate.thinking(3);

    PatientCancerAnimate.complete();

    /*
    |--------------------------------------------------------------------------
    | FINISHED
    |--------------------------------------------------------------------------
    */

    $("#patientAIProgressBar").css("width", "100%");

    $("#patientAIProgressPercent").text("100%");

    $("#patientAIStatusText").html(`
        <i class="fas fa-check-circle mr-1"></i>
        Medical Analysis Completed Successfully
    `);

    $("#patientAISummaryGeneratedTime").text(new Date().toLocaleString());
});

/**
|--------------------------------------------------------------------------
| Progress Helper
|--------------------------------------------------------------------------
*/

function updateProgress(percent, status) {
    $("#patientAIProgressBar").css("width", percent + "%");

    $("#patientAIProgressPercent").text(percent + "%");

    $("#patientAIStatusText").text(status);
}
