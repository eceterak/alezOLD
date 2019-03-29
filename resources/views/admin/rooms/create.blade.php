@extends('admin.layouts.master')

@section('content')
    <div class="card">
        <header>
            <h3>
                Dodaj pokój
            </h3>
        </header>
        <div class="card-content">
            <form action="{{ route('admin.rooms.store') }}" method="POST" class="form">
                @csrf
                <div class="form-group">
                    <label for="title">Tytuł</label>
                    <input type="text" name="title" id="title">
                </div>
                <div class="form-group">
                    <label for="description">Opis</label>
                    <textarea name="description" id="description"></textarea>
                </div>
                <div class="form-group">
                    <label for="rent">Czynsz</label>
                    <input type="number" name="rent" id="rent">
                </div>
                @if(App\City::form()->count())
                    <div class="form-group">
                        <label for="city_id">Miasto</label>
                        <select name="city_id" id="city_id">
                            @foreach (App\City::form() as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
                <button type="submit" class="btn btn-reverse">Dodaj</button>
            </form>
        </div>
    </div>
@endsection