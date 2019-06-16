@if($adverts->count())
    @foreach($adverts as $advert)
        <div class="card mb-4 shadow-sm">
            <div class="row no-gutters">
                <div class="d-flex col-md-2 align-items-center py-2 pl-2">
                    <img src="{{ $advert->featured_photo_path }}" class="img-fluid">
                </div>
                <div class="col-md-10">
                    <div class="card-body h-100">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="card-title mb-0">
                                    <a href="{{ route('adverts.show', [$advert->city->slug, $advert->slug]) }}">{{ $advert->title }}</a>
                                </h5>
                                <p class="small text-muted mb-4">{{ $advert->room_size_translated }}</p>
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
        <p>Nie znaleziono żadnych ogłoszeń spełniających podane kryteria.</p>
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