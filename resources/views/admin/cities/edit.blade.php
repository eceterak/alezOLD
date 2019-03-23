@extends('admin.layouts.master')

@section('content')
    <div class="card">
        <header>
            <h3>Edytuj miasto</h3>
        </header>
        <div class="card-content">
            <form action="{{ route('admin.cities.update', $city->name) }}" method="POST">
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
@endsection