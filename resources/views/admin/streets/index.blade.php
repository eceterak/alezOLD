@extends('admin.layouts.master')

@section('content')
    <ul class="list-reset flex">
        <li class="card-tab"><a href="{{ route('admin.cities.edit', $city->slug) }}">Miasto</a></li>
        <li class="card-tab"><a href="{{ route('admin.cities.streets', $city->slug) }}">Ulice</a></li>
        <li class="card-tab"><a href="{{ route('admin.cities.adverts', $city->slug) }}">Ogłoszenia</a></li>
    </ul>
    <div class="card mt-5">
        <header>
            <h3>Ulice w {{ $city->name }}<small class="text-grey-darker">&nbsp;[{{ $city->streets->count() }}]</small></h3>
            <a href="/admin/pokoje/dodaj" class="btn">Dodaj</a>
        </header>
        <div>
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
                            <td>delete</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection