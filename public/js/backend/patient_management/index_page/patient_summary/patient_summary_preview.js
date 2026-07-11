/**
|--------------------------------------------------------------------------
| Patient Summary Preview
|--------------------------------------------------------------------------
| Opens the AI Preview modal and starts the animation.
|--------------------------------------------------------------------------
*/
$(document).on("click", ".patient-summary-preview", async function () {
    const patient = $(this).data("patient");

    if (!patient) return;

    // Open AI Preview Modal
    $("#patientAnimationModal").modal("show"); // Change to your modal id

    // Reset
    $("#patientAIProgressBar").css("width", "0%");
    $("#patientAIProgressPercent").text("0%");
    $("#patientAIStatusText").text("Initializing Medical Analysis...");
    $("#patientAISummaryGeneratedTime").text("--");

    $("#patientAITimeline").empty();

    PatientPhotoAnimate.clear();
    PatientInformationAnimate.clear();

    // Render Sections
    PatientPhotoAnimate.render(patient);
    PatientInformationAnimate.render(patient);

    // ============================
    // PHOTO ANIMATION
    // ============================

    $("#patientAIProgressBar").css("width", "25%");
    $("#patientAIProgressPercent").text("25%");
    $("#patientAIStatusText").text("Loading Patient Profile...");

    PatientPhotoAnimate.animate();

    await PatientPhotoAnimate.typing("Initializing AI engine...");
    await PatientPhotoAnimate.thinking(5);
    PatientPhotoAnimate.complete();

    // ============================
    // INFORMATION ANIMATION
    // ============================

    $("#patientAIProgressBar").css("width", "60%");
    $("#patientAIProgressPercent").text("60%");
    $("#patientAIStatusText").text("Analyzing Patient Information...");

    PatientInformationAnimate.animate();

    await PatientInformationAnimate.typing("Reading patient information...");
    await PatientInformationAnimate.thinking(5);
    PatientInformationAnimate.complete();

    PatientDocumentAnimate.render(patient);

    $("#patientAIProgressBar").css("width", "85%");
    $("#patientAIProgressPercent").text("85%");
    $("#patientAIStatusText").text("Analyzing Recommendation...");

    PatientDocumentAnimate.animate();

    await PatientDocumentAnimate.typing("Reading doctor's recommendation...");
    await PatientDocumentAnimate.thinking(5);
    PatientDocumentAnimate.complete();

    // ============================
    // FINISH
    // ============================

    $("#patientAIProgressBar").css("width", "100%");
    $("#patientAIProgressPercent").text("100%");
    $("#patientAIStatusText").html(
        '<i class="fas fa-check-circle mr-1"></i> Medical Analysis Completed',
    );

    $("#patientAISummaryGeneratedTime").text(new Date().toLocaleString());
});

function updateProgress(percent, status) {
    $("#patientAIProgressBar").css("width", percent + "%");

    $("#patientAIProgressPercent").text(percent + "%");

    $("#patientAIStatusText").text(status);
}
