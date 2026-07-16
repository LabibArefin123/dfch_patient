document.addEventListener("DOMContentLoaded", function () {
    const $patientSelect = $("#patientSelect");

    if (!$patientSelect.length || typeof $.fn.select2 === "undefined") {
        return;
    }

    const PAGE_SIZE = 15;
    const SHOW_MORE_VALUE = "__show_more__";

    const originalOptions = [];

    $patientSelect.find("option").each(function () {
        if ($(this).val() === "") return;

        originalOptions.push({
            value: $(this).val(),
            text: $(this).text(),
            search: ($(this).data("search") || "").toLowerCase(),
        });
    });

    let visibleCount = PAGE_SIZE;
    let currentSearch = "";

    function renderOptions() {
        let filtered = originalOptions;

        if (currentSearch.length) {
            filtered = originalOptions.filter((o) =>
                o.search.includes(currentSearch),
            );
        }

        $patientSelect.empty();

        $patientSelect.append(new Option("Select Patient", ""));

        filtered.slice(0, visibleCount).forEach((o) => {
            $patientSelect.append(new Option(o.text, o.value));
        });

        if (filtered.length > visibleCount) {
            $patientSelect.append(
                new Option(
                    `Show More (${filtered.length - visibleCount} more)...`,
                    SHOW_MORE_VALUE,
                ),
            );
        }

        const selected = "{{ old('patient_id') }}";

        if (selected) {
            $patientSelect.val(selected);
        }
    }

    $patientSelect.select2({
        width: "100%",
        placeholder: "Search Patient...",
        allowClear: true,

        matcher: function (params, data) {
            currentSearch = $.trim(params.term || "").toLowerCase();

            visibleCount = PAGE_SIZE;

            renderOptions();

            return data;
        },
    });

    renderOptions();

    $patientSelect.on("select2:select", function (e) {
        if (e.params.data.id === SHOW_MORE_VALUE) {
            visibleCount += PAGE_SIZE;

            renderOptions();

            $patientSelect.select2("open");
        }
    });
});
