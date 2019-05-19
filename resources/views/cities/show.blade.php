@extends('layouts.master')
@section('lead')
    <header class="flex justify-between mb-4">
        <div>
            <h3 class="text-grey-darker">Pokoje na wynajem w {{ ucfirst($city->name) }}</h3>
            <p class="text-grey-darker mt-1">
                {{ ($adverts->total() > 1) ? 'Znaleziono '.$adverts->total().' ogłoszeń' : ($adverts->total() <= 0 ? '' : 'Znaleziono 1 ogłoszenie') }}
            </p>
        </div>
        <subscribe-button :active="{{ json_encode($city->isSubscribed) }}"></subscribe-button>
    </header>
    <main>
        <div>Sort by <a href="{{ route('cities.show', $city->slug) }}?rent=desc">Rent</a></div>
        @include('adverts._list')
    </main>
@endsection