/**
|--------------------------------------------------------------------------
| Patient Cancer Content
|--------------------------------------------------------------------------
| Load patient cancer photos into the Cancer Photos tab.
|--------------------------------------------------------------------------
*/

$(document).on("click", ".patient-summary-cancer-photos", function (e) {
    e.preventDefault();

    const patientId = $(this).data("id");

    const url = patientCancerPhotoContentsUrl.replace(":id", patientId);

    $("#cancer-tab").tab("show");

    const body = $("#patientCancerContent");

    body.html(`
        <div class="text-center py-5">

            <div class="spinner-border text-danger mb-3"></div>

            <div class="text-muted">
                Loading cancer photos...
            </div>

        </div>
    `);

    $.ajax({
        url: url,

        type: "GET",

        success: function (res) {
            body.empty();

            if (!res.status || !res.photos.length) {
                body.html(`
                    <div class="alert alert-warning text-center">

                        <i class="fas fa-images fa-2x mb-3"></i>

                        <h5 class="mb-2">
                            No Cancer Photos Found
                        </h5>

                        <p class="mb-0 text-muted">
                            This patient doesn't have any uploaded cancer photos.
                        </p>

                    </div>
                `);

                return;
            }

            body.append('<div class="row"></div>');

            const row = body.find(".row");

            $.each(res.photos, function (_, photo) {
                row.append(`

                    <div class="col-lg-6 col-md-6 mb-4">

                        <div class="card border-0 shadow-sm h-100">

                            <img
                                src="${photo.photo}"
                                class="card-img-top patient-cancer-photo-preview"
                                data-image="${photo.photo}"
                                style="
                                    height:280px;
                                    object-fit:cover;
                                    cursor:pointer;
                                ">

                            <div class="card-body">

                                <div class="small text-muted mb-2">

                                    <strong>Total Cancer :</strong>

                                    ${photo.total_cancer}

                                </div>

                                <div class="small">

                                    <strong>Description</strong>

                                    <div class="text-muted mt-1">

                                        ${photo.description || "No description provided."}

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                `);
            });
        },

        error: function () {
            body.html(`
                <div class="alert alert-danger text-center">

                    <i class="fas fa-times-circle mr-2"></i>

                    Unable to load cancer photos.

                </div>
            `);
        },
    });
});
/*
|--------------------------------------------------------------------------
| Cancer Photo Viewer
|--------------------------------------------------------------------------
*/

$(document).on("click", ".patient-cancer-photo-preview", function () {
    const image = $(this).data("image");

    $("#patientSummaryZoomImage")
        .attr("src", image)
        .css("transform", "scale(1)");

    $("#patientSummaryImageViewer").removeClass("d-none").hide().fadeIn(200);
});

/*
|--------------------------------------------------------------------------
| Close Viewer
|--------------------------------------------------------------------------
*/

$(document).on("click", "#closePatientSummaryImageViewer", function () {
    $("#patientSummaryImageViewer").fadeOut(200, function () {
        $(this).addClass("d-none");

        $("#patientSummaryZoomImage").attr("src", "");
    });
});

$(document).keyup(function (e) {
    if (e.key === "Escape") {
        $("#closePatientSummaryImageViewer").click();
    }
});

let zoom = 1;

$(document).on("click", "#patientSummaryZoomImage", function () {
    zoom = zoom === 1 ? 2 : 1;

    $(this).css("transform", `scale(${zoom})`);
});