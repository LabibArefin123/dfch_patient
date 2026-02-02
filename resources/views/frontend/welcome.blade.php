@extends('frontend.layouts.app')

@section('title', 'DFCH - Dr. Fazlul Haque Colorectal Hospital Limited')
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet" />

@section('content')
    @include('frontend.welcome_page.header')
    @include('frontend.welcome_page.banner')
    {{-- @include('frontend.welcome_page.glance')
    @include('frontend.welcome_page.medicine') --}}
    @include('frontend.welcome_page.about')
    @include('frontend.welcome_page.department')
    @include('frontend.welcome_page.facilities') 
    @include('frontend.welcome_page.services') 
    @include('frontend.welcome_page.specialist') 
    @include('frontend.welcome_page.goals') 
    @include('frontend.welcome_page.footer')
@endsection
