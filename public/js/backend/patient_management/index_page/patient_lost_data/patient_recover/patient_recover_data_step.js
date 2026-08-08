function restorePatientStep(step) {
    window.recoveredPatientStep = step;
    if (typeof window.goToPatientStep === "function") {
        window.goToPatientStep(step);
    }
}
