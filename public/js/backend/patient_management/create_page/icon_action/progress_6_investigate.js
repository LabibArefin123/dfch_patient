document.addEventListener("DOMContentLoaded", () => {
    const progressCard = document.querySelector(".patient-progress-card");
    if (!progressCard) return;

    const progressItems = progressCard.querySelectorAll(".progress-item");
    if (progressItems.length < 5) return;

    const investigationItem = progressItems[4];
    const step = investigationItem.querySelector(".step");

    injectInvestigationWaterCSS();

    const statusField = document.getElementById("is_investigated");
    const imageField = document.querySelector(
        "input[name='investigation_images[]']",
    );
    const summaryField = document.getElementById("investigation_information");

    function getEditorValue(textarea) {
        if (!textarea) return "";

        if (textarea.ckeditorInstance) {
            return textarea.ckeditorInstance
                .getData()
                .replace(/<[^>]*>/g, "")
                .trim();
        }

        if (window.CKEDITOR && CKEDITOR.instances[textarea.id]) {
            return CKEDITOR.instances[textarea.id]
                .getData()
                .replace(/<[^>]*>/g, "")
                .trim();
        }

        return textarea.value.trim();
    }

    function updateInvestigationProgress() {
        let percent = 0;

        if (!statusField || statusField.value !== "1") {
            step.style.setProperty("--fill", "0%");
            investigationItem.classList.remove("completed");

            return;
        }

        // Images = 50%
        if (imageField && imageField.files.length > 0) {
            percent += 50;
        }

        // Summary = 50%
        if (getEditorValue(summaryField) !== "") {
            percent += 50;
        }

        step.style.setProperty("--fill", percent + "%");

        investigationItem.classList.toggle("completed", percent === 100);
    }

    [statusField, imageField].filter(Boolean).forEach((field) => {
        field.addEventListener("change", updateInvestigationProgress);
        field.addEventListener("input", updateInvestigationProgress);
    });

    const waitEditor = setInterval(() => {
        if (!summaryField) return;

        if (summaryField.ckeditorInstance) {
            clearInterval(waitEditor);

            summaryField.ckeditorInstance.model.document.on(
                "change:data",
                updateInvestigationProgress,
            );

            updateInvestigationProgress();

            return;
        }

        if (window.CKEDITOR && CKEDITOR.instances[summaryField.id]) {
            clearInterval(waitEditor);

            CKEDITOR.instances[summaryField.id].on(
                "change",
                updateInvestigationProgress,
            );

            updateInvestigationProgress();
        }
    }, 200);

    updateInvestigationProgress();
});

function injectInvestigationWaterCSS() {
    if (document.getElementById("investigation-progress-style")) {
        return;
    }

    const style = document.createElement("style");

    style.id = "investigation-progress-style";

    style.innerHTML = `
.patient-progress-card .progress-item:nth-child(9) .step{
    position:relative;
    overflow:hidden;
}

.patient-progress-card .progress-item:nth-child(9) .step::before{
    content:"";
    position:absolute;
    left:0;
    right:0;
    bottom:0;
    height:var(--fill,0%);
    background:linear-gradient(180deg,#f59e0b,#d97706);
    transition:height .4s ease;
    z-index:0;
}

.patient-progress-card .progress-item:nth-child(9) .step::after{
    content:"";
    position:absolute;
    left:-50%;
    width:200%;
    height:14px;
    bottom:calc(var(--fill,0%) - 7px);
    background:rgba(255,255,255,.35);
    border-radius:50%;
    animation:investigationWave 2.5s linear infinite;
    z-index:1;
}

.patient-progress-card .progress-item:nth-child(9) .step i{
    position:relative;
    z-index:2;
}

@keyframes investigationWave{
    from{transform:translateX(0);}
    to{transform:translateX(50%);}
}
`;

    document.head.appendChild(style);
}
