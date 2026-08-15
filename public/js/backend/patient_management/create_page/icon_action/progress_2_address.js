document.addEventListener("DOMContentLoaded", () => {
    const progressCard = document.querySelector(".patient-progress-card");
    if (!progressCard) return;

    const progressItems = progressCard.querySelectorAll(".progress-item");
    if (progressItems.length < 2) return;

    const addressItem = progressItems[1];
    const step = addressItem.querySelector(".step");

    injectAddressWaterCSS();

    const addressSection = document.querySelector(
        ".patient-section-card:nth-of-type(2)",
    );
    if (!addressSection) return;

    const locationType = document.getElementById("location_type");

    function getVisibleFields() {
        const type = locationType.value;

        switch (type) {
            // ===========================
            // Simple Address
            // ===========================
            case "1":
                return [
                    addressSection.querySelector(
                        "textarea[name='location_simple']",
                    ),
                ].filter(Boolean);

            // ===========================
            // Bangladesh Address
            // ===========================
            case "2":
                return [
                    addressSection.querySelector("input[name='house_address']"),
                    addressSection.querySelector("input[name='city']"),
                    addressSection.querySelector("input[name='district']"),
                    addressSection.querySelector("input[name='post_code']"),
                ].filter(Boolean);

            // ===========================
            // Foreign Address
            // ===========================
            case "3":
                return [
                    addressSection.querySelector("input[name='country']"),
                    addressSection.querySelector("input[name='passport_no']"),
                ].filter(Boolean);

            default:
                return [];
        }
    }

    function isFilled(field) {
        if (!field) return false;

        if (field.disabled) return false;

        if (field.type === "checkbox" || field.type === "radio") {
            return field.checked;
        }

        return field.value.trim() !== "";
    }

    function updateAddressProgress() {
        const fields = getVisibleFields();

        if (fields.length === 0) {
            step.style.setProperty("--fill", "0%");
            addressItem.classList.remove("completed");
            return;
        }

        let filled = 0;

        fields.forEach((field) => {
            if (isFilled(field)) {
                filled++;
            }
        });

        const percent = Math.round((filled / fields.length) * 100);

        step.style.setProperty("--fill", percent + "%");

        if (percent === 100) {
            addressItem.classList.add("completed");
        } else {
            addressItem.classList.remove("completed");
        }
    }

    // ===========================================
    // Listen for all address inputs
    // ===========================================

    addressSection.addEventListener("input", updateAddressProgress);
    addressSection.addEventListener("change", updateAddressProgress);

    locationType.addEventListener("change", function () {
        setTimeout(updateAddressProgress, 50);
    });

    updateAddressProgress();
});

function injectAddressWaterCSS() {
    if (document.getElementById("address-progress-style")) return;

    const style = document.createElement("style");

    style.id = "address-progress-style";

    style.innerHTML = `
.patient-progress-card .progress-item:nth-child(2) .step{
    position:relative;
    overflow:hidden;
}

.patient-progress-card .progress-item:nth-child(2) .step::before{
    content:"";
    position:absolute;
    left:0;
    right:0;
    bottom:0;
    height:var(--fill,0%);
    background:linear-gradient(180deg,#42c5ff,#0b8fff);
    transition:height .4s ease;
    z-index:0;
}

.patient-progress-card .progress-item:nth-child(2) .step::after{
    content:"";
    position:absolute;
    left:-50%;
    width:200%;
    height:14px;
    bottom:calc(var(--fill,0%) - 7px);
    background:rgba(255,255,255,.35);
    border-radius:50%;
    animation:addressWave 2.5s linear infinite;
    z-index:1;
}

.patient-progress-card .progress-item:nth-child(2) .step i{
    position:relative;
    z-index:2;
}

@keyframes addressWave{
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
