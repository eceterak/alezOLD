@extends('layouts.master')

@section('lead')     
    @include('rooms._form', [
        'room' => new App\Room,
        'route' => ['rooms.store'],
        'method' => 'POST',
        'header' => 'Dodaj ogłoszenie',
        'button' => 'Dodaj'
    ])
@endsection