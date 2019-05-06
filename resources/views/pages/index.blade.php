@extends('layouts.master')

@section('lead')
    <div class="text-center mb-5">
        <h1 class="font-normal">Znajdz swoj kawalek podlogi</h1>
        <p class="my-4">Znajdz pokoj sposrod tysiecy.</p>
    </div>
    <form action="{{ route('search.index') }}" method="get" name="search_master_form" autocomplete="off" id="search_master_form" class="flex mx-auto form p-5 bg-teal rounded">
        <div class="form-group-reverse autocomplete w-4/5 mb-0">
            <input type="text" placeholder="Wpisz miasto..." autocomplete="off" name="city" id="city" class="w-full p-2 rounded">
            <input type="hidden" name="city_id" id="city_id">
        </div>
        <div class="w-1/5 ml-4">
            <button class="w-full h-full btn">Szukaj</button>
        </div>
    </form>
@endsection
@section('content')
    @if($cities->count())
    <p class="mb-4 text-lg">Popularne miasta</p>
    <div class="flex flex-wrap" id="suggested-list">
        @foreach($cities as $city)
            <div class="flex w-1/4 items-center my-3"><a href="{{ route('cities.show', $city->slug) }}"><i class="fas fa-city suggested-icon"></i>{{ $city->name }}</a></div>
        @endforeach
    </div>
    @endif
@endsection