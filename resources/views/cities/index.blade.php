@extends('layouts.master')
@section('content')
    <header class="flex mb-4 justify-between items-center">
        <h3 class="text-grey-darker">Miasta</h3>
    </header>
    <main class="card">
        <div class="card-body">
            @forelse($stateCities as $state => $cities)
                <p>{{ $state }}</p>
                <div class="row">
                    @foreach($cities as $city)
                        <div class="col-2">
                            <a href="{{ route('cities.show', $city->slug) }}">{{ $city->name }} <small>[{{ $city->adverts_count }}]</small></a>
                        </div>
                    @endforeach
                </div>
            @empty
                <div>Brak ogloszen</div>
            @endforelse
        </div>

    </main>
@endsection