@extends('layouts.master')
@section('content')
    <h1>{{ $advert->title }}</h1>
    <p>{{ $advert->description }}</p>
@endsection