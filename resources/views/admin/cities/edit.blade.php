@extends('admin.layouts.master')

@section('content')
    @component('admin.cities._card', ['city' => $city])
        @include('admin.cities._form', [
            'city' => $city,
            'route' => ['admin.cities.update', $city->slug],
            'method' => 'PATCH',
            'button' => 'Zapisz'
        ])
    @endcomponent
@endsection