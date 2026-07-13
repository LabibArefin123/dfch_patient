{{-- ===========================================================
| Premium Patient Summary Image Viewer
=========================================================== --}}
<div id="patientSummaryImageViewer" class="position-absolute w-100 h-100 d-none"
    style="
        top:0;
        left:0;
        z-index:9999;
        background:rgba(8,15,30,.92);
        backdrop-filter:blur(12px);
        -webkit-backdrop-filter:blur(12px);
    ">

    {{-- Premium Top Bar --}}
    <div class="position-absolute w-100 px-4 py-3 d-flex align-items-center justify-content-between"
        style="
            top:0;
            left:0;
            z-index:10000;
            background:linear-gradient(
                to bottom,
                rgba(0,0,0,.55),
                rgba(0,0,0,0)
            );
        ">

        <div class="text-white">

            <h5 class="mb-1 font-weight-bold">

                <i class="fas fa-image text-info mr-2"></i>

                Cancer Photo Preview

            </h5>

            <small class="text-light">

                Click the image to zoom.

            </small>

        </div>

        <button id="closePatientSummaryImageViewer" type="button"
            class="btn d-flex align-items-center rounded-pill px-3 py-2"
            style="
                background:rgba(255,255,255,.12);
                color:#fff;
                border:1px solid rgba(255,255,255,.18);
                backdrop-filter:blur(10px);
                transition:.25s;
            ">

            <i class="fas fa-times mr-2"></i>

            Close

        </button>

    </div>

    {{-- Image Area --}}
    <div class="d-flex align-items-center justify-content-center h-100 px-5 py-4">

        <div class="position-relative rounded-4 overflow-hidden shadow-lg"
            style="
                background:#fff;
                padding:14px;
                max-width:95%;
                max-height:92%;
                border:1px solid rgba(255,255,255,.15);
            ">

            <img id="patientSummaryZoomImage" src="" class="img-fluid rounded"
                style="
                    max-height:82vh;
                    max-width:100%;
                    object-fit:contain;
                    transition:transform .25s ease;
                    cursor:zoom-in;
                    user-select:none;
                    display:block;
                ">

        </div>

    </div>

    {{-- Bottom Hint --}}
    <div class="position-absolute w-100 text-center"
        style="
            bottom:20px;
            left:0;
            z-index:10000;
        ">

        <span class="px-3 py-2 rounded-pill"
            style="
                background:rgba(255,255,255,.12);
                color:#fff;
                backdrop-filter:blur(8px);
                font-size:.85rem;
            ">

            <i class="fas fa-search-plus mr-2"></i>

            Click image to Zoom • Press ESC to Close

        </span>

    </div>

</div>
