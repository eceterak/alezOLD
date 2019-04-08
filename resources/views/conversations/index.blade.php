@extends('layouts.master')

@section('lead')
<div class="card">
    <header>
        <h3>Wysłane</h3>
    </header>
    <div class="card-content">
        @forelse(auth()->user()->conversations() as $conversation)
            <a href="{{ route('conversations.show', $conversation->path()) }}">{{ $conversation->messages->first()->body }}</p>
        @empty
            <h3>Brak wiadomosci</h3>
        @endforelse
    </div>
</div>
@endsection