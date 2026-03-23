<div id="problemModal" class="problem-modal">
    <div class="problem-modal-content modern-modal">

        <!-- HEADER -->
        <div class="modal-header border-0">
            <h5 class="fw-bold mb-0">🚨 Report a System Problem</h5>
            <button type="button" class="close-btn" id="closeModalBtn">×</button>
        </div>

        <form method="POST" action="{{ route('system_problem.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="row g-3">

                <!-- LEFT SIDE -->
                <div class="col-md-4">

                    <!-- PROGRESS CIRCLE -->
                    <div class="progress-circle-box text-center mb-3">
                        <svg class="progress-ring" width="120" height="120">
                            <circle class="bg" cx="60" cy="60" r="50" />
                            <circle class="progress" cx="60" cy="60" r="50" />
                        </svg>
                        <div class="progress-text" id="progressText">0%</div>
                    </div>

                    <!-- FORM -->
                    <div class="mb-2">
                        <label class="fw-semibold">Problem Title</label>
                        <input type="text" name="problem_title" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label class="fw-semibold">Description</label>
                        <textarea name="problem_description" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="mb-2">
                        <label class="fw-semibold">Priority</label>
                        <select name="status" class="form-control">
                            <option value="low">Low</option>
                            <option value="medium">Medium</option>
                            <option value="high">High</option>
                            <option value="critical">Critical</option>
                        </select>
                    </div>

                    <!-- TABS -->
                    <ul class="nav nav-tabs mt-3">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#singleTab">Single</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#imageTab">Multiple Images</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#fileTab">Multiple Files</a>
                        </li>
                    </ul>

                    <div class="tab-content mt-2">
                        <div class="tab-pane fade show active" id="singleTab">
                            <input type="file" name="problem_file" class="form-control file-input">
                        </div>

                        <div class="tab-pane fade" id="imageTab">
                            <input type="file" name="multiple_images[]" multiple class="form-control file-input">
                        </div>

                        <div class="tab-pane fade" id="fileTab">
                            <input type="file" name="multiple_pdfs[]" multiple class="form-control file-input">
                        </div>
                    </div>

                    <button class="btn btn-success w-100 mt-3">Submit</button>
                </div>

                <!-- MIDDLE -->
                <div class="col-md-3">

                    <!-- PROGRESS BAR -->
                    <div class="progress mb-3" style="height: 8px;">
                        <div class="progress-bar bg-success" id="progressBar" style="width: 0%"></div>
                    </div>

                    <p class="text-muted small" id="progressMessage">Waiting for upload...</p>

                    <!-- PREVIEW -->
                    <div class="preview-box">
                        <h6>📂 Uploaded Files</h6>
                        <div id="previewArea"></div>
                    </div>
                </div>

                <!-- RIGHT SIDE (PDF VIEWER) -->
                <div class="col-md-5">
                    <div class="pdf-viewer">
                        <iframe id="pdfViewer" src="" frameborder="0"></iframe>
                    </div>
                </div>

            </div>
        </form>

        <!-- STYLE -->
        <style>
            .problem-modal-content.modern-modal {
                max-width: 1100px;
                /* sweet spot */
                width: 95%;
                margin: 40px auto;
            }

            .modal-header {
                padding-bottom: 8px;
            }

            .modern-modal {
                border-radius: 14px;
                padding: 16px;
                background: #fff;
            }

            /* PROGRESS CIRCLE */
            .progress-ring circle {
                fill: none;
                stroke-width: 8;
            }

            .progress-ring .bg {
                stroke: #eee;
            }

            .progress-ring .progress {
                stroke: #28a745;
                stroke-dasharray: 314;
                stroke-dashoffset: 314;
                transition: 0.4s;
            }

            .progress-text {
                position: absolute;
                top: 65px;
                left: 50%;
                transform: translate(-50%, -50%);
                font-weight: bold;
                font-size: 18px;
            }

            .progress-circle-box {
                position: relative;
            }

            /* PREVIEW */
            .preview-box {
                border: 1px dashed #ccc;
                padding: 10px;
                border-radius: 10px;
                height: 200px;
                overflow-y: auto;
                background: #fafafa;
            }

            .preview-item {
                display: flex;
                justify-content: space-between;
                background: #fff;
                padding: 6px 10px;
                margin: 5px 0;
                border-radius: 6px;
                font-size: 13px;
            }

            /* PDF VIEWER */
            .pdf-viewer {
                height: 100%;
                border-radius: 10px;
                overflow: hidden;
                border: 1px solid #ddd;
            }

            .pdf-viewer iframe {
                width: 100%;
                height: 100%;
            }

            .form-control {
                padding: 6px 10px;
                font-size: 14px;
            }
        </style>
    </div>
</div>

<script>
    const circle = document.querySelector('.progress-ring .progress');
    const text = document.getElementById('progressText');
    const bar = document.getElementById('progressBar');
    const previewArea = document.getElementById('previewArea');
    const pdfViewer = document.getElementById('pdfViewer');
    const form = document.querySelector('form');

    let percent = 0;

    function updateProgress(val) {
        percent = val;
        const offset = 314 - (314 * percent) / 100;
        circle.style.strokeDashoffset = offset;
        text.innerText = Math.round(percent) + '%';
        bar.style.width = Math.round(percent) + '%';
    }

    // =========================
    // FILE CHANGE
    // =========================
    document.querySelectorAll('.file-input').forEach(input => {
        input.addEventListener('change', function() {

            previewArea.innerHTML = '';
            updateProgress(0);

            const files = [...this.files];
            if (files.length === 0) return;

            const totalFiles = files.length;
            let uploadedFiles = 0;

            files.forEach(file => {
                const div = document.createElement('div');
                div.classList.add('preview-item');
                div.innerText = file.name;
                previewArea.appendChild(div);

                // PDF VIEW
                if (file.type.includes('pdf')) {
                    const url = URL.createObjectURL(file);
                    pdfViewer.src = url;
                }

                // Simulate upload delay per file
                setTimeout(() => {
                    uploadedFiles++;
                    const newPercent = (uploadedFiles / totalFiles) *
                    60; // 60% pre-upload animation
                    updateProgress(newPercent);

                    if (uploadedFiles === totalFiles) {
                        document.getElementById('progressMessage').innerText =
                            "Files ready ✔";
                        // Smooth animation to 60%
                        animateProgress(60);
                    }
                }, 100 * files.indexOf(file)); // stagger for smoothness
            });
        });
    });

    // =========================
    // FORM SUBMIT (FIXED REAL UPLOAD)
    // =========================
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const files = [...document.querySelector('.file-input:enabled').files];
        if (files.length === 0) {
            form.submit();
            return;
        }

        document.getElementById('progressMessage').innerText = "Uploading & processing...";

        let uploaded = 0;

        function uploadNext(index) {
            if (index >= files.length) {
                animateProgress(100, () => form.submit());
                return;
            }

            const file = files[index];
            const fakeUploadTime = Math.min(500, 1000 / files.length); // simulate per-file upload

            setTimeout(() => {
                uploaded++;
                const newPercent = 60 + (uploaded / files.length) * 40; // 60% -> 100%
                updateProgress(newPercent);

                uploadNext(index + 1);
            }, fakeUploadTime);
        }

        uploadNext(0);
    });

    // =========================
    // Smooth animation helper
    // =========================
    function animateProgress(target, callback = null) {
        let current = percent;

        const interval = setInterval(() => {
            if (current >= target) {
                clearInterval(interval);
                updateProgress(target);
                if (callback) callback();
            } else {
                current += 2;
                if (current > target) current = target;
                updateProgress(current);
            }
        }, 15);
    }
</script>
