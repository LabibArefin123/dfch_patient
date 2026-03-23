<div id="problemModal" class="problem-modal">
    <div class="problem-modal-content modern-modal">

        <link rel="stylesheet" href="{{ asset('css/frontend/login/custom_problem.css') }}">
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

    </div>
</div>
