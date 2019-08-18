@extends('layouts.master')
@section('breadcrumbs')
    <div class="d-flex justify-content-between">
        <div>
            <h3 class="text-grey-darker">
                Pokoje na wynajem <a href="{{ route('cities.show', $city->slug) }}">{{ ucfirst($city->name) }}</a>
                @if(request()->has('radius'))
                    <small>+{{ request('radius') }}km</small>
                @endif
            </h3>
            <p class="text-grey-darker mt-1 mb-0">
                {{ ($adverts->total() > 1) ? 'Znaleziono '.$adverts->total().' ogłoszeń' : ($adverts->total() <= 0 ? '' : 'Znaleziono 1 ogłoszenie') }}
            </p>
        </div>
        <subscribe-button :active="{{ json_encode($city->isSubscribed) }}"></subscribe-button>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-3">
            @include('cities._filters')
        </div>
        <div class="col-md-9 pl-4">
            @include('adverts._list')
        </div>
    </div>
@endsection