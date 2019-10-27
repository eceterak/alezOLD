@extends('layouts.master')
@section('breadcrumbs')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h3>{{ $advert->title }}</h3>
            <button onclick="$('#map').goTo()" class="btn btn-light btn-sm text-primary font-weight-bold mb-0">
                <i class="fas fa-map-marker fa-sm mr-2"></i>{{ $advert->city->name }}@isset($advert->street),&nbsp;{{ $advert->street->name }} @endisset
            </button>
        </div>
        <favourite :advert="{{ $advert }}" class="d-none d-lg-block"></favourite>
    </div>
@endsection
@section('content')
    @if($advert->archived)
        <div class="alert alert-warning">Ogłoszenie zakończone</div>
    @endif
    @if(!$advert->verified)
        <div class="alert alert-warning">Ogłoszenie oczekuje na weryfikację przez administratora</div>
    @endif
    <div class="row advert">
        <div class="col-lg-8">
            <div class="mBox advert-photos mb-2">
                <div class="featured-container">
                    <favourite :advert="{{ $advert }}" class="favourite-button d-block d-lg-none"></favourite>
                    <img src="{{ $advert->featured_photo_path }}" class="img-fluid">
                </div>
                <div class="row d-none d-lg-flex">
                    @foreach($advert->photos as $photo)
                        <div class="col-2 thumbnail-container"><img src="https://alez.s3.eu-central-1.amazonaws.com/{{ $photo->url }}" alt="" class="img-fluid"></div>
                    @endforeach
                </div>
            </div>
            <div class="mb-4">
                <h4 class="d-block d-lg-none">
                    <strong><i class="fas fa-dollar-sign mr-2"></i>{{ $advert->rent }}</strong>&nbsp;<small class="ml-1 text-xs text-grey-darker">zł/miesiąc @if($advert->bills) + media @endif</small>
                </h4>
                <h5 class="card-title">Opis</h5>
                <p class="card-text">{{ $advert->description }}</p>
            </div>
            @if(!$advert->archived)
                <div class="d-none d-lg-block">
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
            <div class="mt-4 mb-4 mb-lg-0 mt-lg-5">
                <google-map lat="{{ $advert->lat }}" lon="{{ $advert->lon}}" api="{{ env('APP_NAME') }}"></google-map>
            </div>
        </div>
        <div class="col-lg-4 pr-4">
            <div class="card card-dark mb-4 d-none d-lg-block">
                <div class="card-body">
                    <h3 class="mb-0 text-center">
                        <strong>{{ $advert->rent }}</strong>&nbsp;<small class="ml-1 text-xs text-grey-darker">zł/miesiąc @if($advert->bills) + media @endif</small>
                    </h3>
                </div>
            </div>
            <div class="card card-dark mb-4 d-none d-lg-block">
                <div class="card-body">
                    @if($advert->hasVisiblePhoneNumber())
                        <button class="btn btn-light accountWarning font-weight-bold rounded-sm btn-block">
                            <phone-number :advert="{{ $advert }}"></phone-number>
                        </button>
                    @endif
                </div>
            </div>
            <div class="card card-dark border-bottom-2 mb-4">
                <div class="card-body row">
                    <div class="col-4">
                        <img src="{{ $advert->user->avatar_path }}" alt="" class="card-img-top img-fluid rounded-circle" style="width: 5rem; height: 5rem;">
                    </div>
                    <div class="col-8 d-flex flex-column">
                        <p class="font-weight-bold">{!! ucfirst($advert->user->path) !!}</p>
                        <a href="{{ route('profiles.show', $advert->user->id) }}" class="btn btn-outline-primary btn-sm px-3 py-2 mt-auto">Ogłoszenia użytkownika</a>
                    </div>
                </div>
            </div>
            <div class="my-4 pl-4">
                <p class="text-primary font-weight-bold"><i class="fas fa-bed"></i> Pokój {{ ucfirst($advert->room_size_translated) }}</p>
            </div>
            <div class="card card-dark border-top-2">
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
    </div>

    <div class="row contact-info d-lg-none fixed-bottom bg-primary p-2 text-center">
        @if($advert->hasVisiblePhoneNumber())
            <div class="col-6 border-right-1">
                <button class="btn btn-link px-0"><phone-number :advert="{{ $advert }}" placeholder="Zadzwoń"></phone-number></button>
            </div>
            <div class="col-6">
                <button class="btn btn-link contact-show"><i class="fas fa-envelope mr-2"></i>Napisz</button>            
            </div>
        @else
            <div class="col-12">
                <button class="btn btn-link contact-show"><i class="fas fa-envelope mr-2"></i>Napisz</button>            
            </div>
        @endif
    </div>

    @if(!$advert->archived)
        <div class="modal fade" id="contact-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Napisz wiadomość</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('conversations.store', [$advert->city->slug, $advert->slug]) }}" method="POST" name="contact-form">
                            @csrf
                            <div class="form-group">
                                <label for="email">E-mail</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="email">Telefon</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="body">Twoja wiadomość</label>
                                <textarea name="body" id="body" class="form-control accountWarning" rows="4"></textarea>
                            </div>
                            <div class="small">
                                <p class="mb-0">Logując się ackeptuję <a href="{{ route('termsAndConditions') }}" target="_blank" rel="noopener noreferrer">Regulamin serwisu alez.pl.</a></p>
                            </div> 
                            @include('components._errors')
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary font-weight-bold accountWarning btn-block" onclick="$('form[name=contact-form]').submit()">Wyślij wiadomość</button>
                    </div>
                </div>
            </div>
        </div>
    @endif 
    
@endsection