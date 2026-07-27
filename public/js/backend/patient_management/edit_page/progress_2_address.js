$(window).on("load", function () {
    const progressCard = document.querySelector(".patient-progress-card");
    if (!progressCard) return;

    const addressItem = progressCard.querySelectorAll(".progress-item")[1];
    if (!addressItem) return;

    const step = addressItem.querySelector(".step");

    injectAddressWaterCSS();

    const locationType = document.getElementById("location_type");
    if (!locationType) return;

    function getFields() {
        switch (locationType.value) {
            // Simple
            case "1":
                return [
                    document.querySelector("textarea[name='location_simple']"),
                ];

            // Bangladesh
            case "2":
                return [
                    document.querySelector("input[name='house_address']"),
                    document.querySelector("input[name='city']"),
                    document.querySelector("input[name='district']"),
                    document.querySelector("input[name='post_code']"),
                ];

            // Outside Bangladesh
            case "3":
                return [
                    document.querySelector("input[name='country']"),
                    document.querySelector("input[name='passport_no']"),
                ];

            default:
                return [];
        }
    }

    function isFilled(field) {
        if (!field) return false;

        return $.trim($(field).val()) !== "";
    }

    function updateProgress() {
        const fields = getFields().filter(Boolean);

        if (!fields.length) {
            step.style.setProperty("--fill", "0%");
            addressItem.classList.remove("completed");
            return;
        }

        let filled = 0;

        fields.forEach(function (field) {
            if (isFilled(field)) {
                filled++;
            }
        });

        const percent = Math.round((filled / fields.length) * 100);

        step.style.setProperty("--fill", percent + "%");

        addressItem.classList.toggle("completed", percent === 100);
    }

    // ===========================
    // Listen for all inputs
    // ===========================

    $(document).on(
        "input change",
        "textarea[name='location_simple'],\
         input[name='house_address'],\
         input[name='city'],\
         input[name='district'],\
         input[name='post_code'],\
         input[name='country'],\
         input[name='passport_no']",
        function () {
            updateProgress();
        },
    );

    // ===========================
    // Location Type Changed
    // ===========================

    $("#location_type").on("change", function () {
        // Wait until toggleLocation() finishes
        setTimeout(updateProgress, 300);
    });

    // ===========================
    // Initial Load (Edit Page)
    // ===========================

    updateProgress();

    // If another script finishes initialization later
    document.addEventListener("patient-form-ready", function () {
        updateProgress();
    });
});
