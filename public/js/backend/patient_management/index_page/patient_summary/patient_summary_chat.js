function getCurrentDateTime() {
    const now = new Date();

    const date = now.toLocaleDateString("en-GB", {
        day: "numeric",
        month: "long",
        year: "numeric",
    });

    const time = now.toLocaleTimeString("en-US", {
        hour: "numeric",
        minute: "2-digit",
        hour12: true,
    });

    return {
        date,
        time,
    };
}

function appendBotMessage(message) {
    const current = getCurrentDateTime();

    $("#patientSummaryChat").append(`
        <div class="d-flex mb-4">
            <div class="me-3">
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center shadow"
                     style="width:45px;height:45px;">
                    <i class="fas fa-user-md"></i>
                </div>
            </div>

            <div style="max-width:80%;">
                <div class="bg-white border rounded-4 shadow-sm px-3 py-2">
                    <div class="fw-bold text-primary mb-1">
                        Assistant
                    </div>

                    <div class="text-dark">
                        ${message}
                    </div>
                </div>

                <small class="text-muted ms-2">
                    ${current.date} • Response Time: ${current.time}
                </small>
            </div>
        </div>
    `);

    scrollPatientChat();
}

function appendUserMessage(message) {
    const current = getCurrentDateTime();

    $("#patientSummaryChat").append(`
        <div class="d-flex justify-content-end mb-4">

            <div class="text-end" style="max-width:80%;">
                <div class="bg-primary text-white rounded-4 shadow-sm px-3 py-2">
                    <div class="fw-bold mb-1">
                        You
                    </div>

                    <div>
                        ${message}
                    </div>
                </div>

                <small class="text-muted me-2">
                    ${current.date} • ${current.time}
                </small>
            </div>

            <div class="ms-3">
                <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center shadow"
                     style="width:45px;height:45px;">
                    <i class="fas fa-user"></i>
                </div>
            </div>

        </div>
    `);

    scrollPatientChat();
}
