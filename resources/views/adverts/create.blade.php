@extends('layouts.master')

@section('lead')

    <div class="card">
        <div class="card-body"> 
            <h3 class="mb-5">Dodaj ogłoszenie</h3>
            @include('adverts._form', [
                'route' => ['adverts.store', session('create_advert_token')],
                'name' => 'create_new_advert',
                'method' => 'POST',
                'button' => 'Dodaj ogłoszenie'
            ])
        </div>
    </div>
@endsection