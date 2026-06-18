@extends('frontend.layouts.app')

@section('content')
    <style>
        body {
            background: url('{{ asset('uploads/images/welcome_page/cover.png') }}') center/cover no-repeat;
        }
    </style>
    
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
