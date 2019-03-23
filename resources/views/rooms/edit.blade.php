@extends('layouts.master')
@section('content')
    <h1>{{ $room->title }}</h1>
    <p>{{ $room->description }}</p>
@endsection