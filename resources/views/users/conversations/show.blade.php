@extends('layouts.master')

@section('lead')

@include('users._menu', [
    'title' => 'Odebrane',
    'subtitle' => 'Wiadomości od innych użytkowników'
])

<div class="card">
    <div class="card-body">
        <h4 class="card-title mb-4"><a href="{{ route('adverts.show', [$conversation->advert->city->slug, $conversation->advert->slug]) }}">{{ $conversation->advert->title }}</a></h4>
        @foreach($conversation->messages as $message)
            <div class="mb-3">
                <p class="small mb-1">{!! $message->user->path !!} {{ $message->created_at->diffForHumans() }}</p>
                <p class="alert {{ ($message->user->id == auth()->id()) ? 'alert-success' : 'alert-warning' }}">{{ $message->body }}</p>
            </div>
        @endforeach
        <form action="{{ route('conversations.reply', $conversation->id) }}" method="POST" class="mt-4">
            @csrf
            <div class="form-group">
                <textarea name="body" id="body" class="form-control" rows="5" placeholder="Twoja odpowiedź..."></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Odpowiedz</button>
        </form>
    </div>
</div>
@endsection