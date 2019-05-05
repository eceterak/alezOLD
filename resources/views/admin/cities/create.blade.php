@extends('admin.layouts.master')

@section('content')
    @include('admin.cities._form', [
        'route' => ['admin.cities.store'],
        'method' => 'POST',
        'button' => 'Dodaj'
    ])
@endsection