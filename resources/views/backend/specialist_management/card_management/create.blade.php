@extends('adminlte::page')

@section('title', 'Add Specialist Card')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>
            <i class="fas fa-id-card"></i>
            Add Specialist Card
        </h1>
        <a href="{{ route('specialist-cards.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i>
            Back to List
        </a>

    </div>
@stop


@section('content')
    <div class="card card-outline card-primary shadow">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-id-card-alt"></i>
                Card Information
            </h3>
        </div>

        <form action="{{ route('specialist-cards.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row">
                    {{-- Specialist --}}
                    <div class="form-group col-md-6 mb-2">
                        <label>
                            Specialist <span class="text-danger">*</span>
                        </label>
                        <select name="specialist_id" class="form-control @error('specialist_id') is-invalid @enderror">
                            <option value="">Select Specialist</option>
                            @foreach ($specialists as $specialist)
                                <option value="{{ $specialist->id }}"
                                    {{ old('specialist_id') == $specialist->id ? 'selected' : '' }}>
                                    {{ $specialist->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('specialist_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- Card Name --}}
                    <div class="form-group col-md-6 mb-2">
                        <label>
                            Card Name
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control">
                    </div>

                    {{-- Card Type --}}
                    <div class="form-group col-md-4 mb-2">
                        <label>Card Type</label>
                        <select name="card_type" class="form-control">
                            <option value="digital">Digital</option>
                            <option value="print">Print</option>
                        </select>
                    </div>

                    {{-- Theme --}}
                    <div class="form-group col-md-4 mb-2">
                        <label>Card Theme</label>
                        <select name="card_theme" class="form-control">
                            <option value="modern">Modern</option>
                            <option value="classic">Classic</option>
                        </select>
                    </div>

                    {{-- Position --}}
                    <div class="form-group col-md-2 mb-2">
                        <label>Position</label>
                        <input type="number" name="position" value="{{ old('position', 1) }}" class="form-control">
                    </div>

                    {{-- Status --}}
                    <div class="form-group col-md-2 mb-2">
                        <label>Status</label>
                        <select name="is_active" class="form-control">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                    {{-- Background --}}
                    <div class="form-group col-md-6 mb-2">
                        <label>Background Image</label>
                        <input type="file" name="background_image" id="background_image" accept="image/*"
                            class="form-control">
                    </div>

                    {{-- Preview --}}
                    <div class="form-group col-md-6 mb-2 text-center">
                        <label>Preview</label>
                        <br>
                        <img id="previewImage" src="{{ asset('uploads/images/default.jpg') }}" class="img-thumbnail"
                            style="width:180px;height:120px;object-fit:cover;">

                    </div>

                    {{-- Positions --}}
                    <div class="form-group col-md-6 mb-2">
                        <label>Logo Position</label>
                        <select name="logo_position" class="form-control">
                            <option value="top">Top</option>
                            <option value="left">Left</option>
                            <option value="right">Right</option>
                        </select>
                    </div>



                    <div class="form-group col-md-6 mb-2">
                        <label>Photo Position</label>

                        <select name="photo_position" class="form-control">
                            <option value="center">Center</option>
                            <option value="left">Left</option>
                            <option value="right">Right</option>
                        </select>
                    </div>

                    {{-- Display Options --}}
                    <div class="col-md-12 mb-2">
                        <label>
                            Display Options
                        </label>
                        <div class="row">
                            @foreach ([
                            'show_logo' => 'Logo',
                            'show_degree' => 'Degree',
                            'show_designation' => 'Designation',
                            'show_details' => 'Details',
                            'show_qr' => 'QR Code',
                        ] as $field => $label)
                                <div class="col-md-2">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="{{ $field }}"
                                            name="{{ $field }}" value="1" checked>
                                        <label class="custom-control-label" for="{{ $field }}">
                                            {{ $label }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>


                    {{-- Colors --}}
                    <div class="form-group col-md-4 mb-2">
                        <label>
                            Primary Color
                        </label>
                        <input type="color" name="primary_color" value="#8b0000" class="form-control">
                    </div>

                    <div class="form-group col-md-4 mb-2">
                        <label>
                            Secondary Color
                        </label>
                        <input type="color" name="secondary_color" value="#ffffff" class="form-control">
                    </div>

                    <div class="form-group col-md-4 mb-2">
                        <label>Accent Color</label>
                        <input type="color" name="accent_color" value="#00a0d6" class="form-control">
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button class="btn btn-success">
                    <i class="fas fa-save"></i>
                    Save Card
                </button>
                <a href="{{ route('specialist-cards.index') }}" class="btn btn-secondary">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@stop



@section('js')
    <script>
        document.getElementById('background_image')
            .addEventListener('change', function(e) {
                let file = e.target.files[0];
                if (file) {
                    document.getElementById('previewImage').src =
                        URL.createObjectURL(file);

                }

            });
    </script>
@stop
