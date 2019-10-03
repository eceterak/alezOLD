@extends('layouts.master')
@section('breadcrumbs')
    <h3 class="mb-0">Logowanie / Rejestracja</h3>
@endsection
@section('content')
    <div class="row position-relative" id="login-form">
        <div class="position-absolute login-or d-none d-md-block">lub</div>
        <div class="col-md-6 border-right pr-md-7 mb-md-0 mb-4">
            @include('auth.forms._login')
        </div>
        <div class="col-md-6 pl-md-7">
            @include('auth.forms._register')
        </div>
    </div>
@endsection
