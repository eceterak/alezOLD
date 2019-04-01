@extends('layouts.master')

@section('lead')
    <div class="text-center mb-5">
        <h1 class="font-normal">Znajdz swoj kawalek podlogi.</h1>
        <p class="mt-2">Znajdz pokoj sposrod tysiecy.</p>
    </div>
    <form action="/" method="get" class="flex form p-5 bg-teal rounded">
        <div class="form-group-reverse w-4/5 mb-0">
            <input type="text" name="search" placeholder="Wpisz miasto..." class="w-full p-2 rounded">
        </div>
        <div class="w-1/5 ml-4">
            <button class="w-full h-full btn">Szukaj</button>
        </div>
    </form>
@endsection