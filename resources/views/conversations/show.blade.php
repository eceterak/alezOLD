@extends('layouts.master')

@section('lead')
<div class="card">
    <header>
        <h3>{{ $conversation->room->title }}</h3>
    </header>
    <div class="card-content">
        @foreach($conversation->messages as $message)
            @if($message->user->id == auth()->id())
                <p><h5>{{ $message->user->name }} @ {{ $message->created_at }}</h5></p>                
                <p class="mb-4 p-4 border-l-2 border-green bg-green-lightest">{{ $message->body }}</p>
            @else  
                <div>
                    <p><h5>{{ $message->user->name }} @ {{ $message->created_at }}</h5></p>
                    <p class="mb-4 p-4 text-right border-l-2 border-red bg-red-lightest">{{ $message->body }}</p>
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