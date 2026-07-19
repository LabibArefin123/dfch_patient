function loadPatientCards(page = 1, search = "") {
    $("#patientCardLoading").removeClass("d-none");

    $("#patientCardEmpty").addClass("d-none");

    $.ajax({
        url: window.patientCard.route,
        type: "GET",
        data: {
            page: page,
            search: search,
        },

        success: function (response) {
            $("#patientCardGrid").html(response.html);

            $("#patientCardPagination").html(response.pagination);

            $("#patientCardTotal").html(
                '<i class="fas fa-users mr-1"></i> ' +
                    response.total +
                    " Patients",
            );

            if (response.total === 0) {
                $("#patientCardEmpty").removeClass("d-none");
            }
        },

        error: function () {
            $("#patientCardGrid").html(
                `
                <div class="col-12">
                    <div class="alert alert-danger">
                        Unable to load patients.
                    </div>
                </div>
                `,
            );
        },

        complete: function () {
            $("#patientCardLoading").addClass("d-none");
        },
    });
}
