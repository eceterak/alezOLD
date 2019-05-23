@extends('layouts.master')
@section('lead')
    <header class="flex justify-between">
        <div>
            <h2 class="font-normal mb-4">{{ $advert->title }}</h2>
            <p class="text-xs text-grey-darker">{{ $advert->created_at->format('d.m.Y') }}</p>
        </div>
        <div>
            @can('update', $advert)
                <form action="{{ route('adverts.destroy', [$advert->city->slug, $advert->slug]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <a href="{{ route('adverts.edit', [$advert->city->slug, $advert->slug]) }}" class="btn inline-block">Edytuj</a>
                    <button class="btn inline-block">Usuń</button>
                </form>
            @endcan
        </div>
    </header>
    <main class="lg:flex -mx-3 mt-6">
        <div class="w-2/5 px-3">
            <img src="{{ $advert->featured_photo_path }}" class="shadow">      
                <div class="card">
                    <div class="card-body text-center">
                        <div><img src="{{ $advert->user->avatar_path }}" alt="" class="rounded-full" heiight="30" width="30"></div>
                        <p class="mt-4"><a href="{{ route('profiles.show', $advert->user->name) }}">{{ $advert->user->name }}</a></p>
                    </div>
                </div>
                <div class="card mt-4">
                    <div class="card-body">
                        <p class="mb-2">Czynsz</p>
                        <p>{{ $advert->rent }}<span class="ml-1 text-xs text-grey-darker">zł miesięcznie</span></p>
                        <p class="my-2">Media</p>
                        <p>{{ $advert->bills }}<span class="ml-1 text-xs text-grey-darker">zł miesięcznie</span></p>
                        <p class="my-2">Kaucja</p>
                        <p>{{ $advert->deposit }}<span class="ml-1 text-xs text-grey-darker">zł</span></p>
                    </div>
                </div>
        </div>
        <div class="w-3/5 px-3">
            <div class="card">
                <div class="card-body">
                    <p class="mb-4">Opis</p>
                    <p class="text-grey-darker">{{ $advert->description }}</p>
                </div>
            </div>
            <div class="card mt-4">
                <div class="card-body">
                    <div class="mb-4">
                        <p class="mb-4">Lokalizacja</p>
                        <p class="text-grey-darker">
                            <a href="{{ route('cities.show', $advert->city->slug) }}">{{ $advert->city->name }}</a>
                            @isset($advert->street) ,&nbsp;{{ $advert->street->name }} @endisset
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <div class="card mt-6">
        <header>
            <h3>Napisz wiadomosc</h3>
        </header>
        <div class="card-body">
            <form action="{{ route('conversations.store', [$advert->city->slug, $advert->slug]) }}" method="POST" class="form">
                @csrf
                @guest
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="text" name="email" id="email">
                    </div>
                    <div class="form-group">
                        <label for="phone">Telefon</label>
                        <input type="text" name="phone" id="phone">
                    </div>
                @endguest
                <div class="form-group">
                    <label for="body">Wiadomosc</label>
                    <textarea name="body" id="body"></textarea>
                </div>
                <button type="submit" class="btn">Wyslij</button>
            </form>
        </div>
    </div>
@endsection