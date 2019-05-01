@extends('admin.layouts.master')

@section('content')
    <ul class="list-reset flex">
        <li class="card-tab"><a href="{{ route('admin.cities.edit', $city->slug) }}">Miasto</a></li>
        <li class="card-tab"><a href="{{ route('admin.cities.streets', $city->slug) }}">Ulice</a></li>
        <li class="card-tab"><a href="{{ route('admin.cities.adverts', $city->slug) }}">Ogłoszenia</a></li>
    </ul>
    <div class="card mt-5">
        <header>
            <h3>
                Pokoje w {{ $city->name }}
                <small class="text-grey-darker">[{{ $city->rooms->count() }}]</small>
            </h3>
            <a href="/admin/pokoje/dodaj" class="btn">Dodaj</a>
        </header>
        <div>
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-left">Tytuł</th>
                        <th class="text-left">Miasto</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($city->rooms as $room)
                        <tr>
                            <td><a href="{{ route('admin.rooms.edit', $room->path()) }}">{{ $room->shortTitle() }}</a></td>
                            <td><a href="{{ route('admin.cities.edit', $room->city->slug) }}">{{ $room->city->name }}</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection