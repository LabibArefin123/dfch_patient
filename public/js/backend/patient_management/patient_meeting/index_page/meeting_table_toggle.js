$(function () {
    "use strict";

    let currentView = "summary";

    function applyMeetingView(view) {
        currentView = view;

        const container = $("#meetingTableContainer");

        if (!container.length) {
            return;
        }

        const button = container.find("#meetingViewToggle");

        if (view === "summary") {
            container.find(".summary-col").removeClass("d-none");
            container.find(".date-wise-col").addClass("d-none");

            button.attr("data-view", "summary");
            button.data("view", "summary");

            button.html('<i class="fas fa-calendar-alt mr-1"></i> Date Wise');
        } else {
            container.find(".summary-col").addClass("d-none");
            container.find(".date-wise-col").removeClass("d-none");

            button.attr("data-view", "date");
            button.data("view", "date");

            button.html('<i class="fas fa-table mr-1"></i> Summary Table');
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Initial View
    |--------------------------------------------------------------------------
    */

    applyMeetingView(currentView);

    /*
    |--------------------------------------------------------------------------
    | Toggle Summary / Date Wise View
    |--------------------------------------------------------------------------
    | Delegated because the dashboard is replaced through AJAX.
    |--------------------------------------------------------------------------
    */

    $(document).on("click", "#meetingViewToggle", function () {
        const button = $(this);
        const mode = button.attr("data-view");

        if (mode === "summary") {
            applyMeetingView("date");
        } else {
            applyMeetingView("summary");
        }
    });

    /*
    |--------------------------------------------------------------------------
    | Re-apply View After AJAX Dashboard Replacement
    |--------------------------------------------------------------------------
    */

    $(document).on("meetingDashboardUpdated", function () {
        applyMeetingView(currentView);
    });

    /*
    |--------------------------------------------------------------------------
    | Summary Pagination
    |--------------------------------------------------------------------------
    */

    $(document).on("click", ".summary-dot", function () {
        const page = $(this).data("page");
        const wrapper = $(this).closest(".summary-col");

        wrapper.find(".summary-page").removeClass("active");
        wrapper.find(".summary-page").eq(page).addClass("active");

        wrapper.find(".summary-dot").removeClass("active");
        $(this).addClass("active");
    });
});
