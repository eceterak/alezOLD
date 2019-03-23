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
                        <th class="text-left">Nazwa</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rooms as $room)
                        <tr>
                            <td><a href="{{ $room->path(true) }}">{{ $room->title }}</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection