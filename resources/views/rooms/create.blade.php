@extends('layouts.master')

@section('lead')     
    @include('rooms._form', [
        'route' => ['rooms.store'],
        'name' => 'create_new_advert',
        'method' => 'POST',
        'header' => 'Dodaj ogłoszenie',
        'button' => 'Dodaj'
    ])
@endsection