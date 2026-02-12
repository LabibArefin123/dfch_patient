@extends('adminlte::page')

@section('title', 'DFCH | Patient Dashboard')

@section('content')

    <div class="container-fluid py-4">

        {{-- Header --}}
        <div class="mb-4">
            <h1 class="text-2xl font-weight-bold text-primary">
                Dr. Fazlul Haque Colorectal Hospital
            </h1>
            <p class="text-muted">
                Patient Registration Overview & Reporting Dashboard
            </p>
        </div>

        {{-- Intro Card --}}
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h5 class="font-weight-bold mb-2">
                    👋 Welcome to DFCH Patient Management System
                </h5>
                <p class="mb-0 text-muted">
                    This dashboard provides a quick overview of patient registrations.
                    Daily records are stored automatically, allowing you to generate
                    weekly and monthly reports for analysis and decision-making.
                </p>
            </div>
        </div>

        {{-- Statistics Row --}}
        <div class="row">

            {{-- Total Patients --}}
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="small-box bg-primary shadow">
                    <div class="inner">
                        <h3>{{ $totalPatients }}</h3>
                        <p>Total Registered Patients</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="{{ route('patients.index') }}" class="small-box-footer">
                        View Details <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            {{-- Today --}}
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="small-box bg-success shadow">
                    <div class="inner">
                        <h3>{{ $todayPatients }}</h3>
                        <p>Registered Today</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-calendar-day"></i>
                    </div>
                    <a href="{{ route('patients.index') }}" class="small-box-footer">
                        View Details <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            {{-- Weekly --}}
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="small-box bg-warning shadow">
                    <div class="inner">
                        <h3>{{ $weeklyPatients }}</h3>
                        <p>This Week Registrations</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-calendar-week"></i>
                    </div>
                    <a href="{{ route('patients.index') }}" class="small-box-footer">
                        View Details <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            {{-- Monthly --}}
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="small-box bg-info shadow">
                    <div class="inner">
                        <h3>{{ $monthlyPatients }}</h3>
                        <p>This Month Registrations</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <a href="{{ route('patients.index') }}" class="small-box-footer">
                        View Details <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            {{-- Recommended Section Divider --}}
            <div class="col-12 mb-2">
                <h5 class="text-muted font-weight-bold">
                    ⭐ Recommended Patients Overview
                </h5>
            </div>

            {{-- Total Recommended --}}
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="small-box bg-purple shadow">
                    <div class="inner">
                        <h3>{{ $totalRecommendedPatients }}</h3>
                        <p>Total Recommended Patients</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-md"></i>
                    </div>
                    <a href="{{ route('patients.index') }}" class="small-box-footer">
                        View Details <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            {{-- Today Recommended --}}
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="small-box bg-teal shadow">
                    <div class="inner">
                        <h3>{{ $todayRecommendedPatients }}</h3>
                        <p>Today's Recommended</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-stethoscope"></i>
                    </div>
                    <a href="{{ route('patients.index') }}" class="small-box-footer">
                        View Details <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            {{-- Monthly Recommended --}}
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="small-box bg-dark shadow">
                    <div class="inner">
                        <h3>{{ $monthlyRecommendedPatients }}</h3>
                        <p>Monthly Recommended</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <a href="{{ route('patients.index') }}" class="small-box-footer">
                        View Details <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

        </div>

    </div>
@stop
