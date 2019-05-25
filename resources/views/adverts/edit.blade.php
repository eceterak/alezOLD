@extends('layouts.master')

@section('lead')
    @if(!$advert->validated)
        <div class="card flex justify-between mb-5 py-2 px-4 text-white bg-orange">
            <p class="font-bold mb-2">Ogłoszenie oczekuje na weryfikację</p>
            <p>Do czasu weryfikacji ogłoszenia przez Administratora nie będzie ono widoczne dla użytkowników. Prosimy o cierpliwość.</p>
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            <h3 class="mb-5">Edytuj ogłoszenie</h3>
            @if($advert->validated)
                <small>Jeśli dokonasz zmian w ogłoszeniu, nie będzie ono widoczne na liście aż do momentu zaakceptowania zmian przez Administratora.</small>                
            @endif
            @include('adverts._form', [
                'route' => ['adverts.edit', [$advert->city->slug, $advert->slug]],
                'name' => 'create_new_advert',
                'header' => 'Edytuj ogłoszenie',
                'method' => 'PATCH',
                'button' => 'Zapisz'
            ])
        </div>
    </div>
@endsection