@extends('admin.layouts.master')

@section('content')
    <div class="card">
        <header>
            <h3>
                Pokoje
                <small class="text-grey-darker">[{{ $rooms->count() }}]</small>
            </h3>
            <a href="/admin/pokoje/dodaj" class="btn">Dodaj</a>
        </header>
        <div>
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-left">Tytuł</th>
                        <th class="text-left">Miasto</th>
                        <th class="text-left">Data dodania</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rooms as $room)
                        <tr>
                            <td><a href="{{ route('admin.rooms.edit', $room->path()) }}">{{ str_limit($room->title, 20, '...') }}</a></td>
                            <td class="fit"><a href="{{ route('admin.cities.edit', $room->city->slug) }}">{{ $room->city->name }}</a></td>
                            <td>{{ $room->created_at->day.'/'.$room->created_at->month.'/'.$room->created_at->year }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection