@extends('admin.layouts.master')

@section('content')
    <ul class="list-reset flex">
        <li class="card-tab"><a href="{{ route('admin.cities.edit', $city->slug) }}">Miasto</a></li>
        <li class="card-tab"><a href="{{ route('admin.cities.streets', $city->slug) }}">Ulice</a></li>
        <li class="card-tab"><a href="{{ route('admin.cities.adverts', $city->slug) }}">Ogłoszenia</a></li>
    </ul>
    <div class="card">
        <header>
            <h3>Edytuj miasto</h3>
        </header>
        <div class="card-content"_>
            <form action="{{ route('admin.cities.update', $city->name) }}" method="POST" class="form">
                @csrf
                @method('PATCH')
                <h3 class="mb-3">Informacje podstawowe</h3>
                <div class="form-group">
                    <label for="name">Nazwa</label>
                    <input type="text" name="name" id="name" value="{{ $city->name }}">
                </div>
                <div class="flex -mx-4">
                    <div class="form-group w-1/2 px-4">
                        <label for="type">Typ</label>
                        <input type="text" name="type" id="type" value="{{ $city->type }}">
                    </div>
                    <div class="form-group w-1/2 px-4">
                        <label for="parent">Miasto nadrzędne</label>
                        <input type="text" name="parent" id="parent" value="{{ $city->parent }}">
                    </div>
                </div>
                <div class="flex -mx-4">
                    <div class="form-group w-1/3 px-4">
                        <label for="community">Gmina</label>
                        <input type="text" name="community" id="community" value="{{ $city->community }}">
                    </div>
                    <div class="form-group w-1/3 px-4">
                        <label for="county">Powiat</label>
                        <input type="text" name="county" id="county" value="{{ $city->county }}">
                    </div>
                    <div class="form-group w-1/3 px-4">
                        <label for="state">Województwo</label>
                        <input type="text" name="state" id="state" value="{{ $city->state }}">
                    </div>
                </div>
                <h3 class="mb-3">Położenie geograficzne</h3>
                <div class="flex -mx-4">
                    <div class="form-group w-1/2 px-4">
                        <label for="lat">Latitiude</label>
                        <input type="text" name="lat" id="lat" value="{{ $city->lat }}">
                    </div>
                    <div class="form-group w-1/2 px-4">
                        <label for="lon">Longtitude</label>
                        <input type="text" name="lon" id="lon" value="{{ $city->lon }}">
                    </div>
                </div>
                <div class="flex -mx-4">
                    <div class="form-group w-1/4 px-4">
                        <label for="west">Zachód</label>
                        <input type="text" name="west" id="west" value="{{ $city->west }}">
                    </div>
                    <div class="form-group w-1/4 px-4">
                        <label for="south">Południe</label>
                        <input type="text" name="south" id="south" value="{{ $city->south }}">
                    </div>
                    <div class="form-group w-1/4 px-4">
                        <label for="east">Wschód</label>
                        <input type="text" name="east" id="east" value="{{ $city->east }}">
                    </div>
                    <div class="form-group w-1/4 px-4">
                        <label for="north">Północ</label>
                        <input type="text" name="north" id="north" value="{{ $city->north }}">
                    </div>
                </div>
                <div class="form-group">
                    <input type="checkbox" name="suggested" id="suggested" {{ $city->suggested ? 'checked' : '' }}>
                    <label for="suggested">Sugerowane</label>
                </div>
                <button type="submit" class="btn btn-reverse">Zapisz</button>
            </form>
        </div>
    </div>
@endsection