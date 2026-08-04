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
    <link rel="stylesheet" href="{{ asset('css/backend/specialist_card/show_page/layout.css') }}">
    {{-- Print Preview Front Part --}}
    <link rel="stylesheet" href="{{ asset('css/backend/specialist_card/show_page/print_preview_buttons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/specialist_card/show_page/print_preview_modal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/specialist_card/show_page/print_preview_media.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/specialist_card/show_page/print_preview_controls.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/specialist_card/show_page/print_preview_a4_paper.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/specialist_card/show_page/print_preview_card_grid.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/specialist_card/show_page/print_preview_responsive.css') }}">
    {{-- Print Preview Back Part --}}
    <link rel="stylesheet" href="{{ asset('css/backend/specialist_card/show_page/print_preview_back_layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/specialist_card/show_page/print_preview_back_card.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/specialist_card/show_page/print_preview_back_print.css') }}">
    <div class="design-selection-card">
        <div class="design-selection-header">
            <i class="fas fa-id-card"></i>
            <div>
                <h4>Select Your Card Design</h4>
                <p>
                    Choose the ID card style that best matches your preference. The preview below will update instantly so
                    you can compare each design before making your choice.
                </p>
            </div>
        </div>

        <select name="card_theme" id="card_theme" class="form-control">
            <option value="1" selected>Theme 1</option>
            <option value="2">Theme 2</option>
        </select>
    </div>

    @include('backend.specialist_management.card_management.modals.print_preview_modal')
    <div class="card-preview-container">
        {{-- ========================= CARD DESIGN 1A ========================= --}}
        <div class="card-preview-middle">
            {{-- ========================= FRONT SIDE ========================= --}}
            @include('backend.specialist_management.card_management.format_card.frontcard_layout.front_1')
            {{-- ========================= BACK SIDE ========================= --}}
            @include('backend.specialist_management.card_management.format_card.backcard_layout.back_1')
        </div>
    </div>

    <div class="print-button-container">
        <button type="button" class="btn btn-danger" id="openFrontPrintPreview">

            <i class="fas fa-id-card"></i>
            Print Front Card
        </button>


        <button type="button" class="btn btn-danger" id="openBackPrintPreview">

            <i class="fas fa-id-card-alt"></i>
            Print Back Card
        </button>


        <button type="button" class="btn btn-dark" id="openWholePrintPreview">

            <i class="fas fa-print"></i>
            Print Whole Card
        </button>
    </div>
    <div class="card-preview-container2">
        {{-- ========================= CARD DESIGN 1B ========================= --}}
        {{-- ========================= FRONT SIDE ========================= --}}
        @include('backend.specialist_management.card_management.format_card.frontcard_layout.front_2')
        {{-- ========================= BACK SIDE ========================= --}}
        @include('backend.specialist_management.card_management.format_card.backcard_layout.back_2')
    </div>

    <div class="design-selection-card mt-4">
        <div class="design-selection-header">
            <i class="fas fa-ribbon"></i>
            <div>
                <h4>Select Your Lanyard Design</h4>
                <p>
                    Pick a matching lanyard style to complete the specialist ID card. Try different combinations to find the
                    best professional appearance.
                </p>
            </div>
        </div>

        <select name="lanyard_theme" id="lanyard_theme" class="form-control">
            <option value="1" selected>Theme 1</option>
            <option value="2">Theme 2</option>
            <option value="3">Theme 3</option>
        </select>
    </div>

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
    <script src="{{ asset('js/backend/specialist_management/show_page/print_preview_card_front.js') }}"></script>
    <script src="{{ asset('js/backend/specialist_management/show_page/specialist_card_toggle.js') }}"></script>
    <script src="{{ asset('js/backend/specialist_management/show_page/specialist_lanyard_toggle.js') }}"></script>
@endsection
