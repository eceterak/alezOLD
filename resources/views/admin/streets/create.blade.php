@extends('admin.layouts.master')

@section('content')
    @component('admin.cities._card', ['city' => $city])
        <header>
            <h3>Dodaj ulicę w {{ $city->name }}</h3>
        </header>
        <div class="card-content">
            @include('admin.streets._form', [
                'route' => ['admin.streets.store', $city->slug],
                'method' => 'POST',
                'button' => 'Dodaj'
            ])
        </div>
    @endcomponent
@endsection