function restoreFormData(data) {
    const form = $("#patientCreateForm");
    if (!form.length) return;
    Object.keys(data).forEach(function (name) {
        const value = data[name];
        const fields = form.find('[name="' + CSS.escape(name) + '"]');
        if (!fields.length) return;
        if (fields.first().is(":checkbox")) {
            fields.each(function () {
                const checkbox = $(this);
                if (Array.isArray(value)) {
                    checkbox.prop("checked", value.includes(checkbox.val()));
                } else {
                    checkbox.prop("checked", Boolean(value));
                }
            });
            fields.trigger("change");
            return;
        }
        if (fields.first().is(":radio")) {
            fields.each(function () {
                $(this).prop(
                    "checked",
                    String($(this).val()) === String(value),
                );
            });
            fields.filter(":checked").trigger("change");
            return;
        }
        if (fields.first().is("select")) {
            fields.val(value);
            fields.trigger("change");
            return;
        }
        if (fields.first().is("textarea")) {
            if (setCKEditorValue(name, value)) return;
        }
        fields.val(value);
        fields.trigger("input");
        fields.trigger("change");
    });
}
