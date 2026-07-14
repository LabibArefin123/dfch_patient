/**
|--------------------------------------------------------------------------
| Patient Summary Result
|--------------------------------------------------------------------------
| Render patient search results.
|--------------------------------------------------------------------------
*/

function renderPatientResults(patients) {
    const container = $("#patientSearchResult");

    container.empty();

    if (!patients || !patients.length) {
        container.html(`
            <div class="text-center text-muted py-4">
                No patient found.
            </div>
        `);
        return;
    }

    $.each(patients, function (i, p) {
        console.log(p);
        /*
        |--------------------------------------------------------------------------
        | Dropdown Items
        |--------------------------------------------------------------------------
        */
        const hasRecommendation = Number(p.is_recommend) === 1;

        const hasOldXray =
            Number(p.cancer_photos_count || 0) > 0 ||
            (Array.isArray(p.cancer_photos) && p.cancer_photos.length > 0);

        let dropdownItems = "";

        if (hasRecommendation) {
            dropdownItems += `
                <a
                    href="#"
                    class="dropdown-item patient-summary-documents"
                    data-id="${p.id}"
                    title="View Patient Documents">

                    <i class="fas fa-folder-open text-primary mr-2"></i>

                    Patient Documents

                </a>
            `;
        }

        if (hasOldXray) {
            dropdownItems += `
                <a
                    href="#"
                    class="dropdown-item patient-summary-cancer-photos"
                    data-id="${p.id}">

                    <i class="fas fa-images text-danger mr-2"></i>

                    Patient Cancer Photos

                </a>
            `;
        }

        if (!dropdownItems) {
            dropdownItems = `
                <span class="dropdown-item text-muted">
                    <i class="fas fa-info-circle mr-2"></i>
                    No Additional Data
                </span>
            `;
        }

        /*
        |--------------------------------------------------------------------------
        | Card
        |--------------------------------------------------------------------------
        */

        const card = $(`
            <div class="card mb-1 shadow-sm border-0">

                <div class="card-body">

                    <div class="d-flex align-items-center">

                        <img
                            class="patient-photo-elem rounded-circle border"
                            width="70"
                            height="70"
                            style="object-fit:cover;">

                        <div class="ml-3 flex-grow-1">

                            <h6 class="mb-1 font-weight-bold patient-name-elem"></h6>

                            <small class="text-muted d-block">
                                Code :
                                <span class="patient-code-elem"></span>
                            </small>

                            <small class="text-muted patient-meta-elem"></small>

                        </div>

                    </div>

                    <div class="d-flex justify-content-end align-items-center mt-3">

                        <div class="btn-group">

                            <button
                                type="button"
                                class="btn btn-primary btn-sm patient-summary-show">

                                <i class="fas fa-eye mr-1"></i>

                                Show

                            </button>

                            <button
                                type="button"
                                class="btn btn-outline-success btn-sm patient-summary-preview pulse-btn"
                                data-id="${p.id}">

                                <i class="fas fa-chart-line mr-1"></i>

                                Preview

                            </button>

                            <div class="dropdown">

                                <button
                                    class="btn btn-outline-secondary btn-sm dropdown-toggle"
                                    type="button"
                                    data-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false">

                                    <i class="fas fa-ellipsis-v"></i>

                                </button>

                                <div class="dropdown-menu dropdown-menu-right">

                                    ${dropdownItems}

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>
        `);

        card.find(".patient-photo-elem").attr(
            "src",
            p.patient_photo || "/uploads/images/default.jpg",
        );

        card.find(".patient-name-elem").text(
            p.patient_name || "Unknown Patient",
        );

        card.find(".patient-code-elem").text(p.patient_code || "-");

        card.find(".patient-meta-elem").text(
            `${p.age || "-"} Years | ${p.gender || "-"} | ${p.phone || "-"}`,
        );

        card.find(".patient-summary-show")
            .data("patient", p)
            .attr("data-id", p.id);

        card.find(".patient-summary-preview").data("patient", p);

        container.append(card);
    });
}

/*
|--------------------------------------------------------------------------
| Show Button
|--------------------------------------------------------------------------
*/

$(document)
    .off("click.patientTabs")
    .on("click.patientTabs", ".patient-summary-show", function () {
        const patient = $(this).data("patient");

        updatePatientTabs(patient);
    });
