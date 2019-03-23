@extends('layouts.master')
@section('content')
    <h1>Dodaj ogłoszenie</h1>
    <div class="flex items-center">
        <form action="/pokoje" method="POST">
            @csrf
            <div>
                <input type="text" name="title">
            </div>
            <div>
                <textarea name="description" cols="30" rows="10"></textarea>
            </div>
            <div>
                <input type="number" name="rent">
            </div>
            <button type="submit">Dodaj</button>
        </form>
    </div>
@endsection