@extends('admin.layouts.master')

@section('content')
    @component('admin.cities._card', ['city' => $city])
        <header>
            <h3>Ulice w {{ $city->name }}<small class="text-grey-darker">&nbsp;[{{ $city->streets->count() }}]</small></h3>
            <a href="{{ route('admin.streets.create', $city->slug) }}" class="btn">Dodaj</a>
        </header>
        @if($city->streets->count())
            <table class="table">
                <thead>
                    <tr>
                        <th>Nazwa</th>
                        <th>Longitude</th>
                        <th>Latitude</th>
                        <th class="fit">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($city->streets as $street)
                        <tr>
                            <td><a href="{{ route('admin.streets.edit', [$street->city->slug, $street->id]) }}">{{ $street->name }}</a></td>
                            <td>{{ $street->lat }}</td>
                            <td>{{ $street->lon }}</td>
                            <td>
                                <form action="{{ route('admin.streets.destroy', [$street->city->slug, $street->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn">Usuń</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
        <div class="card-content">
            <p>Brak ulic w tym mieście</p>
        </div>
        @endif
    @endcomponent
@endsection