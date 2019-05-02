@extends('layouts.master')

@section('lead')
    @if(!$room->validated)
    <div class="card flex justify-between items-center mb-5 py-2 px-4 text-white font-bold bg-red">
        <p>Ogłoszenie nie zweryfikowane</p>
        <input type="checkbox" name="validated" id="validated">
    </div>
    @endif
    @include('rooms._form', [
        'route' => ['rooms.edit', $room->slug],
        'header' => 'Edytuj ogłoszenie',
        'method' => 'PATCH',
        'button' => 'Zapisz'
    ])
@endsection