$(function () {
    "use strict";

    const form = $("#meetingFilterForm");
    const container = $("#meetingTableContainer");

    if (!form.length || !container.length) return;

    let request = null;
    let filterTimer = null;

    function loadMeetings() {
        const url = form.attr("action");
        const data = form.serialize();

        if (request) {
            request.abort();
        }

        container.addClass("meeting-table-loading");

        request = $.ajax({
            url: url,
            type: "GET",
            data: data,
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            },
            success: function (response) {
                container.html(response);
            },
            error: function (xhr, status) {
                if (status !== "abort") {
                    console.error("Meeting filter error:", xhr);
                }
            },
            complete: function () {
                request = null;
                container.removeClass("meeting-table-loading");
            },
        });
    }

    form.on("change", "select,input", function () {
        clearTimeout(filterTimer);

        filterTimer = setTimeout(function () {
            loadMeetings();
        }, 150);
    });

    $(document).on(
        "click",
        "#meetingTableContainer .pagination a",
        function (e) {
            e.preventDefault();

            const url = $(this).attr("href");

            if (!url) return;

            if (request) {
                request.abort();
            }

            container.addClass("meeting-table-loading");

            request = $.ajax({
                url: url,
                type: "GET",
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                },
                success: function (response) {
                    container.html(response);
                    $(document).trigger("meetingDashboardUpdated");
                },
                error: function (xhr, status) {
                    if (status !== "abort") {
                        console.error("Meeting pagination error:", xhr);
                    }
                },
                complete: function () {
                    request = null;
                    container.removeClass("meeting-table-loading");
                },
            });
        },
    );
});
