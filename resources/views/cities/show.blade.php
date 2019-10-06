@extends('layouts.master')

@section('breadcrumbs')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h3>Pokoje na wynajem <a href="{{ route('cities.show', $city->slug) }}">{{ ucfirst($city->name) }}</a>@if(request()->has('radius'))<small>+{{ request('radius') }}km</small>@endif</h3>
            <p class="mb-0">{{ ($adverts->total() > 1) ? 'Znaleziono '.$adverts->total().' ogłoszeń' : ($adverts->total() <= 0 ? '' : 'Znaleziono 1 ogłoszenie') }}</p>
        </div>
        <subscribe-button :active="{{ json_encode($city->isSubscribed) }}"></subscribe-button>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-9 pl-md-4">
            @include('adverts._list')
        </div>
        <div class="col-md-3 d-lg-block filter-box">
            @include('cities._filters')
        </div>
    </div>
@endsection