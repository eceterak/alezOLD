@extends('admin.layouts.master')

@section('content')
    @component('admin.cities._card', ['city' => $street->city])
        <header>
            <h3>Edytuj ulicę w {{ $street->city->name }}</h3>
        </header>
        <div class="card-content">
            @include('admin.streets._form', [
                'street' => $street,
                'route' => ['admin.streets.update', [$street->city->slug, $street->id]],
                'method' => 'PATCH',
                'button' => 'Zapisz'
            ])
            <form action="{{ route('admin.streets.destroy', [$street->city->slug, $street->id]) }}" method="POST" class="mt-5">
                @csrf
                @method('DELETE')
                <button class="btn">Usuń</button>
            </form>
        </div>
    @endcomponent
@endsection