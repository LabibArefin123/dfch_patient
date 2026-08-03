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
    <link rel="stylesheet" href="{{ asset('css/backend/specialist_card/card_format/card_1/card_design_1_base.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/specialist_card/card_format/card_1/card_design_1_elements.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/specialist_card/card_format/card_1/card_design_1_front.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/specialist_card/card_format/card_1/card_design_1_back.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/specialist_card/card_format/card_2/card_design_2_elements.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/specialist_card/card_format/card_2/card_design_2_front.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/specialist_card/card_format/card_2/card_design_2_back.css') }}">
    <div class="card-preview-container">
        {{-- ========================= CARD DESIGN 1A ========================= --}}
        <div class="card-preview-middle">
            {{-- ========================= FRONT SIDE ========================= --}}
            @include('backend.specialist_management.card_management.format_card.frontcard_layout.front_1')
            {{-- ========================= BACK SIDE ========================= --}}
            @include('backend.specialist_management.card_management.format_card.backcard_layout.back_1')
        </div>

    </div>
    <div class="card-preview-middle2">

        @include('backend.specialist_management.card_management.format_card.frontcard_layout.front_2')

        @include('backend.specialist_management.card_management.format_card.backcard_layout.back_2')

    </div>
    
    @include('backend.specialist_management.card_management.format_card.lanyards.design_1')
    @include('backend.specialist_management.card_management.format_card.lanyards.design_2')
    @include('backend.specialist_management.card_management.format_card.lanyards.design_3')
    <div style="height:50px;"></div>
@stop
