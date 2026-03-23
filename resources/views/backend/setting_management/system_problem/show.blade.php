@extends('adminlte::page')

@section('title', 'View System Problem')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <h1 class="mb-0">System Problem Details</h1>

        <div class="btn-group">
            <a href="{{ route('system_problems.edit', $systemProblem->id) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Edit
            </a>

            <a href="{{ route('system_problems.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Go Back
            </a>
        </div>
    </div>
@stop

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">

            <div class="row">

                {{-- Problem ID --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Problem ID</label>
                    <input type="text" class="form-control" value="{{ $systemProblem->problem_uid }}" readonly>
                </div>

                {{-- Priority --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Priority</label>
                    <input type="text" class="form-control" value="{{ ucfirst($systemProblem->status) }}" readonly>
                </div>

                {{-- Title --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Problem Title</label>
                    <input type="text" class="form-control" value="{{ $systemProblem->problem_title }}" readonly>
                </div>

                {{-- Reported Date --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Reported At</label>
                    <input type="text" class="form-control"
                        value="{{ $systemProblem->created_at->format('d M Y, h:i A') }}" readonly>
                </div>

                {{-- Description --}}
                <div class="col-md-12 mb-3">
                    <label class="form-label fw-semibold">Problem Description</label>
                    <textarea class="form-control" rows="5" readonly>{{ $systemProblem->problem_description }}</textarea>
                </div>

                {{-- Remarks --}}
                <div class="col-md-12 mb-3">
                    <label class="form-label fw-semibold">Remarks</label>

                    @if (!empty($systemProblem->remarks))
                        <div class="alert alert-success shadow-sm">
                            {{ $systemProblem->remarks }}
                        </div>
                    @else
                        <div class="alert alert-light text-muted">
                            No remarks added yet.
                        </div>
                    @endif
                </div>

                {{-- Attachments --}}
                <div class="col-md-12 mb-3">
                    <label class="form-label fw-semibold">Attachments</label>

                    @php
                        $attachments = [];

                        // Single file
                        if ($systemProblem->problem_file) {
                            $attachments[] = [
                                'name' => $systemProblem->problem_file,
                                'type' => pathinfo($systemProblem->problem_file, PATHINFO_EXTENSION),
                            ];
                        }

                        // Multiple images
                        if (!empty($systemProblem->multiple_images) && is_array($systemProblem->multiple_images)) {
                            foreach ($systemProblem->multiple_images as $img) {
                                if ($img) {
                                    $attachments[] = [
                                        'name' => $img,
                                        'type' => pathinfo($img, PATHINFO_EXTENSION),
                                    ];
                                }
                            }
                        }

                        // Multiple PDFs / other files
                        if (!empty($systemProblem->multiple_pdfs) && is_array($systemProblem->multiple_pdfs)) {
                            foreach ($systemProblem->multiple_pdfs as $pdf) {
                                if ($pdf) {
                                    $attachments[] = [
                                        'name' => $pdf,
                                        'type' => pathinfo($pdf, PATHINFO_EXTENSION),
                                    ];
                                }
                            }
                        }
                    @endphp

                    @if (count($attachments) > 0)
                        <div class="d-flex flex-wrap mt-2">
                            @foreach ($attachments as $file)
                                @php
                                    $ext = strtolower($file['type']);
                                    $name = $file['name'];
                                    $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif']);
                                    $isPDF = $ext === 'pdf';

                                    // Map correct path
                                    if ($isImage) {
                                        $filePath = asset('uploads/problem/images/' . $name);
                                    } else {
                                        $filePath = asset('uploads/problem/files/' . $name);
                                    }
                                @endphp

                                @if ($isImage)
                                    <div class="me-2 mb-2">
                                        <a href="{{ $filePath }}" target="_blank">
                                            <img src="{{ $filePath }}" class="img-thumbnail" style="max-height:150px;">
                                        </a>
                                    </div>
                                @elseif($isPDF)
                                    <div class="me-2 mb-2">
                                        <a href="{{ $filePath }}" target="_blank" class="btn btn-outline-info">
                                            <i class="fas fa-file-pdf"></i> {{ basename($name) }}
                                        </a>
                                    </div>
                                @else
                                    <div class="me-2 mb-2">
                                        <a href="{{ $filePath }}" target="_blank" class="btn btn-outline-secondary">
                                            <i class="fas fa-file"></i> {{ basename($name) }}
                                        </a>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">No attachments provided.</p>
                    @endif
                    {{-- Floating Remarks Button (Admin Only) --}}
                    @role('admin')
                        @if (empty($systemProblem->remarks))
                            <button id="remarksBtn" class="btn btn-primary shadow"
                                style="position: absolute; bottom: 20px; right: 20px;">
                                <i class="fas fa-comment-dots"></i> Add Remarks
                            </button>
                        @endif
                    @endrole
                </div>
            </div>
        </div>
    </div>

    <div class="mb-4"></div>
@stop
@section('js')
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

    <script>
        $(document).on('click', '#remarksBtn', function() {

            Swal.fire({
                title: 'Add Remarks',
                html: `
            <select id="remark_type" class="swal2-input">
                <option value="">Select Option</option>
                <option value="solved">✔ Problem Solved</option>
                <option value="custom">✍ Custom Message</option>
            </select>

            <div id="custom_remark_container" style="display:none; margin-top:10px;">
                <div id="custom_remark_editor" style="height:150px; background:#fff;"></div>
            </div>
        `,
                showCancelButton: true,
                confirmButtonText: 'Save',
                didOpen: () => {
                    const select = document.getElementById('remark_type');
                    const container = document.getElementById('custom_remark_container');

                    // Initialize Quill editor
                    let quill;
                    select.addEventListener('change', function() {
                        if (this.value === 'custom') {
                            container.style.display = 'block';
                            if (!quill) {
                                quill = new Quill('#custom_remark_editor', {
                                    theme: 'snow',
                                    placeholder: 'Write your custom message...',
                                    modules: {
                                        toolbar: [
                                            [{
                                                'header': [1, 2, 3, false]
                                            }],
                                            ['bold', 'italic', 'underline',
                                                'strike'],
                                            [{
                                                'list': 'ordered'
                                            }, {
                                                'list': 'bullet'
                                            }],
                                            [{
                                                'align': []
                                            }],
                                            ['link', 'clean']
                                        ]
                                    }
                                });
                            }
                        } else {
                            container.style.display = 'none';
                        }
                    });
                },
                preConfirm: () => {
                    const type = document.getElementById('remark_type').value;
                    let custom = '';

                    if (type === 'custom') {
                        const quillEditor = document.querySelector('#custom_remark_editor .ql-editor');
                        custom = quillEditor ? quillEditor.innerHTML.trim() : '';
                    }

                    if (!type) {
                        Swal.showValidationMessage('Please select a remark type');
                    }

                    if (type === 'custom' && !custom) {
                        Swal.showValidationMessage('Custom message is required');
                    }

                    return {
                        type,
                        custom
                    };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post("{{ route('system_problems.remarks', $systemProblem->id) }}", {
                        _token: '{{ csrf_token() }}',
                        type: result.value.type,
                        custom: result.value.custom
                    }).done(function() {
                        Swal.fire('Saved!', 'Remarks added successfully.', 'success')
                            .then(() => location.reload());
                    }).fail(function() {
                        Swal.fire('Error', 'Failed to save remarks.', 'error');
                    });
                }
            });

        });
    </script>
@endsection
