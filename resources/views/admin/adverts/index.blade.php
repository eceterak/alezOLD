@extends('admin.layouts.master')

@section('content')
    <div class="card">
        <header>
            <h3>
                Pokoje
                <small class="text-grey-darker">[{{ $adverts->count() }}]</small>
            </h3>
            <a href="/admin/pokoje/dodaj" class="btn">Dodaj</a>
        </header>
        <div>
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-left">Tytuł</th>
                        <th class="text-left">Miasto</th>
                        <th class="text-left">Data dodania</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($adverts as $advert)
                        <tr>
                            <td><a href="{{ route('admin.adverts.edit', $advert->slug) }}">{{ $advert->title }}</a></td>
                            <td class="fit"><a href="{{ route('admin.cities.edit', $advert->city->slug) }}">{{ $advert->city->name }}</a></td>
                            <td>{{ $advert->created_at->day.'/'.$advert->created_at->month.'/'.$advert->created_at->year }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection