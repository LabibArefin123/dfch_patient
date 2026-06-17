@extends('frontend.layouts.app')

@section('content')
    <style>
        body {
            background: url('{{ asset('uploads/images/welcome_page/cover.png') }}') center/cover no-repeat;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/backend/login_page/login_base.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/login_page/login_layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/login_page/login_logo.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/login_page/login_buttons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/login_page/login_modal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/login_page/login_responsive.css') }}">
    <div class="login-wrapper">
        <div class="login-glass" id="sliderContainer">
            @include('auth.custom_login_page.left')
            @include('auth.custom_login_page.right')
        </div>
    </div>
    @include('auth.custom_login_page.modal.problem')
    <script src="{{ asset('js/custom_frontend/login_page/problem.js') }}"></script>
    <script src="{{ asset('js/custom_frontend/login_page/login.js') }}"></script>
@endsection
