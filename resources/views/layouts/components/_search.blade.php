<section class="container">
        <header class="text-center text-white">
            <h1 class="hero-header">Znajdź swój kawałek podłogi</h1>
            <p class="hero-sub">Pokoje na wynajem w największych miastach Polski</p>
        </header>
    </section>
    <section class="container pt-3 pb-5">
        <search-bar endpoint="{{ route('search.index') }}"></search-bar>
    </section>
    @if(isset($suggestedCities) && $suggestedCities->count())
        <section class="container pb-7">
            <div class="text-center text-white" id="popular-cities">
                <h5 class="mb-3">Popularne miasta</h5>
                <div class="d-flex justify-content-center ">
                    @foreach($suggestedCities as $city)
                        <a href="{{ route('cities.show', $city->slug) }}" class="btn btn-primary mx-1">{{ $city->name }}</a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</div>