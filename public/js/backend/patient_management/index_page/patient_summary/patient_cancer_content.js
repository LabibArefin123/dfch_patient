/**
|--------------------------------------------------------------------------
| Patient Cancer Photo Content
|--------------------------------------------------------------------------
*/

$(document).on("click", ".patient-summary-cancer-photos", function (e) {
    e.preventDefault();

    const patientId = $(this).data("id");

    const url = patientCancerPhotoContentsUrl.replace(":id", patientId);

    $("#patientCancerPhotoContentBody").html(`
        <div class="col-12 text-center py-5">

            <div class="spinner-border text-danger mb-3"></div>

            <p class="text-muted mb-0">

                Loading cancer photos...

            </p>

        </div>
    `);

    $("#patientCancerPhotoContentModal").modal("show");

    $.ajax({
        url: url,

        type: "GET",

        success: function (res) {
            const body = $("#patientCancerPhotoContentBody");

            body.empty();

            if (!res.status || !res.photos.length) {
                body.html(`
                    <div class="col-12">

                        <div class="alert alert-warning text-center">

                            <i class="fas fa-images mr-2"></i>

                            No cancer photos available.

                        </div>

                    </div>
                `);

                return;
            }

            $.each(res.photos, function (_, photo) {
                body.append(`
                    <div class="col-lg-4 col-md-6 mb-4">

                        <div class="card shadow-sm h-100">

                            <img
                                src="${photo.photo}"
                                class="card-img-top"
                                style="
                                    height:250px;
                                    object-fit:cover;
                                ">

                            <div class="card-body">

                                <p class="mb-2">

                                    <strong>Description</strong>

                                </p>

                                <p class="text-muted small">

                                    ${photo.description || "-"}

                                </p>

                                <hr>

                                <small>

                                    <strong>Total Cancer :</strong>

                                    ${photo.total_cancer}

                                </small>

                            </div>

                            <div class="card-footer text-center bg-white">

                                <a
                                    href="${photo.photo}"
                                    target="_blank"
                                    class="btn btn-danger btn-sm">

                                    <i class="fas fa-search-plus mr-1"></i>

                                    View Full Size

                                </a>

                            </div>

                        </div>

                    </div>
                `);
            });
        },

        error: function () {
            $("#patientCancerPhotoContentBody").html(`
                <div class="col-12">

                    <div class="alert alert-danger text-center">

                        Unable to load cancer photos.

                    </div>

                </div>
            `);
        },
    });
});
