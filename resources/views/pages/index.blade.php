@extends('layouts.master')

@section('lead')
    <div class="text-center mb-4">
        {{-- <h1 class="font-normal">Znajdz swoj kawalek podlogi</h1>
        <p class="my-4">Znajdz pokoj sposrod tysiecy.</p> --}}
        <h1 class="font-normal">Znajdź swój kawałek podłogi</h1>
        <p class="m-0">Pokoje na wynajem w największych miastach Polski</p>
    </div>
    <div class="row justify-content-center">
        <div class="col-10 bg-primary rounded shadow-sm p-4">
            <form action="{{ route('search.index') }}" method="get" name="search_master_form" autocomplete="off" id="search_master_form">
                <div class="row">
                    <div class="col-10 form-group mb-0 autocomplete">
                        <input type="text" placeholder="Wpisz miasto..." autocomplete="off" name="city" id="city" class="form-control form-control-lg">
                        <input type="hidden" name="city_id" id="city_id">
                    </div>
                    <div class="col-2 pl-0">
                        <button class="btn btn-block btn-lg bg-white">Szukaj</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @if($suggestedCities->count())
        <div class="row justify-content-center mt-5">
            <div class="col-10 px-0">
                <h5 class="mb-3">Pokoje w miastach</h5>
                <div id="suggested-list" class="row">
                    @foreach($suggestedCities as $city)
                        <div class="col-3 mb-3"><a href="{{ route('cities.show', $city->slug) }}"><i class="fas fa-city suggested-icon"></i>{{ $city->name }}</a></div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
@endsection