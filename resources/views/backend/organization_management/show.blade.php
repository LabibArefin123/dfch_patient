@extends('adminlte::page')

@section('title', 'Organization Information')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <h1 class="mb-0">Organization Details</h1>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-group ">
                            <label>Logo Name</label>
                            <input type="text" class="form-control" value="{{ $organization->organization_logo_name }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group ">
                            <label>Name</label>
                            <input type="text" class="form-control" value="{{ $organization->name }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group ">
                            <label>Slogan</label>
                            <input type="text" class="form-control" value="{{ $organization->organization_slogan }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group ">
                            <label>Location</label>
                            <input type="text" class="form-control" value="{{ $organization->organization_location }}" readonly>
                        </div>
                    </div>

                   
                </div>
            </div>
        </div>
    </div>
@stop
