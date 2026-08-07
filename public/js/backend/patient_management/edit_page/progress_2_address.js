$(window).on("load", function () {
    /*
    |--------------------------------------------------------------------------
    | PROGRESS CARD
    |--------------------------------------------------------------------------
    */
    const progressCard = document.querySelector(".patient-progress-card");

    if (!progressCard) {
        return;
    }

    /*
    |--------------------------------------------------------------------------
    | FIND ADDRESS PROGRESS ITEM
    |--------------------------------------------------------------------------
    |
    | Do NOT use:
    | querySelectorAll(".progress-item")[1]
    |
    | Instead find the item containing "Address".
    |--------------------------------------------------------------------------
    */
    let addressItem = null;

    progressCard.querySelectorAll(".progress-item").forEach(function (item) {
        const label = item.querySelector("span");

        if (label && $.trim(label.textContent).toLowerCase() === "address") {
            addressItem = item;
        }
    });

    if (!addressItem) {
        console.warn("Address progress item not found.");
        return;
    }

    const step = addressItem.querySelector(".step");

    if (!step) {
        console.warn("Address progress step not found.");
        return;
    }

    /*
    |--------------------------------------------------------------------------
    | LOCATION TYPE
    |--------------------------------------------------------------------------
    */
    const locationType = document.getElementById("location_type");

    if (!locationType) {
        console.warn("Location type field not found.");
        return;
    }

    /*
    |--------------------------------------------------------------------------
    | ADDRESS WATER CSS
    |--------------------------------------------------------------------------
    */
    if (typeof injectAddressWaterCSS === "function") {
        injectAddressWaterCSS();
    }

    /*
    |--------------------------------------------------------------------------
    | GET LOCATION FIELDS
    |--------------------------------------------------------------------------
    */
    function getFields() {
        const type = String(locationType.value || "");

        switch (type) {
            /*
            |--------------------------------------------------------------------------
            | SIMPLE
            |--------------------------------------------------------------------------
            */
            case "1":
                return [
                    document.querySelector("textarea[name='location_simple']"),
                ];

            /*
            |--------------------------------------------------------------------------
            | BANGLADESH
            |--------------------------------------------------------------------------
            */
            case "2":
                return [
                    document.querySelector("input[name='house_address']"),

                    document.querySelector("input[name='city']"),

                    document.querySelector("input[name='district']"),

                    document.querySelector("input[name='post_code']"),
                ];

            /*
            |--------------------------------------------------------------------------
            | OUTSIDE BANGLADESH
            |--------------------------------------------------------------------------
            */
            case "3":
                return [
                    document.querySelector("input[name='country']"),

                    document.querySelector("input[name='passport_no']"),
                ];

            default:
                return [];
        }
    }

    /*
    |--------------------------------------------------------------------------
    | CHECK FIELD VALUE
    |--------------------------------------------------------------------------
    */
    function isFilled(field) {
        if (!field) {
            return false;
        }

        /*
        | Checkbox
        */
        if ($(field).is(":checkbox")) {
            return field.checked;
        }

        /*
        | Select
        */
        if ($(field).is("select")) {
            return $.trim($(field).val() || "") !== "";
        }

        /*
        | Input / Textarea
        */
        return $.trim($(field).val() || "") !== "";
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE ADDRESS PROGRESS
    |--------------------------------------------------------------------------
    */
    function updateAddressProgress() {
        const fields = getFields().filter(function (field) {
            return field !== null && field !== undefined;
        });

        /*
        |--------------------------------------------------------------------------
        | No Fields
        |--------------------------------------------------------------------------
        */
        if (fields.length === 0) {
            step.style.setProperty("--fill", "0%");

            addressItem.classList.remove("completed");

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Count Filled Fields
        |--------------------------------------------------------------------------
        */
        let filled = 0;

        fields.forEach(function (field) {
            if (isFilled(field)) {
                filled++;
            }
        });

        /*
        |--------------------------------------------------------------------------
        | Calculate Percentage
        |--------------------------------------------------------------------------
        */
        const percentage = Math.round((filled / fields.length) * 100);

        /*
        |--------------------------------------------------------------------------
        | Apply Progress
        |--------------------------------------------------------------------------
        */
        step.style.setProperty("--fill", percentage + "%");

        /*
        |--------------------------------------------------------------------------
        | Completed
        |--------------------------------------------------------------------------
        */
        if (percentage === 100) {
            addressItem.classList.add("completed");
        } else {
            addressItem.classList.remove("completed");
        }

        /*
        |--------------------------------------------------------------------------
        | DEBUG
        |--------------------------------------------------------------------------
        |
        | You can remove this console.log later.
        |--------------------------------------------------------------------------
        */
        console.log("Address Progress:", {
            locationType: locationType.value,
            fields: fields.map(function (field) {
                return {
                    name: field.name,
                    value: $(field).val(),
                };
            }),
            filled: filled,
            total: fields.length,
            percentage: percentage,
        });
    }

    /*
    |--------------------------------------------------------------------------
    | LOCATION FIELD EVENTS
    |--------------------------------------------------------------------------
    */
    $(document).on(
        "input change",
        [
            "textarea[name='location_simple']",
            "input[name='house_address']",
            "input[name='city']",
            "input[name='district']",
            "input[name='post_code']",
            "input[name='country']",
            "input[name='passport_no']",
        ].join(", "),
        function () {
            updateAddressProgress();
        },
    );

    /*
    |--------------------------------------------------------------------------
    | LOCATION TYPE CHANGE
    |--------------------------------------------------------------------------
    */
    $(document).on("change", "#location_type", function () {
        /*
            | Run immediately
            */
        updateAddressProgress();

        /*
            | Run after location fields are shown/hidden
            */
        requestAnimationFrame(function () {
            updateAddressProgress();
        });

        setTimeout(function () {
            updateAddressProgress();
        }, 100);

        setTimeout(function () {
            updateAddressProgress();
        }, 300);
    });

    /*
    |--------------------------------------------------------------------------
    | INITIAL LOAD
    |--------------------------------------------------------------------------
    |
    | IMPORTANT FOR EDIT PAGE
    |
    | Laravel already places the old database values into:
    |
    | value="{{ old('city', $patient->city) }}"
    |
    | So we directly read those values.
    |--------------------------------------------------------------------------
    */
    function initializeAddressProgress() {
        updateAddressProgress();
    }

    /*
    |--------------------------------------------------------------------------
    | INITIALIZE
    |--------------------------------------------------------------------------
    */
    initializeAddressProgress();

    /*
    |--------------------------------------------------------------------------
    | Some Other JS May Initialize Location Fields
    |--------------------------------------------------------------------------
    */
    setTimeout(function () {
        initializeAddressProgress();
    }, 50);

    setTimeout(function () {
        initializeAddressProgress();
    }, 150);

    setTimeout(function () {
        initializeAddressProgress();
    }, 300);

    setTimeout(function () {
        initializeAddressProgress();
    }, 600);

    /*
    |--------------------------------------------------------------------------
    | PATIENT FORM READY
    |--------------------------------------------------------------------------
    */
    document.addEventListener("patient-form-ready", function () {
        initializeAddressProgress();
    });

    /*
    |--------------------------------------------------------------------------
    | BROWSER BACK / FORWARD
    |--------------------------------------------------------------------------
    */
    window.addEventListener("pageshow", function () {
        initializeAddressProgress();
    });
});
