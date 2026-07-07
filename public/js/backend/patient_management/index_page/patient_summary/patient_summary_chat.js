function appendBotMessage(message) {
    $("#patientSummaryChat").append(`
<div class="mb-3 d-flex">
    <div class="bg-light border rounded p-2" style="max-width:85%;">
        <strong class="text-primary">
            <i class="fas fa-user-md"></i> Assistant
        </strong>
        <div class="mt-1">${message}</div>
    </div>
</div>
`);

    scrollPatientChat();
}

function appendUserMessage(message) {
    $("#patientSummaryChat").append(`
<div class="mb-3 d-flex justify-content-end">
    <div class="bg-primary text-white rounded p-2" style="max-width:85%;">
        <strong>
            <i class="fas fa-user"></i> You
        </strong>
        <div class="mt-1">${message}</div>
    </div>
</div>
`);

    scrollPatientChat();
}
