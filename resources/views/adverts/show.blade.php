@extends('layouts.master')
@section('lead')
    <nav>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item">
                <a href="{{ URL::previous()}}" class="small text-muted"><i class="fas fa-angle-double-left fa-sm mr-2"></i>Powrót</a>
            </li>
            <li class="breadcrumb-item">Pokój na wynajem</li>
            <li class="breadcrumb-item">
                <a href="{{ route('cities.show', $advert->city->slug) }}">{{ $advert->city->name }}</a>
            </li>
            @isset($advert->street)
                <li class="breadcrumb-item">{{ $advert->street->name }}</li>
            @endisset
        </ol>
    </nav>
    @if($advert->archived)
        <div class="alert alert-warning">Ogłoszenie zakończone</div>
    @endif
    @if(!$advert->verified)
        <div class="alert alert-warning">Ogłoszenie oczekuje na weryfikację przez administratora</div>
    @endif
    <header class="d-flex justify-content-between align-items-center">
        <div>
            <h2 class="font-normal">{{ $advert->title }}</h2>
            <p><a href="{{ route('cities.show', $advert->city->slug) }}"><i class="fas fa-map-marker fa-sm mr-2"></i>{{ $advert->city->name }}</a>@isset($advert->street),&nbsp;{{ $advert->street->name }} @endisset</p>
            {{-- <p class="text-muted">Dodano {{ $advert->created_at->format('d.m.Y') }}</p> --}}
        </div>
        <div>
            <h3><strong>{{ $advert->rent }}</strong><small class="ml-1 text-xs text-grey-darker">zł /miesiąc</small></h3>
        </div>
    </header>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <div class="mBox">
                        <div class="mb-4">
                            <img src="{{ $advert->featured_photo_path }}" class="img-fluid">
                        </div>
                        <div class="row mb-4">
                            @forelse($advert->photos as $photo)
                                <div class="col-2"><img src="https://alez.s3.eu-central-1.amazonaws.com/{{ $photo->url }}" alt="" class="img-fluid"></div>
                            @empty
                                
                            @endforelse
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
                                <button type="submit" class="btn btn-primary accountWarning">Wyslij</button>
                            </form>
                            @include('components._errors')
                        </div>
                    @endif 
                </div>
                <div class="col-4">
                    <div class="mb-4">
                        <p class="card-title text-primary font-weight-bold">Pokój {{ ucfirst($advert->room_size_translated) }}</p>
                        <favourite :advert="{{ $advert }}"></favourite>
                    </div>
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
                        <dt class="mb-0 col-6">Internet</dt>
                        <dl class="mb-0 col-6">{{ $advert->broadband_translated }}</dl>
                        <dt class="mb-0 col-6">Parking</dt>
                        <dl class="mb-0 col-6">{{ $advert->parking_translated }}</dl>
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
                        <dl class="mb-0 col-6">{{ $advert->smoking_translated }}</dl>
                        <dt class="mb-0 col-6">Pary</dt>
                        <dl class="mb-0 col-6">{{ $advert->couples_translated }}</dl>
                        <dt class="mb-0 col-6">Zwierzęta</dt>
                    <dl class="mb-0 col-6">{{ $advert->pets_translated }}</dl>
                    </dl>
                </div>
                <div class="col-2 pl-0">
                    <div class="text-center">
                        <img src="{{ $advert->user->avatar_path }}" alt="" class="card-img-top img-fluid rounded-circle mb-2" style="width: 5rem; height: 5rem;">
                        <p>{!! ucfirst($advert->user->path) !!}</p>
                        @if($advert->hasVisiblePhoneNumber())
                            <p>Telefon</p>
                            <phone-number :advert="{{ $advert }}"></phone-number>
                        @endif
                    </div>
                </div>
            </div>
            <div class="mt-5">
                <iframe 
                    frameborder="0" 
                    style="width: 100%;"
                    src="https://www.google.com/maps/embed/v1/place?q=place_id:EiZBZGFtYSBCb2NoZW5rYSwgMzAtNjkzIEtyYWvDs3csIFBvbGFuZCIuKiwKFAoSCe11HENBQxZHEb3kqO9aLkrGEhQKEgnRGE41wEQWRxG_ikd2tbZrtA&key=AIzaSyCIGt4_PBVT77N2e6is2UPyTi-5MfPzazM" 
                    allowfullscreen>
                </iframe>
            </div>
        </div>
    </div>


    
@endsection