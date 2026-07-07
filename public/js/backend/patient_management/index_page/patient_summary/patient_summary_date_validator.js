function patientSummaryIsFutureSearch(keyword) {
    keyword = $.trim(keyword).toLowerCase();

    const today = new Date();
    today.setHours(0, 0, 0, 0);

    const keywords = [
        "today",
        "yesterday",
        "last 7 days",
        "last 30 days",
        "this month",
    ];

    if (keywords.includes(keyword)) {
        return false;
    }

    let date = null;

    if (/^\d{1,2}[\/-]\d{1,2}[\/-]\d{4}$/.test(keyword)) {
        const p = keyword.replace(/-/g, "/").split("/");

        date = new Date(p[2], p[1] - 1, p[0]);
    } else {
        const parsed = new Date(keyword);

        if (!isNaN(parsed.getTime())) {
            date = parsed;
        }
    }

    if (!date) return false;

    date.setHours(0, 0, 0, 0);

    return date > today;
}

function patientSummaryFutureWarning(callback) {
    appendBotMessage(`
<b>Future Date Detected</b><br><br>

The selected date is later than today's date.

These records are typically created for software testing, demonstrations, or development purposes.

Would you like to view these records?

<div class="mt-3">

<button class="btn btn-success btn-sm mr-2" id="patientFutureYes">

Yes, Show Records

</button>

<button class="btn btn-secondary btn-sm" id="patientFutureNo">

No, Continue Chat

</button>

</div>
`);

    $(document).off("click", "#patientFutureYes");

    $(document).on("click", "#patientFutureYes", function () {
        callback();
    });

    $(document).off("click", "#patientFutureNo");

    $(document).on("click", "#patientFutureNo", function () {
        appendBotMessage(
            "Future records were skipped. Please search using another patient name, phone number, patient code, or a valid date.",
        );
    });
}
