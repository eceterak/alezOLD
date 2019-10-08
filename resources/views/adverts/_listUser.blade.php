@if($adverts->count())
    <div class="advert-list">
        @foreach($adverts as $advert)
            <div class="advert">
                <div class="row no-gutters">
                    <div class="col-4 col-lg-2 d-flex align-items-center">
                        <a href="{{ route('adverts.show', [$advert->city->slug, $advert->slug]) }}"><img src="{{ $advert->featured_photo_path }}" class="img-fluid"></a>
                    </div>
                    <div class="col-8 col-lg-10 pl-3">
                        <div class="row h-100">
                            <div class="col-12 col-lg-9 pr-0">
                                <h5 class="title mb-0">
                                    <a href="{{ route('adverts.show', [$advert->city->slug, $advert->slug]) }}">{{ $advert->title }}</a>
                                </h5>
                                <p class="small text-muted mb-0">Pokój {{ $advert->room_size_translated }}, {{ $advert->city->name }}</p>
                            </div>
                            <div class="col-12 col-lg-3 text-lg-right">
                                <h3 class="price mb-0">{{ $advert->rent }}<small class="text-muted">&nbsp;zł/mc</small></h3>
                            </div>
                            <div class="col-8 mt-auto">
                                <small><i class="far fa-clock fa-xs"></i> {{ $advert->created_at->diffForHumans() }}</small>
                            </div>
                            <div class="col-4 mt-auto text-right">
                                <favourite :advert="{{ $advert }}"></favourite>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    {{ $adverts->onEachSide(1)->links() }}
@else
    <div class="mt-2">
        <h5>Użytkownik nie posiada żadnych aktywny ogłoszeń</h5>
    </div>
@endif