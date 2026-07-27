document.addEventListener("DOMContentLoaded", () => {
    const progressCard = document.querySelector(".patient-progress-card");
    if (!progressCard) return;

    const progressItems = progressCard.querySelectorAll(".progress-item");
    if (progressItems.length < 4) return;

    const treatmentItem = progressItems[3];
    const step = treatmentItem.querySelector(".step");

    injectTreatmentWaterCSS();

    const statusField = document.getElementById("is_treatment");
    const typeField = document.getElementById("treatment_type");
    const imageField = document.querySelector(
        "input[name='treatment_images[]']",
    );
    const summaryField = document.getElementById("edit_treatment_information");

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

    function updateTreatmentProgress() {
        let percent = 0;

        // If treatment is disabled
        if (!statusField || statusField.value !== "1") {
            step.style.setProperty("--fill", "0%");
            treatmentItem.classList.remove("completed");
            return;
        }

        // 30%
        if (typeField && typeField.value !== "") {
            percent += 30;
        }

        // 30%
        if (imageField && imageField.files && imageField.files.length > 0) {
            percent += 30;
        }

        // 40%
        if (getEditorValue(summaryField) !== "") {
            percent += 40;
        }

        step.style.setProperty("--fill", percent + "%");

        treatmentItem.classList.toggle("completed", percent === 100);
    }

    // Normal fields
    [statusField, typeField, imageField].filter(Boolean).forEach((field) => {
        field.addEventListener("change", updateTreatmentProgress);
        field.addEventListener("input", updateTreatmentProgress);
    });

    // Wait for CKEditor
    const waitEditor = setInterval(() => {
        if (!summaryField || !summaryField.ckeditorInstance) {
            return;
        }

        clearInterval(waitEditor);

        summaryField.ckeditorInstance.model.document.on(
            "change:data",
            updateTreatmentProgress,
        );

        updateTreatmentProgress();
    }, 200);

    updateTreatmentProgress();
});

function injectTreatmentWaterCSS() {
    if (document.getElementById("treatment-progress-style")) return;

    const style = document.createElement("style");

    style.id = "treatment-progress-style";

    style.innerHTML = `
.patient-progress-card .progress-item:nth-child(7) .step{
    position:relative;
    overflow:hidden;
}

.patient-progress-card .progress-item:nth-child(7) .step::before{
    content:"";
    position:absolute;
    left:0;
    right:0;
    bottom:0;
    height:var(--fill,0%);
    background:linear-gradient(180deg,#14b8a6,#0f766e);
    transition:height .4s ease;
    z-index:0;
}

.patient-progress-card .progress-item:nth-child(7) .step::after{
    content:"";
    position:absolute;
    left:-50%;
    width:200%;
    height:14px;
    bottom:calc(var(--fill,0%) - 7px);
    background:rgba(255,255,255,.35);
    border-radius:50%;
    animation:treatmentWave 2.5s linear infinite;
    z-index:1;
}

.patient-progress-card .progress-item:nth-child(7) .step i{
    position:relative;
    z-index:2;
}

@keyframes treatmentWave{
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
