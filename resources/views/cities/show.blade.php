@extends('layouts.master')
@section('content')
    <header class="mb-4">
        <h3 class="text-grey-darker">Pokoje na wynajem w {{ $city->name }}</h3>
        <p class="text-grey-darker">
            {{ $city->adverts->count() > 1 ? 'Znaleziono '.$city->adverts->count().' ogłoszen' : ($city->adverts->count() <= 0 ? '' : 'Znaleziono 1 ogłoszenie') }}
        </p>
    </header>
    <main>
        @forelse($adverts as $advert)
            <article class="card lg:flex mb-4">
                <div class="flex lg:static lg:w-1/8 items-center justify-center mb-0 lg:mb-0 sm:mb-2">
                    <img src="/storage/notfound.png">
                </div>
                <div class="lg:static lg:w-7/8 lg:pl-2">
                    <header>
                        <h3 class="font-normal text-lg mb-2"><a href="{{ route('adverts.show', [$city->slug, $advert->slug])}}">{{ $advert->title }}</a></h3>
                    </header>
                    <section>
                        <p class="text-grey-darker">{{ str_limit($advert->description, 100) }}</p>
                    </section>
                </div>
            </article>
        @empty
            <div>Brak ogloszen</div>
        @endforelse
    </main>
@endsection