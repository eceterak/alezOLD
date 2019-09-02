@extends('layouts.master')
@section('breadcrumbs')
    <div class="d-flex justify-content-between">
        <div>
            <h3 class="text-grey-darker">{{ $advert->title }}</h3>
            <p class="text-grey-darker mt-1 mb-0">
                <a href="#map" onclick="$('#map').goTo()" class="btn btn-light text-primary font-weight-bold">
                    <i class="fas fa-map-marker fa-sm mr-2"></i>{{ $advert->city->name }} @isset($advert->street),&nbsp;{{ $advert->street->name }} @endisset
                </a>
            </p>
        </div>
        <favourite :advert="{{ $advert }}"></favourite>
    </div>
@endsection
@section('content')
    @if($advert->archived)
        <div class="alert alert-warning">Ogłoszenie zakończone</div>
    @endif
    @if(!$advert->verified)
        <div class="alert alert-warning">Ogłoszenie oczekuje na weryfikację przez administratora</div>
    @endif
    {{-- <p class="text-muted">Dodano {{ $advert->created_at->format('d.m.Y') }}</p> --}}
    {{-- <header class="d-flex justify-content-between align-items-center">
        <div>
        </div>
        <div>
            <h3><strong>{{ $advert->rent }}</strong><small class="ml-1 text-xs text-grey-darker">zł /miesiąc</small></h3>
        </div>
    </header> --}}
    <div class="row">
        <div class="col-md-4 pr-4">
            <div class="card card-dark mb-4">
                <div class="card-body">
                    <h3 class="mb-0"><strong>{{ $advert->rent }}</strong>&nbsp;<small class="ml-1 text-xs text-grey-darker">zł/miesiąc</small></h3>
                </div>
            </div>
            <div class="card card-dark border-bottom-2">
                <div class="card-body row">
                    <div class="col-4">
                        <img src="{{ $advert->user->avatar_path }}" alt="" class="card-img-top img-fluid rounded-circle mb-2" style="width: 5rem; height: 5rem;">
                        {{-- @if($advert->user->adverts->count() > 1)
                            <p class="small mt-3">Więcej od {!! ucfirst($advert->user->path) !!}</p>
                            @foreach($advert->user->adverts->except($advert->id) as $item)
                                <a href="{{ route('adverts.show', [$item->city->slug, $item->slug]) }}">{{ $item->title }}</a>
                            @endforeach
                        @endif --}}
                    </div>
                    <div class="col-8">
                        <p class="font-weight-bold">{!! ucfirst($advert->user->path) !!}</p>
                        @if($advert->hasVisiblePhoneNumber())
                            <phone-number :advert="{{ $advert }}"></phone-number>
                        @endif
                    </div>
                </div>
            </div>
            <div class="my-4 pl-4">
                <p class="text-primary font-weight-bold"><i class="fas fa-bed"></i> Pokój {{ ucfirst($advert->room_size_translated) }}</p>
            </div>
            <div class="card card-dark mb-4 border-top-2">
                <div class="card-body">
                    <p class="card-title text-primary font-weight-bold">Opłaty dodatkowe</p>
                    <dl class="mb-4 row">
                        <dt class="mb-0 col-6">Media</dt>
                        <dl class="mb-0 col-6"><strong>{{ $advert->bills_translated }}</strong><small class="ml-1 text-xs text-grey-darker">zł/mc</small></dl>
                        <dt class="mb-0 col-6">Kaucja</dt>
                        <dl class="mb-0 col-6"><strong>{{ $advert->deposit_translated }}</strong><small class="ml-1 text-xs text-grey-darker">zł</small></dl>
                    </dl>
                    <p class="card-title text-primary font-weight-bold">Dostępność</p>
                    <dl class="mb-4 row">
                        <dt class="mb-0 col-6">Dostępność od</dt>
                        <dl class="mb-0 col-6">{{ $advert->available_from_translated }}</dl>
                        <dt class="mb-0 col-6">Min. pobyt</dt>
                        <dl class="mb-0 col-6">{{ $advert->minimum_stay_translated }}</dl>
                        <dt class="mb-0 col-6">Maks. pobyt</dt>
                        <dl class="mb-0 col-6">{{ $advert->maximum_stay_translated }}</dl>
                    </dl>
                    <p class="card-title text-primary font-weight-bold">Wyposażenie</p>
                    <dl class="mb-4 row">
                        <dt class="mb-0 col-6">Meble</dt>
                        <dl class="mb-0 col-6">{{ $advert->furnished_translated }}</dl>
                        <dt class="mb-0 col-6">Ogród</dt>
                        <dl class="mb-0 col-6">{{ $advert->garden_translated }}</dl>
                        <dt class="mb-0 col-6">Internet</dt>
                        <dl class="mb-0 col-6">{{ $advert->broadband_translated }}</dl>
                        <dt class="mb-0 col-6">Wspólny salon</dt>
                        <dl class="mb-0 col-6">{{ $advert->living_room_translated }}</dl>
                        <dt class="mb-0 col-6">Parking</dt>
                        <dl class="mb-0 col-6">{{ $advert->parking_translated }}</dl>
                        <dt class="mb-0 col-6">Garaż</dt>
                        <dl class="mb-0 col-6">{{ $advert->garage_translated }}</dl>
                    </dl>
                    <p class="card-title text-primary font-weight-bold">Preferowany lokator</p>
                    <dl class="mb-4 row">
                        <dt class="mb-0 col-6">Płeć</dt>
                        <dl class="mb-0 col-6">{{ $advert->gender_translated }}</dl>
                        <dt class="mb-0 col-6">Zatrudnienie</dt>
                        <dl class="mb-0 col-6">{{ $advert->occupation_translated }}</dl>
                        <dt class="mb-0 col-6">Min. wiek</dt>
                        <dl class="mb-0 col-6">{{ $advert->minimum_age_translated }}</dl>
                        <dt class="mb-0 col-6">Maks. wiek</dt>
                        <dl class="mb-0 col-6">{{ $advert->maximum_age_translated }}</dl>
                        <dt class="mb-0 col-6">Dla palących</dt>
                        <dl class="mb-0 col-6">{{ $advert->nonsmoking_translated }}</dl>
                        <dt class="mb-0 col-6">Pary OK</dt>
                        <dl class="mb-0 col-6">{{ $advert->couples_translated }}</dl>
                        <dt class="mb-0 col-6">Zwierzęta OK</dt>
                    <dl class="mb-0 col-6">{{ $advert->pets_translated }}</dl>
                    </dl>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="mBox row">
                        <div class="col-8">
                            <div class="mb-4">
                                <img src="{{ $advert->featured_photo_path }}" class="img-fluid">
                            </div>
                        </div>
                        <div class="col-4 pr-0">
                            <div class="row mb-4">
                                @forelse($advert->photos as $photo)
                                    <div class="col-6"><img src="https://alez.s3.eu-central-1.amazonaws.com/{{ $photo->url }}" alt="" class="img-fluid"></div>
                                @empty
                                    
                                @endforelse
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <h5 class="card-title">Opis</h5>
                        <p class="card-text">{{ $advert->description }}</p>
                    </div>
                    @if(!$advert->archived)
                        <div>
                            <h5 class="card-title">Napisz wiadomość</h5>
                            <form action="{{ route('conversations.store', [$advert->city->slug, $advert->slug]) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <textarea name="body" id="body" class="form-control accountWarning" placeholder="Twoja wiadomość..." rows="4"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary font-weight-bold accountWarning">Wyślij wiadomość</button>
                            </form>
                            @include('components._errors')
                        </div>
                    @endif 
                    <div class="mt-5">
                        <google-map lat="{{ $advert->lat }}" lon="{{ $advert->lon}}" api="{{ env('APP_NAME') }}"></google-map>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection