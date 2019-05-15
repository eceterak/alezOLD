@extends('layouts.master')

@section('lead')
    @if(!$advert->validated)
    <div class="card flex justify-between items-center mb-5 py-2 px-4 text-white font-bold bg-red">
        <p>Ogłoszenie nie zweryfikowane</p>
        <input type="checkbox" name="validated" id="validated">
    </div>
    @endif
    @include('adverts._form', [
        'route' => ['adverts.edit', [$advert->city->slug, $advert->slug]],
        'name' => 'create_new_advert',
        'header' => 'Edytuj ogłoszenie',
        'method' => 'PATCH',
        'button' => 'Zapisz'
    ])
@endsection