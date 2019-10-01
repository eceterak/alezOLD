@if($adverts->count())
    @foreach($adverts as $advert)
        <div class="card mb-3">
            <div class="row no-gutters">
                <div class="col-lg-2 d-flex align-items-center">
                    <a href="{{ route('adverts.show', [$advert->city->slug, $advert->slug]) }}"><img src="{{ $advert->featured_photo_path }}" class="img-fluid py-2 pl-2"></a>
                </div>
                <div class="col-lg-10">
                    <div class="card-body h-100 d-flex flex-column">
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
                        <div class="d-flex align-items-end justify-content-between mt-auto">
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
    <div class="mt-2">
        <h5>Brak ogłoszeń</h5>
    </div>
@endif