@extends('admin.layouts.master')

@section('content')
    <div class="card">
        <header>
            <h3>Edytuj miasto</h3>
        </header>
        <div class="card-content">
            <form action="{{ route('admin.cities.update', $city->name) }}" method="POST" class="form">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label for="name">Nazwa</label>
                    <input type="text" name="name" id="name" value="{{ $city->name }}">
                </div>
                <div class="form-group">
                    <label for="suggested">Sugerowane</label>
                    <input type="checkbox" name="suggested" id="suggested" {{ $city->suggested ? 'checked' : '' }}>
                </div>
                <button type="submit" class="btn btn-reverse">Zapisz</button>
            </form>
        </div>
    </div>
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
                            <td><a href="{{ route('admin.rooms.edit', $room->path()) }}">{{ str_limit($room->title, 20, '...') }}</a></td>
                            <td><a href="{{ route('admin.cities.edit', $room->city->path()) }}">{{ $room->city->name }}</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        </div>
@endsection