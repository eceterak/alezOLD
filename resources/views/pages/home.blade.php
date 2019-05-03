@extends('layouts.master')

@section('lead')

    @forelse(auth()->user()->rooms as $room)
        <p><a href="{{ route('rooms.show', [$room->city->slug, $room->slug]) }}">{{ $room->title }}</a></p>
    @empty
        
    @endforelse

@endsection