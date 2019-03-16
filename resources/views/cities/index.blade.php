@extends('layouts.master')
@section('content')
    <header class="flex mb-4 justify-between items-center">
        <h3 class="text-grey-darker">Miasta</h3>
        <button class="btn">Dodaj</button>
    </header>
    <main class="flex flex-col">
        @forelse($cities as $city)
            <article class="card lg:flex mb-4">
                <div class="flex lg:static lg:w-1/8 items-center justify-center mb-0 lg:mb-0 sm:mb-2">
                    <img src="/storage/notfound.png">
                </div>
                <div class="lg:static lg:w-7/8 lg:pl-2">
                    <header>
                        <h3 class="font-normal text-lg mb-2"><a href="{{ $city->name }}">{{ $city->name }}</a></h3>
                    </header>
                </div>
            </article>
        @empty
            <div>Brak ogloszen</div>
        @endforelse
    </main>
@endsection