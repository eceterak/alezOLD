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
        @forelse($adverts as $advert)
            <article class="card">
                <div class="flex -mx-3 mb-4">
                    <div class="flex lg:static lg:w-1/6 items-center justify-center mb-0 lg:mb-0 sm:mb-2 px-3">
                        <img src="/storage/notfound.png">
                    </div>
                    <div class="lg:static lg:w-5/6 px-3">
                        <header clas="flex jutify-between">
                            <h3 class="font-normal text-lg mb-2"><a href="{{ route('adverts.show', [$city->slug, $advert->slug])}}">{{ $advert->title }}</a></h3>
                            @auth
                                <favourite :advert="{{ $advert }}"></favourite>
                            @endauth
                        </header>
                        <section class="px-4">
                            <p class="text-grey-darker">{{ str_limit($advert->description, 100) }}</p>
                        </section>
                    </div>
                </div>
            </article>
        @empty
            <div>Brak ogloszen</div>
        @endforelse
        {{ $adverts->links() }}
    </main>
    {{-- Different aproach --}}
{{--     <city-view :initial-adverts-count="{{ $city->adverts_count }}" inline-template>
        <div>
            <header class="mb-4">
                <h3 class="text-grey-darker">Pokoje na wynajem w {{ $city->name }}</h3>
                <p class="text-grey-darker" v-text="advertsCount"></p>
            </header>
            <main>
                <adverts @removed="advertsCount--"></adverts>
            </main>
        </div>
    </city-view> --}}
@endsection