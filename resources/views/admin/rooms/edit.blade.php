@extends('admin.layouts.master')

@section('content')
    @if(!$room->validated)
        <div class="card flex justify-between items-center mb-5 py-2 px-4 text-white font-bold bg-red">
            <p>Ogłoszenie nie zweryfikowane</p>
            <input type="checkbox" name="validated" id="validated">
        </div>
    @endif
    <div class="card">
        <header>
            <h3>Edytuj pokój</h3>
        </header>
        <div class="card-content">
            <form action="{{ route('admin.rooms.update', $room->path()) }}" method="POST" class="form">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label for="title">Tytuł</label>
                    <input type="text" name="title" id="title" value="{{ $room->title }}">
                </div>
                <div class="form-group">
                    <label for="description">Opis</label>
                    <textarea name="description" id="description">{{ $room->description }}</textarea>
                </div>
                <div class="form-group">
                    <label for="rent">Czynsz</label>
                    <input type="number" name="rent" id="rent" value="{{ $room->rent }}">
                </div>
                @if(App\City::form()->count())
                    <div class="form-group">
                        <label for="city_id">Miasto</label>
                        <select name="city_id" id="city_id">
                            @foreach (App\City::form() as $id => $name)
                                <option value="{{ $id }}" {{ ($id === $room->city->id) ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
                <button type="submit" class="btn btn-reverse">Zapisz</button>
            </form>
        </div>
    </div>
@endsection