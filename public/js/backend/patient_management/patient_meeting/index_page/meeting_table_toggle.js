$(function () {
    /*
    |--------------------------------------------------------------------------
    | Initial State
    |--------------------------------------------------------------------------
    */

    $(".summary-col").removeClass("d-none");

    $(".date-wise-col").addClass("d-none");

    /*
    |--------------------------------------------------------------------------
    | Toggle Summary / Date Wise View
    |--------------------------------------------------------------------------
    */

    $("#meetingViewToggle").on("click", function () {
        const button = $(this);

        const mode = button.data("view");

        if (mode === "summary") {
            // Hide summary
            $(".summary-col").addClass("d-none");

            // Show date-wise columns
            $(".date-wise-col").removeClass("d-none");

            button.data("view", "date");

            button.html('<i class="fas fa-table mr-1"></i> Summary Table');
        } else {
            // Show summary
            $(".summary-col").removeClass("d-none");

            // Hide date-wise columns
            $(".date-wise-col").addClass("d-none");

            button.data("view", "summary");

            button.html('<i class="fas fa-calendar-alt mr-1"></i> Date Wise');
        }
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
