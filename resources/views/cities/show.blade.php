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
    <div class="card">
        <div class="card-body">
            <form action="{{ url()->full() }}" method="GET" class="form">
                <p class="mb-2">Czynsz</p>
                <div class="flex w-1/2 -mx-4">
                    <div class="form-group w-1/2 px-4">
                        <input type="number" name="rentmin" id="rentmin" class="form-control" value="{{ request('rentmin') }}">
                    </div>
                    <div class="form-group w-1/2 px-4">
                        <input type="number" name="rentmax" id="rentmax" class="form-control" value="{{ request('rentmax') }}">
                    </div>
                </div>
                <div class="flex w-1/2 -mx-4">
                    <div class="form-group w-1/2 px-4">
                        <label for="pets">Zwierzęta</label>
                        <input type="checkbox" name="pets" id="pets" class="form-control" value="1">
                    </div>
                </div>
                @if(request()->filled('sort'))
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                @endif
                <button type="submit" class="btn btn-default">Szukaj</button>
            </form>
        </div>
    </div>
@endsection
@section('content')
    <main>
        <div class="mb-4 text-sm">
            <span class="text-grey-darker">Sortuj:</span>
            <ul class="menu list-reset">
                <li><a href="{{ request()->fullUrlWithQuery(['sort' => 'date']) }}">Najnowsze</a></li>
                <li><a href="{{ request()->fullUrlWithQuery(['sort' => 'rent_asc']) }}">Najtańsze</a></li>
                <li><a href="{{ request()->fullUrlWithQuery(['sort' => 'rent_desc']) }}">Najdroższe</a></li>
            </ul>
        </div>
        @include('adverts._list')
    </main>
@endsection