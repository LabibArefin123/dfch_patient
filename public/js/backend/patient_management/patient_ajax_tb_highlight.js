$(function () {
    /**
     * Escape special regex characters
     */
    function escapeRegExp(string) {
        return string.replace(/[.*+?^${}()|[\]\\]/g, "\\$&");
    }

    /**
     * Highlight matched text
     */
    function highlightSearch() {
        if (!window.patientTable) return;

        // Get current search keyword
        let keyword = window.patientTable.search().trim();

        // Remove previous highlights
        $("#patientsTable tbody td").each(function () {
            $(this)
                .find("mark.patient-highlight")
                .each(function () {
                    $(this).replaceWith($(this).text());
                });
        });

        if (keyword === "") return;

        let regex = new RegExp("(" + escapeRegExp(keyword) + ")", "gi");

        $("#patientsTable tbody td").each(function () {
            // Skip action buttons & checkboxes
            if ($(this).find("button, a.btn, input").length) {
                return;
            }

            $(this)
                .contents()
                .filter(function () {
                    return this.nodeType === 3;
                })
                .each(function () {
                    let html = this.nodeValue.replace(
                        regex,
                        '<mark class="patient-highlight">$1</mark>',
                    );

                    if (html !== this.nodeValue) {
                        $(this).replaceWith(html);
                    }
                });
        });
    }

    // Highlight after every DataTable draw
    window.patientTable.on("draw", function () {
        highlightSearch();
    });
});
