@extends('layouts.master')

@section('breadcrumbs')
    @include('users._menu')
@endsection

@section('content')
    @if($conversations->count())
    <div class="conversation-list">
        @foreach($conversations as $conversation)
            <div class="conversation">
                <div class="row align-items-center">
                    <div class="col-3 col-lg-1 text-center">
                        <img src="{{ $conversation->interlocutor->avatar_path }}" alt="" class="card-img-top img-fluid rounded-circle" style="width: 2.5rem; height: 2.5rem;">            
                    </div>
                    <div class="col-9 col-lg-8 pr-lg-0">
                        <p class="mb-0 font-weight-bold">{!! $conversation->interlocutor->path !!}</p>
                        <p class="mb-2"><a href="{{ route('adverts.show', [$conversation->advert->city->slug, $conversation->advert->slug]) }}">({{ $conversation->advert->title }}<i class="fas fa-link fa-xs ml-1"></i>)</a></p>
                        <p class="card-text">
                            @if($conversation->hasNewMessagesFor($profile))
                                <strong><a href="{{ route('conversations.show', $conversation->id) }}">{{ str_limit($conversation->messages()->first()->body, 100) }}</a></strong>
                            @else
                                <a href="{{ route('conversations.show', $conversation->id) }}">{{ str_limit($conversation->messages()->first()->body, 100) }}</a>
                            @endif
                        </p>
                    </div>
                    <div class="col-lg-3 text-right">
                        <p class="mb-0 text-muted">
                            @if($conversation->updated_at->diffInDays() < 1)
                                {{ $conversation->updated_at->format('H:i') }}
                            @else
                                @if($conversation->updated_at->diffInYears() < 1)
                                    {{ $conversation->updated_at->format('j F') }}
                                @else
                                    {{ $conversation->updated_at->format('j F Y') }}
                                @endif
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @else
        <div class="card">
            <div class="card-body text-center">
                <p class="card-text">Nie masz żadnych odebranych wiadomości</p>
            </div>
        </div>
    @endif
@endsection