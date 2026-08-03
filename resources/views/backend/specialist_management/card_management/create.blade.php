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
                        <label>
                            Card Type <span class="text-danger">*</span>
                        </label>
                        <select name="card_type" class="form-control @error('card_type') is-invalid @enderror">
                            <option value="wide" {{ old('card_type') == 'wide' ? 'selected' : '' }}>Wide</option>
                            <option value="vertical" {{ old('card_type') == 'vertical' ? 'selected' : '' }}>Vertical
                            </option>
                        </select>
                        @error('card_type')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Theme --}}
                    <div class="form-group col-md-4 mb-2">
                        <label>
                            Card Theme <span class="text-danger">*</span>
                        </label>
                        <select name="card_theme" class="form-control @error('card_theme') is-invalid @enderror">
                            <option value="modern" {{ old('card_theme') == 'modern' ? 'selected' : '' }}>Modern</option>
                            <option value="classic" {{ old('card_theme') == 'classic' ? 'selected' : '' }}>Classic</option>
                        </select>
                        @error('card_theme')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
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


                    {{-- Display Options --}}
                    <div class="col-md-12 mb-3">
                        <label class="font-weight-bold">Display Options</label>

                        <div class="row mt-2">

                            @foreach ([
            'show_logo' => 'Hospital Logo',
            'show_degree' => 'Degree',
            'show_designation' => 'Designation',
            'show_details' => 'Additional Details',
        ] as $field => $label)
                                <div class="col-md-3 mb-2">
                                    <div class="custom-control custom-switch">
                                        <input type="hidden" name="{{ $field }}" value="0">

                                        <input type="checkbox" class="custom-control-input" id="{{ $field }}"
                                            name="{{ $field }}" value="1"
                                            {{ old($field, 1) ? 'checked' : '' }}>

                                        <label class="custom-control-label" for="{{ $field }}">
                                            {{ $label }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach

                        </div>
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
