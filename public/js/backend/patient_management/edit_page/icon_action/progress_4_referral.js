/**
 * ==========================================================
 * PATIENT PROGRESS - REFERRAL
 * ==========================================================
 *
 * Works on:
 * - Create page
 * - Edit page
 * - Existing referral values
 * - Existing referral documents
 * - CKEditor referral note
 *
 * Progress:
 *
 * Not Referred
 *      = 100%
 *
 * Referred
 *      Referral status       = 20%
 *      Referred doctor       = 25%
 *      Referral note         = 35%
 *      Referral documents   = 20%
 *      --------------------------------
 *      Total                = 100%
 * ==========================================================
 */

document.addEventListener("DOMContentLoaded", () => {
    const referralItem = document.querySelector(
        '.patient-progress-card .progress-item[data-target="part_4_referral"]',
    );

    if (!referralItem) {
        console.warn("Referral progress item not found.");
        return;
    }

    const step = referralItem.querySelector(".step");

    if (!step) {
        console.warn("Referral progress step not found.");
        return;
    }

    // ------------------------------------------------------
    // Inject referral progress CSS
    // ------------------------------------------------------

    injectReferralWaterCSS();

    // ------------------------------------------------------
    // Fields
    // ------------------------------------------------------

    const referredField = document.querySelector("#is_referred");

    const doctorField = document.querySelector(
        "input[name='referred_doctor_name']",
    );

    const noteField = document.querySelector("textarea[name='referred_note']");

    const documentsField = document.querySelector("input[name='documents[]']");

    // ------------------------------------------------------
    // Get textarea / CKEditor value
    // ------------------------------------------------------

    function getEditorValue(textarea) {
        if (!textarea) {
            return "";
        }

        // CKEditor 5
        if (textarea.ckeditorInstance) {
            return textarea.ckeditorInstance
                .getData()
                .replace(/<[^>]*>/g, "")
                .replace(/&nbsp;/g, " ")
                .trim();
        }

        // Normal textarea
        return textarea.value
            .replace(/<[^>]*>/g, "")
            .replace(/&nbsp;/g, " ")
            .trim();
    }

    // ------------------------------------------------------
    // Check existing referral documents
    // ------------------------------------------------------
    //
    // On edit page:
    //
    // $documents already contains previously uploaded files.
    //
    // The file input itself is EMPTY because browsers do not
    // allow existing files to be placed inside <input type=file>.
    //
    // Therefore we detect the existing document cards.
    // ------------------------------------------------------

    function hasExistingDocuments() {
        const existingDocuments = document.querySelectorAll(
            "#part_4_referral .recommendation-document-card",
        );

        return existingDocuments.length > 0;
    }

    // ------------------------------------------------------
    // Check newly selected documents
    // ------------------------------------------------------

    function hasNewDocuments() {
        return (
            documentsField &&
            documentsField.files &&
            documentsField.files.length > 0
        );
    }

    // ------------------------------------------------------
    // Update Referral Progress
    // ------------------------------------------------------

    function updateReferralProgress() {
        if (!referredField) {
            step.style.setProperty("--fill", "0%");
            referralItem.classList.remove("completed");
            return;
        }

        let percent = 0;

        const referredValue = String(referredField.value).trim();

        // --------------------------------------------------
        // NOT REFERRED
        // --------------------------------------------------

        if (referredValue === "0") {
            percent = 100;

            step.style.setProperty("--fill", "100%");
            referralItem.classList.add("completed");

            return;
        }

        // --------------------------------------------------
        // REFERRED
        // --------------------------------------------------

        if (referredValue === "1") {
            // Referral status
            percent += 20;

            // ------------------------------------------------
            // Referred Doctor
            // ------------------------------------------------

            if (doctorField && doctorField.value.trim() !== "") {
                percent += 25;
            }

            // ------------------------------------------------
            // Referral Note
            // ------------------------------------------------

            if (getEditorValue(noteField) !== "") {
                percent += 35;
            }

            // ------------------------------------------------
            // Documents
            //
            // Either:
            // - Existing documents on edit page
            // - Newly selected documents
            // ------------------------------------------------

            if (hasExistingDocuments() || hasNewDocuments()) {
                percent += 20;
            }
        }

        // --------------------------------------------------
        // Safety
        // --------------------------------------------------

        percent = Math.min(100, Math.max(0, percent));

        // --------------------------------------------------
        // Apply progress
        // --------------------------------------------------

        step.style.setProperty("--fill", `${percent}%`);

        referralItem.classList.toggle("completed", percent === 100);
    }

    // ------------------------------------------------------
    // Referral Status
    // ------------------------------------------------------

    if (referredField) {
        referredField.addEventListener("change", updateReferralProgress);
    }

    // ------------------------------------------------------
    // Doctor Name
    // ------------------------------------------------------

    if (doctorField) {
        doctorField.addEventListener("input", updateReferralProgress);

        doctorField.addEventListener("change", updateReferralProgress);
    }

    // ------------------------------------------------------
    // Documents
    // ------------------------------------------------------

    if (documentsField) {
        documentsField.addEventListener("change", updateReferralProgress);
    }

    // ------------------------------------------------------
    // CKEditor
    // ------------------------------------------------------

    let editorCheckCount = 0;

    const waitForReferralEditor = setInterval(() => {
        editorCheckCount++;

        // CKEditor exists
        if (noteField && noteField.ckeditorInstance) {
            clearInterval(waitForReferralEditor);

            noteField.ckeditorInstance.model.document.on(
                "change:data",
                updateReferralProgress,
            );

            updateReferralProgress();

            return;
        }

        // --------------------------------------------------
        // Do not wait forever
        //
        // This is important for edit page if CKEditor
        // initialization fails or is not present.
        // --------------------------------------------------

        if (editorCheckCount >= 50) {
            clearInterval(waitForReferralEditor);

            updateReferralProgress();
        }
    }, 200);

    // ------------------------------------------------------
    // Initial state
    //
    // This runs immediately so database values on the
    // edit page are recognized even before CKEditor loads.
    // ------------------------------------------------------

    updateReferralProgress();
});

