<div id="problemModal" class="problem-modal">
    <div class="problem-modal-content">

        <div class="modal-header">
            <h5 class="fw-bold mb-0">Report a System Problem</h5>
            <button type="button" class="close-btn" id="closeModalBtn">×</button>
        </div>

        <form method="POST" action="{{ route('system_problem.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-semibold">Problem ID</label>
                <input type="text" class="form-control" value="Auto Generated" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Problem Title</label>
                <input type="text" name="problem_title" class="form-control"
                    placeholder="Example: Login not working">
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Describe the Problem</label>
                <textarea name="problem_description" class="form-control" rows="4" placeholder="Please explain what happened..."></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Priority Level</label>
                <select name="status" class="form-control">
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                    <option value="critical">Critical</option>
                    {{-- <option value="low">Low – Minor issue</option> 
                        <option value="medium">Medium – Needs attention</option>
                        <option value="high">High – Affects work</option>
                        <option value="critical">Critical – System unusable</option> --}}
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">
                    Attachment (Optional)
                </label>
                <input type="file" name="problem_file" class="form-control" accept="image/*,.pdf">
            </div>

            <button class="btn btn-primary w-100 rounded-pill">
                Submit Problem
            </button>
        </form>

    </div>
</div>
