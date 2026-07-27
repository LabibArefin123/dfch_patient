document.addEventListener("DOMContentLoaded", function () {
    initializeEditors();
    initializeLocationToggle();
    initializeRecommendToggle();
    initializeTreatmentToggle();
    initializeInvestigationToggle();
    initializeEmergencyToggle();
    initializeCancerToggle();

    // wait for all animations
    setTimeout(function () {
        document.dispatchEvent(new CustomEvent("patient-form-ready"));
    }, 350);
});
