@extends('layouts.master')

@section('content')
    <p>{{ $city->name }}</p>

    @foreach ($city->adverts as $advert)
        <p>{{ $advert->title }}</p>
    @endforeach
@endsection