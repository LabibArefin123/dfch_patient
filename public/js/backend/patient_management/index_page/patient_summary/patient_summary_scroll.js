/**
 * Scroll Utility for Patient Summary Chat Interface
 */
function scrollPatientChat() {
    const chat = $("#patientSummaryChat");
    if (chat.length > 0) {
        chat.stop().animate(
            {
                scrollTop: chat[0].scrollHeight,
            },
            300,
        );
    }
}
