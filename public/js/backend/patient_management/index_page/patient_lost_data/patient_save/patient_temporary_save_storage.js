/* PATIENT TEMPORARY SAVE - STORAGE*/
window.PatientTemporarySave = window.PatientTemporarySave || {};

(function (module) {

    const TOKEN_KEY = "patient_draft_token";
    const ID_KEY = "patient_draft_id";

    /* Generate UUID */
    function generateUUID() {

        if (
            window.crypto &&
            typeof window.crypto.randomUUID === "function"
        ) {
            return window.crypto.randomUUID();
        }

        return "xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx".replace(
            /[xy]/g,
            function (c) {

                const r = Math.random() * 16 | 0;

                const v =
                    c === "x"
                        ? r
                        : (r & 0x3 | 0x8);

                return v.toString(16);
            }
        );
    }

    /* Get Draft Token */
    module.getToken = function () {

        let token = sessionStorage.getItem(
            TOKEN_KEY
        );

        if (!token) {

            token = generateUUID();

            sessionStorage.setItem(
                TOKEN_KEY,
                token
            );
        }

        return token;
    };

    /* Get Draft ID*/

    module.getId = function () {

        return sessionStorage.getItem(
            ID_KEY
        );
    };

    /* Set Draft ID*/
    module.setId = function (id) {

        if (!id) {
            return;
        }

        sessionStorage.setItem(
            ID_KEY,
            id
        );
    };

    /*Clear Storage*/
    module.clearStorage = function () {

        sessionStorage.removeItem(
            TOKEN_KEY
        );

        sessionStorage.removeItem(
            ID_KEY
        );

    };

})(window.PatientTemporarySave);

