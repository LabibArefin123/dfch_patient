/**
 * ==========================================================================
 * PATIENT DATA LOAD
 * ==========================================================================
 *
 * Loads patient information into the patient information cards.
 *
 * Features:
 * - Patient search
 * - Patient details loading
 * - Read-only patient information
 * - Yes / No status display
 * - Safe handling of missing data
 * - Uses existing Laravel AJAX routes
 *
 * ==========================================================================
 */

(function ($) {
    "use strict";

    /*CONFIG */
    const routes = window.patientRoutes || {};

    /*HELPERS  */
    function safeValue(value, fallback = "N/A") {
        if (
            value === null ||
            value === undefined ||
            String(value).trim() === ""
        ) {
            return fallback;
        }

        return value;
    }

    /*SET INPUT VALUE */
    function setValue(selector, value) {
        const element = document.querySelector(selector);
        if (!element) {
            return;
        }

        element.value = safeValue(value);
    }

    /*SET TEXT  */
    function setText(selector, value) {
        const element = document.querySelector(selector);

        if (!element) {
            return;
        }

        element.textContent = safeValue(value);
    }

    /*YES / NO */
    function yesNo(value) {
        if (
            value === true ||
            value === 1 ||
            value === "1" ||
            value === "Yes" ||
            value === "yes"
        ) {
            return "Yes";
        }

        return "No";
    }

    /*LOAD PATIENT DATA  */
    function loadPatientData(patient) {
        if (!patient) {
            return;
        }

        /* Patient*/
        setText("#patientName", patient.patient_name);
        setText("#patientCode", patient.patient_code);
        /*Basic Information Part */

        setValue("#patientAge", patient.age);
        /*Contact  */

        setValue("#patientPhone", patient.phone_1);
        setValue("#patientAlternativePhone", patient.phone_2);
        setValue("#patientFatherPhone", patient.father_phone);
        setValue("#patientMotherPhone", patient.mother_phone);

        /* Address*/
        setValue("#patientAddress", patient.location);

        /*Status  */

        setValue("#patientReferred", yesNo(patient.is_referred));
        setValue("#patientTreatment", yesNo(patient.is_treatment));
        setValue("#patientInvestigated", yesNo(patient.is_investigated));
    }

    /* LOAD PATIENT BY ID */
    function loadPatient(patientId) {
        if (!patientId || !routes.details) {
            console.warn("Patient details route is missing.");

            return;
        }

        const url = routes.details.replace(":id", patientId);

        $.ajax({
            url: url,
            method: "GET",
            dataType: "json",
            beforeSend: function () {
                /* Optional loading state */
                $("#patientDataLoader").removeClass("d-none");
            },

            success: function (patient) {
                loadPatientData(patient);
            },

            error: function (xhr) {
                console.error("Unable to load patient data.", xhr);

                /*Clear fields if request fails   */
                clearPatientData();
            },

            complete: function () {
                $("#patientDataLoader").addClass("d-none");
            },
        });
    }

    /*CLEAR PATIENT DATA */
    function clearPatientData() {
        setText("#patientName", "N/A");
        setText("#patientCode", "N/A");
        setValue("#patientAge", "N/A");
        setValue("#patientPhone", "N/A");
        setValue("#patientAlternativePhone", "N/A");
        setValue("#patientFatherPhone", "N/A");
        setValue("#patientMotherPhone", "N/A");
        setValue("#patientAddress", "N/A");
        setValue("#patientReferred", "No");
        setValue("#patientTreatment", "No");
        setValue("#patientInvestigated", "No");
    }

    /*SEARCH PATIENTS */
    function searchPatients(search, callback) {
        if (!routes.search) {
            console.warn("Patient search route is missing.");

            return;
        }

        $.ajax({
            url: routes.search,
            method: "GET",
            dataType: "json",
            data: {
                search: search || "",
            },

            success: function (patients) {
                if (typeof callback === "function") {
                    callback(patients || []);
                }
            },

            error: function (xhr) {
                console.error("Patient search failed.", xhr);

                if (typeof callback === "function") {
                    callback([]);
                }
            },
        });
    }

    /* EXPOSE FUNCTIONS - Useful if your patient selector is handled by another JS file. */
    window.PatientDataLoader = {
        load: loadPatient,
        search: searchPatients,
        clear: clearPatientData,
        fill: loadPatientData,
    };

    /* AUTO LOAD PATIENT
    If the page already contains a patient ID: <input type="hidden" id="patient_id" value="123">
     */

    $(document).ready(function () {
        const patientId = $("#patient_id").val();

        if (patientId) {
            loadPatient(patientId);
        }
    });
})(jQuery);
