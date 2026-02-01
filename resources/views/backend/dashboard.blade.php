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
        <div class="row g-4">

            {{-- Total Patients --}}
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="small-box bg-info shadow-sm">
                    <div class="inner">
                        <h3>{{ $totalPatients }}</h3>
                        <p>Total Registered Patients</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-injured"></i>
                    </div>
                </div>
            </div>

            {{-- Today --}}
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="small-box bg-success shadow-sm">
                    <div class="inner">
                        <h3>{{ $todayPatients }}</h3>
                        <p>Patients Registered Today</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-calendar-day"></i>
                    </div>
                </div>
            </div>

            {{-- Weekly --}}
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="small-box bg-warning shadow-sm">
                    <div class="inner">
                        <h3>{{ $weeklyPatients }}</h3>
                        <p>Weekly Patient Registration</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-calendar-week"></i>
                    </div>
                </div>
            </div>

            {{-- Monthly --}}
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="small-box bg-danger shadow-sm">
                    <div class="inner">
                        <h3>{{ $monthlyPatients }}</h3>
                        <p>Monthly Patient Registration</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                </div>
            </div>

        </div>

    </div>

@stop
