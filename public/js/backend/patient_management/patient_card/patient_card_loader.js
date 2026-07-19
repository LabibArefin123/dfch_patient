function loadPatientCards(page = 1, search = "") {
    window.patientCard.page = page;
    window.patientCard.search = search;

    /*
    |--------------------------------------------------------------------------
    | Abort Previous Request
    |--------------------------------------------------------------------------
    */

    if (
        window.patientCard.request &&
        window.patientCard.request.readyState !== 4
    ) {
        window.patientCard.request.abort();
    }

    /*
    |--------------------------------------------------------------------------
    | Loading State
    |--------------------------------------------------------------------------
    */

    $("#patientCardLoading").removeClass("d-none");

    $("#patientCardEmpty").addClass("d-none");

    $("#patientCardGrid").html("");

    $("#patientCardPagination").html("");

    $("#patientCardTotal").html(`
            <i class="fas fa-spinner fa-spin mr-2"></i>
            Loading...
        `);

    /*
    |--------------------------------------------------------------------------
    | Ajax
    |--------------------------------------------------------------------------
    */

    window.patientCard.request = $.ajax({
        url: window.patientCard.route,

        type: "GET",

        data: {
            page: page,
            search: search,
        },

        success: function (response) {
            $("#patientCardGrid").html(response.html);

            $("#patientCardPagination").html(response.pagination || "");

            $("#patientCardTotal").html(`
                    <i class="fas fa-users mr-2"></i>
                    ${response.total} Patients
                `);

            if (Number(response.total) === 0) {
                $("#patientCardEmpty").removeClass("d-none");
            }
        },

        error: function (xhr, status) {
            console.log(xhr.responseText);

            if (status === "abort") {
                return;
            }

            $("#patientCardGrid").html(`
        <div class="col-12">
            <div class="alert alert-danger">

                <strong>Error:</strong>

                <pre>${xhr.responseText}</pre>

            </div>
        </div>
    `);
        },
        complete: function () {
            $("#patientCardLoading").addClass("d-none");
        },
    });
}
