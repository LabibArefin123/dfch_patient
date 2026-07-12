(function () {
    function template(patient) {
        let html = "";

        const reports = patient.cancerPhotos || [];

        if (!reports.length) {
            return `
            <div class="alert alert-warning shadow-sm">
                <i class="fas fa-exclamation-circle mr-2"></i>
                No cancer reports found.
            </div>
        `;
        }

        reports.forEach((report) => {
            let images = "";

            (report.xray_photo || []).forEach((photo, index) => {
                images += `
                <div class="col-xl-3 col-lg-3 col-md-4 col-6 mb-3">

                    <div class="card shadow-sm h-100">

                        <img
                            src="/${photo}"
                            class="card-img-top patient-cancer-preview-image"
                            style="height:220px;object-fit:cover;cursor:pointer;"
                            data-bs-toggle="modal"
                            data-bs-target="#imageZoomModal"
                            data-image="/${photo}"
                        >

                        <div class="card-body py-2">

                            <small>

                                ${report.xray_description[index] || "No Description"}

                            </small>

                        </div>

                    </div>

                </div>
            `;
            });

            html += `

            <div class="card shadow-sm border-0 mb-4 patient-cancer-wrapper d-none">

                <div class="card-header bg-danger text-white">

                    <h5 class="mb-0">

                        <i class="fas fa-x-ray mr-2"></i>

                        Cancer Report Analysis

                        <small class="patient-cancer-status d-block mt-1">

                            Preparing report...

                        </small>

                    </h5>

                </div>

                <div class="card-body">

                    <div class="row mb-4">

                        <div class="col-md-3">

                            <label>Total Cancer</label>

                            <div class="form-control">

                                ${report.total_cancer}

                            </div>

                        </div>

                        <div class="col-md-9">

                            <label>Remarks</label>

                            <div class="form-control" style="min-height:80px">

                                ${report.remarks || "N/A"}

                            </div>

                        </div>

                    </div>

                    <div class="row">

                        ${images}

                    </div>

                </div>

            </div>

        `;
        });

        return html;
    }

    window.PatientCancerAnimate.template = template;
})();
