document.addEventListener("DOMContentLoaded", function () {
    initializePatientAge();
});

/* ============================================================
   INITIALIZE PATIENT AGE
   ============================================================ */

function initializePatientAge() {
    const ageRows = document.querySelectorAll(".patient-age-row");

    if (!ageRows.length) {
        return;
    }

    ageRows.forEach(function (row) {
        const age = parseFloat(row.dataset.age);

        const valueElement = row.querySelector(".patient-age-value");

        if (!valueElement || Number.isNaN(age)) {
            return;
        }

        valueElement.textContent = formatPatientAge(age);
    });
}

/* ============================================================
   FORMAT PATIENT AGE
   ============================================================ */

function formatPatientAge(age) {
    /*
    |--------------------------------------------------------------------------
    | Invalid / negative age
    |--------------------------------------------------------------------------
    */

    if (age < 0) {
        return "Age unavailable";
    }

    /*
    |--------------------------------------------------------------------------
    | Baby / Infant
    |--------------------------------------------------------------------------
    |
    | 0 - 12 months
    |
    */

    if (age < 1) {
        const months = Math.round(age * 12);

        if (months <= 0) {
            return "Newborn";
        }

        if (months === 1) {
            return "1 month old";
        }

        return `${months} months old`;
    }

    /*
    |--------------------------------------------------------------------------
    | Exactly 1 year
    |--------------------------------------------------------------------------
    */

    if (age === 1) {
        return "1 year old";
    }

    /*
    |--------------------------------------------------------------------------
    | More than 1 year
    |--------------------------------------------------------------------------
    */

    return `${removeUnnecessaryDecimal(age)} years old`;
}

/* ============================================================
   REMOVE UNNECESSARY DECIMAL
   ============================================================ */

function removeUnnecessaryDecimal(value) {
    if (Number.isInteger(value)) {
        return value;
    }

    return parseFloat(value.toFixed(1));
}
