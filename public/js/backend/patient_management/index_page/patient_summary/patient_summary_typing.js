function patientTyping(text = "Searching patient...") {
    $("#patientTyping")
        .removeClass("d-none")
        .html('<i class="fas fa-spinner fa-spin mr-1"></i>' + text);
}
function patientTypingDone() {
    $("#patientTyping").addClass("d-none");
}
function patientThinking() {
    patientTyping("Thinking...");
}
function patientSearching() {
    patientTyping("Searching patient...");
}
function patientLoading() {
    patientTyping("Loading patient information...");
}
