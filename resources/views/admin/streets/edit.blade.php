@extends('admin.layouts.master')

@section('content')

    <h1>{{ $street->name }}</h1>
    <form action="{{ route('admin.streets.destroy', [$street->city->slug, $street->id]) }}" method="POST">
        @csrf
        @method('DELETE')
        <button class="btn">Usuń</button>
    </form>

@endsection