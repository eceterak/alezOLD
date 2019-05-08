@extends('admin.layouts.master')

@section('content')
<div class="card">
    <header>
        <h3>Edytuj pokój</h3>
    </header>
        <div class="card-content">
            <form action="{{ route('admin.adverts.update', $advert->slug) }}" method="POST" class="form">
                @csrf
                @method('PATCH')
                @if(!$advert->verified)
                    <div class="card flex justify-between items-center mb-5 py-2 px-4 text-white font-bold bg-red">
                        <p>Ogłoszenie nie zweryfikowane</p>
                        <input type="checkbox" name="verified" id="verified" value="1" onclick="this.form.submit()">
                    </div>
                @endif
                <div class="form-group">
                    <label for="title">Tytuł</label>
                    <input type="text" name="title" id="title" value="{{ $advert->title }}">
                </div>
                <div class="form-group">
                    <label for="description">Opis</label>
                    <textarea name="description" id="description">{{ $advert->description }}</textarea>
                </div>
                <div class="form-group">
                    <label for="rent">Czynsz</label>
                    <input type="number" name="rent" id="rent" value="{{ $advert->rent }}">
                </div>
               
                <button type="submit" class="btn btn-reverse">Zapisz</button>
            </form>
            <form action="{{ route('admin.adverts.destroy', $advert->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="btn">Usuń</button>
            </form>
            <div>
                <ul class="list-reset mt-4">
                    @foreach($advert->activities as $activity)
                        <li>{{ $activity->description }} {{ $activity->created_at->diffForHumans() }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection