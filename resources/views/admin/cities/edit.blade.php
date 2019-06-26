@extends('admin.layouts.master')

@section('content')
    @component('admin.cities._card', ['city' => $city])
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-city fa-xs mr-2"></i>Edytuj miasto</h5>
        </div>
        @include('admin.cities._form', [
            'city' => $city,
            'route' => ['admin.cities.update', $city->slug],
            'method' => 'PATCH',
            'button' => 'Zapisz'
        ])
    @endcomponent
@endsection