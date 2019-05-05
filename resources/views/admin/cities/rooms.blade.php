@extends('admin.layouts.master')

@section('content')
    @component('admin.cities._card', ['city' => $city])
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
                            <td><a href="{{ route('admin.rooms.edit', $room->slug) }}">{{ $room->shortTitle() }}</a></td>
                            <td><a href="{{ route('admin.cities.edit', $room->city->slug) }}">{{ $room->city->name }}</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endcomponent
@endsection