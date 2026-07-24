/**
 * --------------------------------------------------------------------------
 * Patient Registration Date Formatter
 * --------------------------------------------------------------------------
 */

document.addEventListener("DOMContentLoaded", function () {
    initializePatientAddedDateFormatter();
});

function initializePatientAddedDateFormatter() {
    const dateInput = document.querySelector(
        'input[name="date_of_patient_added"]',
    );

    const preview = document.getElementById("patientAddedDateInfo");

    if (!dateInput || !preview) {
        return;
    }

    updatePatientAddedDateInfo(dateInput.value);

    dateInput.addEventListener("input", function () {
        updatePatientAddedDateInfo(this.value);
    });

    dateInput.addEventListener("change", function () {
        updatePatientAddedDateInfo(this.value);
    });
}

/**
 * --------------------------------------------------------------------------
 * Update Registration Information
 * --------------------------------------------------------------------------
 */
function updatePatientAddedDateInfo(dateValue) {
    const preview = document.getElementById("patientAddedDateInfo");

    if (!preview) {
        return;
    }

    if (!dateValue) {
        preview.innerHTML = `
            <div class="registration-empty">
                <i class="far fa-calendar-alt"></i>

                <h6>No Date Selected</h6>

                <p>
                    Choose a registration date to view
                    the formatted calendar information.
                </p>
            </div>
        `;
        return;
    }

    const date = new Date(dateValue + "T00:00:00");

    const today = new Date();
    today.setHours(0, 0, 0, 0);

    const isFutureDate = date.getTime() > today.getTime();

    const formattedDate = date.toLocaleDateString("en-US", {
        day: "numeric",
        month: "long",
        year: "numeric",
    });

    const weekday = date.toLocaleDateString("en-US", {
        weekday: "long",
    });

    const month = date.toLocaleDateString("en-US", {
        month: "long",
    });

    const yearWeek = getWeekOfYear(date);

    const monthWeek = getWeekOfMonth(date);

    preview.innerHTML = `
        <div class="registration-date-title">
            ${formattedDate}
        </div>

        <div class="registration-date-day">
            <i class="fas fa-calendar-day mr-2"></i>
            ${weekday}
        </div>

        <div class="registration-info-grid">

            <div class="registration-info-card">
                <small>Year</small>
                <strong>${date.getFullYear()}</strong>
            </div>

            <div class="registration-info-card">
                <small>Month</small>
                <strong>${month}</strong>
            </div>

            <div class="registration-info-card">
                <small>Year Week</small>
                <strong>Week ${yearWeek}</strong>
            </div>

            <div class="registration-info-card">
                <small>Month Week</small>
                <strong>Week ${monthWeek}</strong>
            </div>

        </div>

        ${
            isFutureDate
                ? `
                    <div class="registration-warning">

                        <i class="fas fa-flask mr-2"></i>

                        <strong>${
                            futureTestingApproved
                                ? "Testing Registration"
                                : "Future Registration"
                        }</strong>

                        <p class="mb-0">

                            ${
                                futureTestingApproved
                                    ? "Future date accepted for testing purposes."
                                    : "A future registration date has been selected."
                            }

                        </p>

                    </div>
                `
                : ""
        }
    `;
}

/**
 * --------------------------------------------------------------------------
 * ISO Week Number
 * --------------------------------------------------------------------------
 */
function getWeekOfYear(date) {
    const target = new Date(date.valueOf());

    const dayNr = (date.getDay() + 6) % 7;

    target.setDate(target.getDate() - dayNr + 3);

    const firstThursday = new Date(target.getFullYear(), 0, 4);

    const diff =
        target - firstThursday + ((firstThursday.getDay() + 6) % 7) * 86400000;

    return 1 + Math.floor(diff / 604800000);
}

/**
 * --------------------------------------------------------------------------
 * Week Number Within Month
 * --------------------------------------------------------------------------
 */
function getWeekOfMonth(date) {
    const firstDay = new Date(date.getFullYear(), date.getMonth(), 1);

    const offset = firstDay.getDay();

    return Math.ceil((date.getDate() + offset) / 7);
}
