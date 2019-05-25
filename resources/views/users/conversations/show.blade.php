@extends('layouts.master')

@section('lead')
<div class="card">
    <div class="card-body">
        <h3 class="mb-4"><a href="{{ route('adverts.show', [$conversation->advert->city->slug, $conversation->advert->slug]) }}">{{ $conversation->advert->title }}</a></h3>
        @foreach($conversation->messages as $message)
            @if($message->user->id == auth()->id())
                <h5 class="mb-2">{{ $message->user->name }} @ {{ $message->created_at }}</h5>
                <p class="mb-4 p-4 border-l-2 border-green bg-green-lightest">{{ $message->body }}</p>
            @else  
                <div>
                    <h5 class="mb-2">{{ $message->user->name }} @ {{ $message->created_at }}</h5>
                    <p class="mb-4 p-4 border-l-2 border-orange bg-orange-lightest">{{ $message->body }}</p>
                </div> 
            @endif
        @endforeach
        <form action="{{ route('conversations.reply', $conversation->id) }}" method="POST" class="form mt-5">
            @csrf
            <div class="form-group">
                <label for="body">Odpowiedz</label>
                <textarea name="body" id="body"></textarea>
            </div>
            <button type="submit" class="btn">Wyslij</button>
        </form>
    </div>
</div>
@endsection