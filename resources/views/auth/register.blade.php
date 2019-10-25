@extends('layouts.master')
@section('breadcrumbs')
    <h3 class="mb-0">Rejestracja</h3>
@endsection
@section('content')
    <div>
        @include('auth.forms._register')
    </div>
@endsection