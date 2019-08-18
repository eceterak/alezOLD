@if($adverts->count())
    <div class="small">
        <span class="text-grey-darker">Sortuj:</span>
        <div class="d-inline-block">
            <ul class="list-group list-group-horizontal sort-group">
                <li class="list-group-item border-0 bg-transparent {{ (request()->has('sort') && request()->sort == 'date') ? 'disabled' : '' }}"><a href="{{ request()->fullUrlWithQuery(['sort' => 'date']) }}">Najnowsze</a></li>
                <li class="list-group-item border-0 bg-transparent {{ (request()->has('sort') && request()->sort == 'rent_asc') ? 'disabled' : '' }}"><a href="{{ request()->fullUrlWithQuery(['sort' => 'rent_asc']) }}">Najtańsze</a></li>
                <li class="list-group-item border-0 bg-transparent {{ (request()->has('sort') && request()->sort == 'rent_desc') ? 'disabled' : '' }}"><a href="{{ request()->fullUrlWithQuery(['sort' => 'rent_desc']) }}">Najdroższe</a></li>
            </ul>
        </div>
    </div>
    @foreach($adverts as $advert)
        <div class="card mb-3">
            <div class="row no-gutters">
                <div class="col-lg-3 d-flex align-items-center">
                    <a href="{{ route('adverts.show', [$advert->city->slug, $advert->slug]) }}"><img src="{{ $advert->featured_photo_path }}" class="img-fluid py-2 pl-2"></a>
                </div>
                <div class="col-lg-9">
                    <div class="card-body h-100">
                        <div class="d-flex justify-content-between">
                            <div class="mb-4">
                                <h5 class="card-title mb-0">
                                    <a href="{{ route('adverts.show', [$advert->city->slug, $advert->slug]) }}">{{ $advert->title }}</a>
                                </h5>
                                <p class="small text-muted mb-0">Pokój {{ $advert->room_size_translated }}, {{ $advert->city->name }}</p>
                            </div>
                            <div>
                                <h3 class="mb-0">{{ $advert->rent }}<small class="text-muted">&nbsp;zł/mc</small></h3>
                            </div>
                        </div>
                        <div class="card-text">{{ str_limit($advert->description, 100) }}</div>
                        <div class="d-flex align-items-end justify-content-between">
                            <small>{{ $advert->created_at->toFormattedDateString() }}</small>
                            <favourite :advert="{{ $advert }}"></favourite>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    {{ $adverts->onEachSide(1)->links() }}
@else
    @if(request()->except(['sort', 'page']))
        <h5>Nie znaleziono żadnych ogłoszeń spełniających podane kryteria.</h5>
        <p>Spróbuj bardziej ogólnego zapytania</p>
    @else
        <p>Brak ogłoszeń</p>
    @endif
@endif

{{-- Vue.js aproach --}}
{{--<city-view :initial-adverts-count="{{ $city->adverts_count }}" inline-template>
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