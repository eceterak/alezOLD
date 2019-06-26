@extends('admin.layouts.master')

@section('content')
    @component('admin.cities._card', ['city' => $city])
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-city fa-xs mr-2"></i>Dodaj ulicę w {{ $city->name }}</h5>
        </div>
        <div class="card-content">
            @include('admin.streets._form', [
                'route' => ['admin.streets.store', $city->slug],
                'method' => 'POST',
                'button' => 'Dodaj'
            ])
        </div>
    @endcomponent
@endsection