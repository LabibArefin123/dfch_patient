document.addEventListener("DOMContentLoaded", () => {
    const progressCard = document.querySelector(".patient-progress-card");
    if (!progressCard) return;

    const progressItems = progressCard.querySelectorAll(".progress-item");
    if (progressItems.length < 3) return;

    const referralItem = progressItems[2];
    const step = referralItem.querySelector(".step");

    if (!step) return;

    injectReferralWaterCSS();

    const referredField = document.querySelector("#is_referred");
    const doctorField = document.querySelector(
        "input[name='referred_doctor_name']",
    );
    const noteField = document.querySelector("textarea[name='referred_note']");
    const documentsField = document.querySelector("input[name='documents[]']");

    function getEditorValue(textarea) {
        if (!textarea) return "";

        if (textarea.ckeditorInstance) {
            return textarea.ckeditorInstance
                .getData()
                .replace(/<[^>]*>/g, "")
                .trim();
        }

        return textarea.value.trim();
    }

    function hasExistingDocuments() {
        /*
        |----------------------------------------------------------------------
        | Existing Documents
        |----------------------------------------------------------------------
        | Edit page can contain already uploaded referral documents.
        | Look for the existing document elements using common selectors.
        */

        const existingDocuments = document.querySelectorAll(
            "[data-existing-document], .existing-document, .refer-document-item",
        );

        return existingDocuments.length > 0;
    }

    function hasDocuments() {
        /*
        |----------------------------------------------------------------------
        | Newly Selected Documents
        |----------------------------------------------------------------------
        */

        if (
            documentsField &&
            documentsField.files &&
            documentsField.files.length > 0
        ) {
            return true;
        }

        /*
        |----------------------------------------------------------------------
        | Previously Uploaded Documents
        |----------------------------------------------------------------------
        */

        return hasExistingDocuments();
    }

    function updateReferralProgress() {
        if (!referredField) return;

        let percent = 0;

        /*
        |----------------------------------------------------------------------
        | Not Referred
        |----------------------------------------------------------------------
        */

        if (referredField.value === "0") {
            step.style.setProperty("--fill", "100%");
            referralItem.classList.add("completed");

            return;
        }

        /*
        |----------------------------------------------------------------------
        | Referred Patient
        |----------------------------------------------------------------------
        */

        percent += 20;

        /*
        |----------------------------------------------------------------------
        | Referring Doctor
        |----------------------------------------------------------------------
        */

        if (doctorField && doctorField.value.trim() !== "") {
            percent += 25;
        }

        /*
        |----------------------------------------------------------------------
        | Referral Note
        |----------------------------------------------------------------------
        */

        if (getEditorValue(noteField) !== "") {
            percent += 35;
        }

        /*
        |----------------------------------------------------------------------
        | Referral Documents
        |----------------------------------------------------------------------
        */

        if (hasDocuments()) {
            percent += 20;
        }

        step.style.setProperty("--fill", percent + "%");

        referralItem.classList.toggle("completed", percent === 100);
    }

    /*
    |----------------------------------------------------------------------
    | Referral Status
    |----------------------------------------------------------------------
    */

    if (referredField) {
        referredField.addEventListener("change", updateReferralProgress);
    }

    /*
    |----------------------------------------------------------------------
    | Referring Doctor
    |----------------------------------------------------------------------
    */

    if (doctorField) {
        doctorField.addEventListener("input", updateReferralProgress);
        doctorField.addEventListener("change", updateReferralProgress);
    }

    /*
    |----------------------------------------------------------------------
    | Referral Documents
    |----------------------------------------------------------------------
    */

    if (documentsField) {
        documentsField.addEventListener("change", updateReferralProgress);
    }

    /*
    |----------------------------------------------------------------------
    | CKEditor
    |----------------------------------------------------------------------
    */

    const waitEditor = setInterval(() => {
        if (!noteField) {
            clearInterval(waitEditor);
            updateReferralProgress();
            return;
        }

        if (!noteField.ckeditorInstance) {
            return;
        }

        clearInterval(waitEditor);

        noteField.ckeditorInstance.model.document.on(
            "change:data",
            updateReferralProgress,
        );

        updateReferralProgress();
    }, 200);

    /*
    |----------------------------------------------------------------------
    | Initial Edit Page State
    |----------------------------------------------------------------------
    */

    updateReferralProgress();
});

function injectReferralWaterCSS() {
    if (document.getElementById("referral-progress-style")) return;

    const style = document.createElement("style");

    style.id = "referral-progress-style";

    style.innerHTML = `
.patient-progress-card .progress-item:nth-child(5) .step{
    position:relative;
    overflow:hidden;
}

.patient-progress-card .progress-item:nth-child(5) .step::before{
    content:"";
    position:absolute;
    left:0;
    right:0;
    bottom:0;
    height:var(--fill,0%);
    background:linear-gradient(180deg,#3b82f6,#2563eb);
    transition:height .4s ease;
    z-index:0;
}

.patient-progress-card .progress-item:nth-child(5) .step::after{
    content:"";
    position:absolute;
    left:-50%;
    width:200%;
    height:14px;
    bottom:calc(var(--fill,0%) - 7px);
    background:rgba(255,255,255,.35);
    border-radius:50%;
    animation:referralWave 2.5s linear infinite;
    z-index:1;
}

.patient-progress-card .progress-item:nth-child(5) .step i{
    position:relative;
    z-index:2;
}

@keyframes referralWave{
    from{
        transform:translateX(0);
    }
    to{
        transform:translateX(50%);
    }
}
`;

    document.head.appendChild(style);
}
