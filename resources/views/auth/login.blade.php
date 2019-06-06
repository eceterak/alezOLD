@extends('layouts.master')

@section('lead')
    <nav class="nav nav-tabs col-8 mx-auto mb-0" role="tablist">
        <a class="nav-link active" data-toggle="tab" href="#login">Zaloguj się</a>
        <a class="nav-link" data-toggle="tab" href="#register">Zarejestruj się</a>
    </nav>
    <div class="card col-8 mx-auto tab-content py-4">
        <div class="tab-pane fade show active" id="login" role="tabpanel">
            @include('auth.forms._login')
        </div>
        <div class="tab-pane fade" id="register" role="tabpanel">
            @include('auth.forms._register')
        </div>
    </div>
@endsection
