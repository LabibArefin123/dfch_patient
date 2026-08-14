/**
|--------------------------------------------------------------------------
| Progress 6 - Emergency
|--------------------------------------------------------------------------
| ✔ Emergency Progress
| ✔ Water Animation
|--------------------------------------------------------------------------
*/

document.addEventListener("DOMContentLoaded", () => {
    const progressCard = document.querySelector(".patient-progress-card");

    if (!progressCard) return;

    const progressItems = progressCard.querySelectorAll(".progress-item");

    if (progressItems.length < 6) return;

    const emergencyItem = progressItems[5];
    const step = emergencyItem.querySelector(".step");

    injectEmergencyWaterCSS();

    const emergencyField = document.getElementById("is_emergency");
    const emergencyDetails = document.getElementById("emergency_details");

    function getEmergencyDetailsLength() {
        if (!emergencyDetails) {
            return 0;
        }

        if (emergencyDetails.ckeditorInstance) {
            const html = emergencyDetails.ckeditorInstance.getData();

            return html.replace(/<[^>]*>/g, "").trim().length;
        }

        return emergencyDetails.value.trim().length;
    }

    function updateEmergencyProgress() {
        if (!emergencyField) return;

        let percent = 0;

        if (emergencyField.value === "0") {
            // No emergency → section completed
            percent = 100;
        } else {
            const hasDetails = getEmergencyDetailsLength() > 0;

            percent = hasDetails ? 100 : 50;
        }

        step.style.setProperty("--fill", percent + "%");

        emergencyItem.classList.toggle("completed", percent === 100);
    }

    emergencyField.addEventListener("change", updateEmergencyProgress);

    if (emergencyDetails) {
        emergencyDetails.addEventListener("input", updateEmergencyProgress);

        const waitForEditor = setInterval(() => {
            if (emergencyDetails.ckeditorInstance) {
                emergencyDetails.ckeditorInstance.model.document.on(
                    "change:data",
                    updateEmergencyProgress,
                );

                clearInterval(waitForEditor);
            }
        }, 300);
    }

    updateEmergencyProgress();
});

function injectEmergencyWaterCSS() {
    if (document.getElementById("emergency-progress-style")) return;

    const style = document.createElement("style");

    style.id = "emergency-progress-style";

    style.innerHTML = `

.patient-progress-card .progress-item:nth-child(11) .step{
    position:relative;
    overflow:hidden;
}

.patient-progress-card .progress-item:nth-child(11) .step::before{
    content:"";
    position:absolute;
    left:0;
    right:0;
    bottom:0;
    height:var(--fill,0%);
    background:linear-gradient(180deg,#dc2626,#991b1b);
    transition:height .4s ease;
    z-index:0;
}

.patient-progress-card .progress-item:nth-child(11) .step::after{
    content:"";
    position:absolute;
    left:-50%;
    width:200%;
    height:14px;
    bottom:calc(var(--fill,0%) - 7px);
    background:rgba(255,255,255,.35);
    border-radius:50%;
    animation:emergencyWave 2.5s linear infinite;
    z-index:1;
}

.patient-progress-card .progress-item:nth-child(11) .step i{
    position:relative;
    z-index:2;
}

@keyframes emergencyWave{

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
