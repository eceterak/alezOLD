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
            <a href="{{ route('rooms.edit', $room->path()) }}" class="btn">Edytuj</a>
        @endif
    @endauth
@endsection