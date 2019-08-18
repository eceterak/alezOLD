@extends('layouts.master')
@section('breadcrumbs')
    @include('users._menu')
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <h4 class="card-title mb-4"><a href="{{ route('adverts.show', [$conversation->advert->city->slug, $conversation->advert->slug]) }}">{{ $conversation->advert->title }}</a></h4>
            @foreach($conversation->messages as $message)
                <div class="row mb-3">
                    <div class="col-lg-2 d-flex justify-content-center">
                        <p class="mb-0 font-weight-bold">{!! $message->user->path !!}</p>
                    </div>
                    <div class="col-lg-10 pl-0">
                        <p class="alert mb-1 {{ ($message->user->id == auth()->id()) ? 'alert-primary' : 'alert-light' }}">{{ $message->body }}</p>
                        <p class="small mb-0 text-right">{{ $message->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            @endforeach
            @if($conversation->interlocutor->active)
                @include('components._errors')
                <form action="{{ route('conversations.reply', $conversation->id) }}" method="POST" class="mt-4">
                    @csrf
                    <div class="form-group">
                        <textarea name="body" id="body" class="form-control" rows="5" placeholder="Twoja odpowiedź..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Odpowiedz</button>
                </form>
            @else
                <div class="alert alert-danger mt-5">Twój rozmówca skasował konto</div>
            @endif
        </div>
    </div>
@endsection