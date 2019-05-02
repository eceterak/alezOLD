@extends('layouts.master')
@section('content')
    <h3 class="font-normal text-lg mb-4">{{ $room->title }}</h3>
    <main class="lg:flex -mx-3">
        <div class="w-3/5 px-3">
            <img src="/storage/room.jpg" class="shadow">
        </div>
        <div class="lg:w-2/5 px-3">
            <div class="card">
                <section>
                    <p class="text-grey-darker">
                        {{ $room->description }}
                    </p>
                </section>
            </div>
        </div>
    </main>
    <div class="card mt-4">
        <section>
            <p class="text-grey-darker">
                {{ $room->description }}
            </p>
        </section>
    </div>
    @auth
        @if($room->user->id == auth()->user()->id)
            <a href="{{ route('rooms.edit', $room->slug) }}" class="btn">Edytuj</a>
        @endif
    @endauth
    <div class="card card-content mt-6">
        <header>
            <h3>Napisz wiadomosc</h3>
        </header>
        <div class="card-content">
            <form action="{{ route('conversations.store', [$room->city->slug, $room->slug]) }}" method="POST" class="form">
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