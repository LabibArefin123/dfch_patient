/**
 * ==========================================================
 * Patient Summary - Investigation Section
 * ==========================================================
 */

function loadInvestigationSection(patient) {
    const investigationContainer = $("#viewPatientInvestigationContainer");

    let html = `
        <div class="col-12 mt-4">

            <div class="card border-warning shadow-sm">

                <div class="card-header bg-warning">

                    <i class="fas fa-microscope mr-2"></i>

                    Investigation Information

                </div>

                <div class="card-body">
    `;

    if (!patient.is_investigated) {
        html += `
            <div class="alert alert-light mb-0">

                <i class="fas fa-info-circle mr-2"></i>

                No investigation information found.

            </div>
        `;

        html += `
                </div>

            </div>

        </div>
        `;

        investigationContainer.html(html);

        return;
    }

    const info =
        patient.investigation_information &&
        patient.investigation_information.trim() !== ""
            ? patient.investigation_information
            : "N/A";

    const investigationImages = Array.isArray(patient.investigation_images)
        ? patient.investigation_images
        : patient.investigation_images
          ? [patient.investigation_images]
          : [];

    html += `

        <div class="border rounded p-3 mb-4 bg-light">

            <label class="font-weight-bold">

                Investigation Description

            </label>

            <div
                class="form-control mb-3"
                style="
                    min-height:80px;
                    height:auto;
                    white-space:pre-wrap;
                ">

                ${info}

            </div>

    `;

    if (investigationImages.length > 0) {
        html += `<div class="row">`;

        investigationImages.forEach(function (image) {
            if (!image) return;

            const fullPath = "/" + image;

            html += `

                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 mb-3">

                    <div class="card shadow-sm h-100">

                        <a
                            href="#"
                            data-bs-toggle="modal"
                            data-bs-target="#imageZoomModal"
                            data-bs-img-src="${fullPath}">

                            <img
                                src="${fullPath}"
                                class="card-img-top img-fluid"
                                alt="Investigation Image"
                                style="
                                    height:180px;
                                    object-fit:contain;
                                    cursor:zoom-in;
                                ">

                        </a>

                    </div>

                </div>

            `;
        });

        html += `</div>`;
    } else {
        html += `

            <div class="alert alert-warning mb-0">

                No investigation images uploaded.

            </div>

        `;
    }

    html += `

        </div>

                </div>

            </div>

        </div>

    `;

    investigationContainer.html(html);
}
