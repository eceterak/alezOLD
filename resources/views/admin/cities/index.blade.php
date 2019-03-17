@extends('admin.layouts.master')

@section('content')
    <p class="text-sm mb-4">Home / Miasta</p>
    <div class="card">
        <header>
            <h3>
                Miasta
                <small class="text-grey-darker">[{{ $cities->count() }}]</small>
            </h3>
            <a href="/admin/miasta/dodaj" class="btn">Dodaj</a>
        </header>
        <div class="card-content">
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-left">Nazwa</th>
                        <th class="text-left">Ogłoszenia</th>
                        <th class="text-left">Promowane</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cities as $city)
                        <tr>
                            <td>{{ $city->name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection