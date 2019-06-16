@extends('layouts.master')
@section('lead')
    <header class="d-flex justify-content-between mb-4">
        <div>
            <h3 class="text-grey-darker">Pokoje na wynajem w <a href="{{ route('cities.show', $city->slug) }}">{{ ucfirst($city->name) }}</a></h3>
            <p class="text-grey-darker mt-1">
                {{ ($adverts->total() > 1) ? 'Znaleziono '.$adverts->total().' ogłoszeń' : ($adverts->total() <= 0 ? '' : 'Znaleziono 1 ogłoszenie') }}
            </p>
            <div>
                <subscribe-button :active="{{ json_encode($city->isSubscribed) }}"></subscribe-button>
            </div>
        </div>
        {{-- <a href="#">pokaż na mapie</a> --}}
    </header>
    <main>
        <div class="small">
            <span class="text-grey-darker">Sortuj:</span>
            <div class="d-inline-block">
                <ul class="list-group list-group-horizontal sort-group">
                    <li class="list-group-item border-0 bg-transparent {{ (request()->has('sort') && request()->sort == 'date') ? 'disabled' : '' }}"><a href="{{ request()->fullUrlWithQuery(['sort' => 'date']) }}">Najnowsze</a></li>
                    <li class="list-group-item border-0 bg-transparent {{ (request()->has('sort') && request()->sort == 'rent_asc') ? 'disabled' : '' }}"><a href="{{ request()->fullUrlWithQuery(['sort' => 'rent_asc']) }}">Najtańsze</a></li>
                    <li class="list-group-item border-0 bg-transparent {{ (request()->has('sort') && request()->sort == 'rent_desc') ? 'disabled' : '' }}"><a href="{{ request()->fullUrlWithQuery(['sort' => 'rent_desc']) }}">Najdroższe</a></li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-9">
                @include('adverts._list')
            </div>
            <div class="col-3">
                @include('cities._filters')
            </div>
        </div>
    </main>
@endsection