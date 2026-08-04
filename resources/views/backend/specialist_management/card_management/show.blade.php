@extends('adminlte::page')
@section('title', 'Specialist Card Details')
@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-id-card text-danger"></i> Specialist Card</h1>
        <div>
            <a href="{{ route('specialist-cards.edit', $specialistCard->id) }}" class="btn btn-primary"><i
                    class="fas fa-edit"></i> Edit</a>
            <a href="{{ route('specialist-cards.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i>
                Back</a>
        </div>
    </div>
@stop

@section('content')
    <link rel="stylesheet" href="{{ asset('css/backend/specialist_card/lanyard_format/layout_1.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/specialist_card/lanyard_format/layout_2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/specialist_card/lanyard_format/layout_3.css') }}">

    {{-- CARD 1 CSS --}}
    {{-- CARD 1 CSS (base part) --}}
    <link rel="stylesheet"
        href="{{ asset('css/backend/specialist_card/card_format/card_1/card_design_1_base_front_layout.css') }}">
    <link rel="stylesheet"
        href="{{ asset('css/backend/specialist_card/card_format/card_1/card_design_1_base_preview.css') }}">
    <link rel="stylesheet"
        href="{{ asset('css/backend/specialist_card/card_format/card_1/card_design_1_base_front.css') }}">
    {{-- CARD 1 CSS (front part) --}}
    <link rel="stylesheet"
        href="{{ asset('css/backend/specialist_card/card_format/card_1/card_design_1_front_layout.css') }}">
    <link rel="stylesheet"
        href="{{ asset('css/backend/specialist_card/card_format/card_1/card_design_1_front_header.css') }}">
    <link rel="stylesheet"
        href="{{ asset('css/backend/specialist_card/card_format/card_1/card_design_1_front_profile.css') }}">
    <link rel="stylesheet"
        href="{{ asset('css/backend/specialist_card/card_format/card_1/card_design_1_front_footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/specialist_card/card_format/card_1/card_design_1_elements.css') }}">

    {{-- CARD 1 CSS (back part) --}}
    <link rel="stylesheet"
        href="{{ asset('css/backend/specialist_card/card_format/card_1/card_design_1_back_layout.css') }}">
    <link rel="stylesheet"
        href="{{ asset('css/backend/specialist_card/card_format/card_1/card_design_1_back_header.css') }}">
    <link rel="stylesheet"
        href="{{ asset('css/backend/specialist_card/card_format/card_1/card_design_1_back_content.css') }}">
    <link rel="stylesheet"
        href="{{ asset('css/backend/specialist_card/card_format/card_1/card_design_1_back_footer.css') }}">

    {{-- CARD 2 CSS Files --}}
    {{-- CARD 2 CSS (Layout Card) --}}
    <link rel="stylesheet" href="{{ asset('css/backend/specialist_card/card_format/card_2/card_design_2_layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/specialist_card/card_format/card_2/card_design_2_photo.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/specialist_card/card_format/card_2/card_design_2_content.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/specialist_card/card_format/card_2/card_design_2_footer.css') }}">
    {{-- CARD 2 CSS (Front Card) --}}
    <link rel="stylesheet"
        href="{{ asset('css/backend/specialist_card/card_format/card_2/card_design_2_front_layout.css') }}">
    <link rel="stylesheet"
        href="{{ asset('css/backend/specialist_card/card_format/card_2/card_design_2_front_header.css') }}">
    <link rel="stylesheet"
        href="{{ asset('css/backend/specialist_card/card_format/card_2/card_design_2_front_content.css') }}">
    {{-- CARD 2 CSS (Back Card) --}}
    <link rel="stylesheet"
        href="{{ asset('css/backend/specialist_card/card_format/card_2/card_design_2_back_layout.css') }}">
    <link rel="stylesheet"
        href="{{ asset('css/backend/specialist_card/card_format/card_2/card_design_2_back_header.css') }}">
    <link rel="stylesheet"
        href="{{ asset('css/backend/specialist_card/card_format/card_2/card_design_2_back_content.css') }}">
    <link rel="stylesheet"
        href="{{ asset('css/backend/specialist_card/card_format/card_2/card_design_2_back_footer.css') }}">

    <select name="card_theme" id="card_theme" class="form-control">
        <option value="1" selected>Theme 1</option>
        <option value="2">Theme 2</option>
    </select>

    <div class="card-preview-container">
        {{-- ========================= CARD DESIGN 1A ========================= --}}
        <div class="card-preview-middle">
            {{-- ========================= FRONT SIDE ========================= --}}
            @include('backend.specialist_management.card_management.format_card.frontcard_layout.front_1')
            {{-- ========================= BACK SIDE ========================= --}}
            @include('backend.specialist_management.card_management.format_card.backcard_layout.back_1')
        </div>
    </div>
    <div class="card-preview-container2">
        {{-- ========================= CARD DESIGN 1B ========================= --}}
        {{-- ========================= FRONT SIDE ========================= --}}
        @include('backend.specialist_management.card_management.format_card.frontcard_layout.front_2')
        {{-- ========================= BACK SIDE ========================= --}}
        @include('backend.specialist_management.card_management.format_card.backcard_layout.back_2')
    </div>

    <select name="lanyard_theme" id="lanyard_theme" class="form-control">
        <option value="1" selected>Theme 1</option>
        <option value="2">Theme 2</option>
        <option value="3">Theme 3</option>
    </select>

    <div class="lanyard-preview-container">
        @include('backend.specialist_management.card_management.format_card.lanyards.design_1')
    </div>

    <div class="lanyard-preview-container2">
        @include('backend.specialist_management.card_management.format_card.lanyards.design_2')
    </div>

    <div class="lanyard-preview-container3">
        @include('backend.specialist_management.card_management.format_card.lanyards.design_3')
    </div>
    <div style="height:50px;"></div>
@stop

@section('js')
    <script src="{{ asset('js/backend/specialist_management/show_page/specialist_card_toggle.js') }}"></script>
    <script src="{{ asset('js/backend/specialist_management/show_page/specialist_lanyard_toggle.js') }}"></script>
@endsection
