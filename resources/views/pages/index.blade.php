@extends('layouts.master')

@section('content')
    <div class="-mx-3">
        <div class="px-3">
            <form action="/" method="get" class="flex py-4 px-5 bg-teal rounded">
                <div class="w-4/5">
                    <input type="text" name="search" placeholder="Szukaj pokoi" class="w-full p-2 rounded">
                </div>
                <div class="w-1/5 ml-4">
                    <button class="w-full bg-white rounded p-2">Szukaj</button>
                </div>
            </form>
            <div>
                <ul class="list-reset mt-3">
                    <li><a href="/pokoje">Pokoje</a></li>
                    <li><a href="/miasta">Miasta</a></li>
                </ul>
            </div>
        </div>
    </div>
@endsection