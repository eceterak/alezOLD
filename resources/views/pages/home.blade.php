@extends('layouts.master')

@section('lead')

    @forelse(auth()->user()->adverts as $advert)
        <p><a href="{{ route('adverts.show', [$advert->city->slug, $advert->slug]) }}">{{ $advert->title }}</a></p>
    @empty
        
    @endforelse

@endsection