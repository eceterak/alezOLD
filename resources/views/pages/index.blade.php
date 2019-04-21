@extends('layouts.master')

@section('lead')
    <div class="text-center mb-5">
        <h1 class="font-normal">Znajdz swoj kawalek podlogi.</h1>
        <p class="mt-2">Znajdz pokoj sposrod tysiecy.</p>
    </div>
    <form action="{{ route('search.index') }}" method="get" name="search_master_form" autocomplete="off" id="search_master_form" class="flex form p-5 bg-teal rounded">
        <div class="form-group-reverse autocomplete w-4/5 mb-0">
            <input type="text" placeholder="Wpisz miasto..." autocomplete="off" name="city" id="city" class="w-full p-2 rounded">
            <input type="hidden" name="city_id" id="city_id">
        </div>
        <div class="w-1/5 ml-4">
            <button class="w-full h-full btn">Szukaj</button>
        </div>
    </form>
@endsection