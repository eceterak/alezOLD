@extends('layouts.master')
@section('lead')
    @if($advert->archived)
        <div class="alert alert-warning">Ogłoszenie zakończone.</div>
    @endif
    <header class="d-flex justify-content-between">
        <div>
            <h2 class="font-normal">{{ $advert->title }}</h2>
            <p class="text-muted">{{ $advert->created_at->format('d.m.Y') }}</p>
        </div>
        <div>
            @can('update', $advert)
                <form action="{{ route('adverts.destroy', [$advert->city->slug, $advert->slug]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <a href="{{ route('adverts.edit', [$advert->city->slug, $advert->slug]) }}" class="btn btn-outline-primary d-inline-block mr-2">Edytuj</a>
                    <button class="btn btn-outline-primary d-inline-block">Usuń</button>
                </form>
            @endcan
        </div>
    </header>
    <div class="row">
        <div class="col-10">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-8">
                            <div class="mb-4">
                                <img src="{{ $advert->featured_photo_path }}" class="img-fluid">
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
                                <p class="text-grey-darker card-text">
                                    <a href="{{ route('cities.show', $advert->city->slug) }}">{{ $advert->city->name }}</a>@isset($advert->street),&nbsp;{{ $advert->street->name }} @endisset
                                </p>
                            </div>
                            <div class="mb-4">
                                <p class="card-title">Czynsz <strong>{{ $advert->rent }}</strong><small class="ml-1 text-xs text-grey-darker">zł/mc</small></p>
                                <p class="card-title">Media <strong>{{ $advert->bills }}</strong><small class="ml-1 text-xs text-grey-darker">zł/mc</small></p>
                                <p class="card-title">Kaucja <strong>{{ $advert->deposit }}</strong><small class="ml-1 text-xs text-grey-darker">zł</small></p>
                            </div>
                            <section>
                                <p>Wielkość pokoju</p>
                                <p>{{ $advert->room_size}}</p>
                            </section>
                            <section>
                                <p>Pokój dla</p>
                                <p>{{ $advert->gender }}</p>
                            </section>

                            <section>
                                <p>Długość pobytu</p>
                                <p>{{ $advert->minimum_stay }} - {{ $advert->maximum_stay }}</p>        
                            </section>
                                
                            <section>
                                <p>Preferowany</p>
                                <p>{{ $advert->occupation }}</p>
                            </section>

                            <section>
                                <p>Wiek</p>
                                <p>{{ $advert->minimum_age }} - {{ $advert->maximum_age }}</p>
                            </section>

                            <section>
                                <p>Wolny od</p>
                                <p>{{ $advert->available_from }}</p>
                            </section>
                                <section>
                                    <p>Inne</p>
                                    <p>{{ $advert->smoking }}</p>
                                    <p>{{ $advert->parking }}</p>
                                    <p>{{ $advert->couples }}</p>
                                </section>



                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-2">
            <div class="text-center">
                <img src="{{ $advert->user->avatar_path }}" alt="" class="card-img-top img-fluid rounded-circle mb-2" style="width: 5rem; height: 5rem;">
                <p>{!! ucfirst($advert->user->path) !!}</p>
            </div>
        </div>
    </div>
    
@endsection