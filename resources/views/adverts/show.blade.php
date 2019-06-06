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
    <main class="row">
        <div class="col-9">
            <div>
                <img src="{{ $advert->featured_photo_path }}" class="img-fluid mb-4">
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Opis</h5>
                    <p class="card-text">{{ $advert->description }}</p>
                </div>
            </div>
            @if(!$advert->archived)
                <div class="card mt-4">
                    <div class="card-body">
                        <h5 class="card-title">Napisz wiadomosc</h5>
                        <form action="{{ route('conversations.store', [$advert->city->slug, $advert->slug]) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <textarea name="body" id="body" class="form-control accountWarning" placeholder="Twoja wiadomość..." rows="4"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary accountWarning">Wyslij</button>
                        </form>
                        @include('components._errors')
                    </div>
                </div>
            @endif
        </div>
        <div class="col-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Lokalizacja</h5>                    
                    <p class="text-grey-darker">
                        <a href="{{ route('cities.show', $advert->city->slug) }}">{{ $advert->city->name }}</a>@isset($advert->street),&nbsp;{{ $advert->street->name }} @endisset
                    </p>
                </div>
            </div>
            <div class="card mt-4">
                <img src="{{ $advert->user->avatar_path }}" alt="" class="card-img-top rounded-rounded px-4 pt-4">
                <div class="card-body text-center">{!! ucfirst($advert->user->path) !!}</div>
            </div>
            <div class="card mt-4">
                <div class="card-body">
                    <p class="card-title">Czynsz</p>
                    <p class="card-text">{{ $advert->rent }}<small class="ml-1 text-xs text-grey-darker">zł/mc</small></p>
                    <p class="card-title">Media</p>
                    <p class="card-text">{{ $advert->bills }}<small class="ml-1 text-xs text-grey-darker">zł/mc</small></p>
                    <p class="card-title">Kaucja</p>
                    <p class="card-text">{{ $advert->deposit }}<small class="ml-1 text-xs text-grey-darker">zł</small></p>
                </div>
            </div>
        </div>
    </main>
@endsection