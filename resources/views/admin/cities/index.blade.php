@extends('admin.layouts.master')

@section('content')
    <header class="flex mb-4 justify-between items-center">
        <h3 class="text-grey-darker">Miasta</h3>
        <a href="/admin/miasta/dodaj" class="btn">Dodaj</a>
    </header>

    <ul>
        @forelse($cities as $city)
            <li>{{ $city->name }}</li>
        @empty
            <p>Brak miast do wyswietlenia</p>
        @endforelse
    </ul>
@endsection