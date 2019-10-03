@extends('layouts.master')
@section('breadcrumbs')
    @include('users._menu')
@endsection
@section('content')
    @if($adverts->count())
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
                </div>
            </div>
        @endforeach
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