@extends('admin.layouts.master')

@section('content')
    @component('admin.cities._card', ['city' => $city])
        <header>
            <h3>
                Pokoje w {{ $city->name }}
                <small class="text-grey-darker">[{{ $city->adverts->count() }}]</small>
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
                    @foreach($city->adverts as $advert)
                        <tr>
                            <td><a href="{{ route('admin.adverts.edit', $advert->slug) }}">{{ $advert->title }}</a></td>
                            <td><a href="{{ route('admin.cities.edit', $advert->city->slug) }}">{{ $advert->city->name }}</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endcomponent
@endsection