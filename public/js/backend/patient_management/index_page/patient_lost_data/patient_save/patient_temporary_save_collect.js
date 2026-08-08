
/*PATIENT TEMPORARY SAVE - COLLECT FORM DATA*/
window.PatientTemporarySave = window.PatientTemporarySave || {};

(function (module) {

    /*Get Form */
    module.getForm = function () {

        const form = $("#patientCreateForm");

        if (!form.length) {
            return null;
        }

        return form;
    };

    /* Get CKEditor Value*/

    function getCKEditorValue(field) {

        const name = field.attr("name");
        const id = field.attr("id");

        /* Existing patientEditors object */
        if (
            window.patientEditors &&
            name &&
            window.patientEditors[name]
        ) {
            return window.patientEditors[name].getData();
        }

        if (
            window.patientEditors &&
            id &&
            window.patientEditors[id]
        ) {
            return window.patientEditors[id].getData();
        }

        return field.val() || "";
    }

    /* Collect Form*/
    module.collect = function () {

        const form = module.getForm();

        if (!form) {
            return {};
        }

        const data = {};

        form.find(
            "input[name], select[name], textarea[name]"
        ).each(function () {

            const field = $(this);

            const name = field.attr("name");

            if (!name) {
                return;
            }

            /* Skip File Inputs*/
            if (field.is(":file")) {
                return;
            }

            /* Checkbox */
            if (field.is(":checkbox")) {

                /*
                 * Example:
                 *
                 * treatment_type[]
                 */

                if (name.endsWith("[]")) {

                    const cleanName =
                        name.substring(
                            0,
                            name.length - 2
                        );

                    if (!Array.isArray(data[cleanName])) {

                        data[cleanName] = [];
                    }

                    if (field.is(":checked")) {

                        data[cleanName].push(
                            field.val()
                        );
                    }

                    return;
                }

                data[name] = field.is(":checked");

                return;
            }

            /* Radio */
            if (field.is(":radio")) {

                if (field.is(":checked")) {

                    data[name] = field.val();

                } else if (
                    typeof data[name] === "undefined"
                ) {

                    data[name] = null;
                }

                return;
            }

            /* Select */
            if (field.is("select")) {

                data[name] = field.val();

                return;
            }

            /* CKEditor */
            if (
                field.is("textarea") &&
                (
                    window.patientEditors?.[name] ||
                    window.patientEditors?.[field.attr("id")]
                )
            ) {

                data[name] =
                    getCKEditorValue(field);

                return;
            }

            /*Normal Input / Textarea*/
            data[name] = field.val();

        });

        return data;
    };

    /*Check Whether Data Actually Exists */
    module.hasData = function (data) {

        return Object.keys(data).some(
            function (key) {

                const value = data[key];

                if (
                    value === null ||
                    typeof value === "undefined"
                ) {
                    return false;
                }

                if (
                    typeof value === "string" &&
                    value.trim() === ""
                ) {
                    return false;
                }

                if (
                    Array.isArray(value) &&
                    value.length === 0
                ) {
                    return false;
                }

                return true;
            }
        );

    };

})(window.PatientTemporarySave);

