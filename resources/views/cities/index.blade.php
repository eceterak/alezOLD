@extends('layouts.master')
@section('breadcrumbs')
    <h3 class="mb-0">Miasta</h3>
@endsection
@section('content')
    <div>
        @forelse($stateCities as $state => $cities)
            <p>{{ $state }}</p>
            <div class="row">
                @foreach($cities as $city)
                    <div class="col-2">
                        <a href="{{ route('cities.show', $city->slug) }}">{{ $city->name }} <small>[{{ $city->adverts_count }}]</small></a>
                    </div>
                @endforeach
            </div>
        @empty
            <div>Brak miast w bazie danych</div>
        @endforelse
    </div>
@endsection