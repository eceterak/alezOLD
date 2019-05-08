@extends('layouts.master')

@section('lead')
    <div class="card">
        <header>
            <h3>Dodaj ogłoszenie</h3>
        </header>
        <div class="card-content"> 
            @include('adverts._form', [
                'route' => ['adverts.store'],
                'name' => 'create_new_advert',
                'method' => 'POST',
                'button' => 'Dodaj'
            ])
        </div>
    </div>
@endsection