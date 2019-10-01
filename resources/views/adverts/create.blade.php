@extends('layouts.master')

@section('breadcrumbs')
    <h3 class="mb-0">Dodaj ogłoszenie</h3>
@endsection

@section('content')
    @include('adverts._form', [
        'route' => ['adverts.store', session('create_advert_token')],
        'name' => 'create_new_advert',
        'method' => 'POST',
        'button' => 'Dodaj ogłoszenie'
    ])
@endsection