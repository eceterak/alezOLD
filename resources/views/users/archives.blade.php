@extends('layouts.master')
@section('breadcrumbs')
    @include('users._menu')
@endsection
@section('content')
    @if($adverts->count())
<<<<<<< HEAD
        <div class="advert-list">
            @foreach($adverts as $advert)
                <div class="advert mb-3 pb-3 border-bottom">
                    <div class="row no-gutters">
                        <div class="col-4 col-lg-2 d-flex align-items-center">
                            <a href="{{ route('adverts.show', [$advert->city->slug, $advert->slug]) }}"><img src="{{ $advert->featured_photo_path }}" class="img-fluid"></a>
                        </div>
                        <div class="col-8 col-lg-10 pl-3">
                            <div class="row h-100 align-content-lg-center">
                                <div class="col-12 col-lg-7 pr-lg-0">
                                    <h5 class="title mb-0">
                                        <a href="{{ route('adverts.show', [$advert->city->slug, $advert->slug]) }}">{{ $advert->title }}</a>
                                    </h5>
                                    <p class="small text-muted mb-0 d-none d-lg-block">Pokój {{ $advert->room_size_translated }}, {{ $advert->city->name }}</p>
                                </div>
                                <div class="col-lg-5 text-lg-right">
                                    <p class="small font-weight-bold mb-0 d-inline mr-4">{{ $advert->visits }}<span class="mt-2 text-xs ml-2"><i class="fas fa-eye"></i></span></p>
                                    <p class="small mb-0 font-weight-bold d-inline">
                                        @if($advert->conversations->count() > 0)        
                                            <a href="{{ route('conversations.advert', $advert->slug) }}">{{ $advert->conversations->count() }}
                                                <span class="mt-2 text-xs ml-2">
                                                    <i class="fas fa-envelope"></i>
                                                </span>
                                            </a>
                                        @else
                                            {{ $advert->conversations->count() }}
                                            <span class="mt-2 text-xs ml-2">
                                                <i class="fas fa-envelope"></i>
                                            </span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
=======
        @foreach($adverts as $advert)
            <div class="card mb-3">
                <div class="row align-items-center">
                    <div class="col-lg-2 d-flex align-items-center">
                        <a href="{{ route('adverts.show', [$advert->city->slug, $advert->slug]) }}"><img src="{{ $advert->featured_photo_path }}" class="img-fluid py-2 pl-2"></a>
                    </div>
                    <div class="col-lg-6">         
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="d-inline mb-0">
                                    <a href="{{ route('adverts.show', [$advert->city->slug, $advert->slug]) }}">{{ $advert->title }}</a>
                                </h5>
                                @if(!$advert->verified)
                                    <button type="button" class="btn btn-link btn-sm p-0 text-warning" data-toggle="tooltip" data-placement="right" title="Ogłoszenie oczekuje na weryfikację przez Administratora.">
                                        <i class="fas fa-question-circle"></i>
                                    </button>
                                @endif
                                <p class="small">Dodano: {{ $advert->created_at->toFormattedDateString() }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 pr-0">
                        <p class="small font-weight-bold mb-0 d-inline mr-3">{{ $advert->visits }}<span class="mt-2 text-xs ml-2"><i class="fas fa-eye"></i></span></p>
                        <p class="small mb-0 font-weight-bold d-inline">
                            @if($advert->conversations->count() > 0)        
                                <a href="{{ route('conversations.advert', $advert->slug) }}">{{ $advert->conversations->count() }}
                                    <span class="mt-2 text-xs ml-2">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                </a>
                            @else
                                {{ $advert->conversations->count() }}
                                <span class="mt-2 text-xs ml-2">
                                    <i class="fas fa-envelope"></i>
                                </span>
                            @endif
                        </p>
                    </div>
>>>>>>> 15ac1e857bcc019b8e56e5adbb56ae2465c9fc78
                </div>
            @endforeach
        </div>
        <div class="mt-4">
            {{ $adverts->links() }}
        </div>
        @else
            <div class="card">
                <div class="card-body text-center">
                    <p class="card-text">Nie masz żadnych archiwalnych ogłoszeń.</p>
                </div>
            </div>
        @endif
        
@endsection