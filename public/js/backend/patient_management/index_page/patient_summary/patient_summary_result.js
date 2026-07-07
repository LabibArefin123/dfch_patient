/**
 * Renders the list of patient results in the search panel.
 * Uses jQuery to construct elements and attach data safely to prevent
 * single/double quote parsing breakages in HTML attribute interpolation.
 */
function renderPatientResults(patients) {
    const container = $("#patientSearchResult");
    container.empty();

    if (!patients || patients.length === 0) {
        container.html('<div class="text-muted">No results found.</div>');
        return;
    }

    $.each(patients, function (i, p) {
        // Construct the card structure
        const card = $(`
            <div class="card mb-2 shadow-sm border-0 bg-white" style="border-radius: 10px; transition: transform 0.2s ease;">
                <div class="card-body p-2">
                    <div class="row align-items-center">
                        <div class="col-md-2 text-center">
                            <img class="rounded border patient-photo-elem" 
                                 style="width: 55px; height: 55px; object-fit: cover;" 
                                 alt="Patient Profile">
                        </div>
                        <div class="col-md-8">
                            <strong class="patient-name-elem text-dark"></strong>
                            <br>
                            <small class="text-muted patient-code-elem"></small>
                            <br>
                            <small class="patient-meta-elem text-secondary"></small>
                        </div>
                        <div class="col-md-2 text-right">
                            <button class="btn btn-primary btn-sm patient-summary-show" style="border-radius: 6px;">
                                Show
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `);

        // Set safe text contents to avoid injection and attribute breakage
        card.find(".patient-photo-elem").attr(
            "src",
            p.patient_photo || "/images/default-avatar.png",
        );
        card.find(".patient-name-elem").text(p.patient_name);
        card.find(".patient-code-elem").text(p.patient_code);
        card.find(".patient-meta-elem").text(
            `${p.age} Years | ${p.gender} | ${p.phone}`,
        );

        // Bind data objects directly using jQuery data store
        card.find(".patient-summary-show").data("patient", p);

        container.append(card);
    });
}
