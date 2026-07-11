/**
 * |--------------------------------------------------------------------------
 * | Patient Photo Animation
 * |--------------------------------------------------------------------------
 * | Responsible only for:
 * | - AI Header
 * | - Patient Photo
 * | - Patient Basic Information
 * | - Photo Animation
 * |--------------------------------------------------------------------------
 */

window.PatientPhotoAnimate = (() => {
    /**
     * Render patient photo section
     */
    function render(patient) {
        const html = `
            <div class="patient-ai-photo-wrapper d-none">

                <div class="card shadow-sm border-0 mb-4">

                    <div class="card-header bg-primary text-white">

                        <div class="d-flex align-items-center">

                            <div class="rounded-circle bg-white text-primary d-flex align-items-center justify-content-center mr-3"
                                 style="width:45px;height:45px;">

                                <i class="fas fa-robot fa-lg"></i>

                            </div>

                            <div>

                                <h5 class="mb-0">
                                    DFCH Medical AI Assistant
                                </h5>

                                <small class="opacity-75 patient-ai-status">
                                    Initializing...
                                </small>

                            </div>

                        </div>

                    </div>

                    <div class="card-body">

                        <div class="row align-items-center">

                            <div class="col-md-3 text-center">

                                <img
                                    id="patientAnimationPhoto"
                                    src="${patient.patient_photo || "/uploads/images/default.jpg"}"
                                    class="img-fluid rounded shadow border"
                                    style="
                                        width:220px;
                                        height:220px;
                                        object-fit:cover;
                                        opacity:0;
                                        transform:scale(.85);
                                        transition:.6s ease;
                                    "
                                >

                            </div>

                            <div class="col-md-9">

                                <h3 class="font-weight-bold text-primary mb-2 patient-name">
                                    ${patient.patient_name}
                                </h3>

                                <table class="table table-borderless table-sm mb-0">

                                    <tr>
                                        <th width="170">Patient Code</th>
                                        <td>${patient.patient_code}</td>
                                    </tr>

                                    <tr>
                                        <th>Age</th>
                                        <td>${patient.age} Years</td>
                                    </tr>

                                    <tr>
                                        <th>Gender</th>
                                        <td>${patient.gender}</td>
                                    </tr>

                                    <tr>
                                        <th>Phone</th>
                                        <td>${patient.phone_1 || patient.phone || "N/A"}</td>
                                    </tr>

                                    <tr>
                                        <th>Doctor</th>
                                        <td>${patient.doctor || "N/A"}</td>
                                    </tr>

                                </table>

                            </div>

                        </div>

                    </div>

                </div>

            </div>
        `;

        $("#patientAnimationPhotoContainer").html(html);
    }

    /**
     * Animate section
     */
    function animate() {
        const wrapper = $(".patient-ai-photo-wrapper");

        wrapper.removeClass("d-none").hide().fadeIn(500);

        setTimeout(() => {
            $("#patientAnimationPhoto").css({
                opacity: 1,
                transform: "scale(1)",
            });
        }, 250);
    }

    /**
     * Simulate AI typing
     */
    function typing(message, speed = 25) {
        return new Promise((resolve) => {
            const target = $(".patient-ai-status");

            target.text("");

            let i = 0;

            const interval = setInterval(() => {
                target.text(message.substring(0, i + 1));

                i++;

                if (i >= message.length) {
                    clearInterval(interval);

                    resolve();
                }
            }, speed);
        });
    }

    /**
     * Small thinking animation
     */
    function thinking(seconds = 2) {
        return new Promise((resolve) => {
            const target = $(".patient-ai-status");

            let dots = 0;

            const interval = setInterval(() => {
                dots++;

                target.text("Analyzing Patient Profile" + ".".repeat(dots % 4));
            }, 400);

            setTimeout(() => {
                clearInterval(interval);

                resolve();
            }, seconds * 1000);
        });
    }

    /**
     * Complete status
     */
    function complete() {
        $(".patient-ai-status")
            .removeClass("text-warning")
            .addClass("text-success").html(`
                <i class="fas fa-check-circle mr-1"></i>
                Patient Profile Loaded Successfully
            `);
    }

    /**
     * Clear section
     */
    function clear() {
        $("#patientAnimationPhotoContainer").empty();
    }

    return {
        render,

        animate,

        typing,

        thinking,

        complete,

        clear,
    };
})();