/**
 * ==========================================================
 * REFERRAL WATER PROGRESS CSS
 * ==========================================================
 */

function injectReferralWaterCSS() {
    if (document.getElementById("referral-progress-style")) {
        return;
    }

    const style = document.createElement("style");

    style.id = "referral-progress-style";

    style.innerHTML = `
        /*
         * Referral progress icon
         */
        .patient-progress-card
        .progress-item[data-target="part_4_referral"]
        .step {
            position: relative;
            overflow: hidden;
        }

        /*
         * Water fill
         */
        .patient-progress-card
        .progress-item[data-target="part_4_referral"]
        .step::before {
            content: "";
            position: absolute;

            left: 0;
            right: 0;
            bottom: 0;

            height: var(--fill, 0%);

            background: linear-gradient(
                180deg,
                #3b82f6,
                #2563eb
            );

            transition: height 0.4s ease;

            z-index: 0;
        }

        /*
         * Moving water wave
         */
        .patient-progress-card
        .progress-item[data-target="part_4_referral"]
        .step::after {
            content: "";

            position: absolute;

            left: -50%;

            width: 200%;
            height: 14px;

            bottom: calc(
                var(--fill, 0%) - 7px
            );

            background: rgba(
                255,
                255,
                255,
                0.35
            );

            border-radius: 50%;

            animation:
                referralWave
                2.5s linear infinite;

            z-index: 1;
        }

        /*
         * Keep icon above water
         */
        .patient-progress-card
        .progress-item[data-target="part_4_referral"]
        .step i {
            position: relative;
            z-index: 2;
        }

        /*
         * Referral wave animation
         */
        @keyframes referralWave {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(50%);
            }
        }
    `;

    document.head.appendChild(style);
}
