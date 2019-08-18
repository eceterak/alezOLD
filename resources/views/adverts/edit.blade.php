@extends('layouts.master')

@section('content')
    @if(!$advert->verified)
        <div class="alert alert-warning shadow-sm">
            <p class="mb-2 font-weight-bold">Ogłoszenie oczekuje na weryfikację</p>
            <p class="mb-0">Do czasu weryfikacji ogłoszenia przez Administratora nie będzie ono widoczne dla użytkowników. Prosimy o cierpliwość.</p>
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            <div class="card-title">
                <h3>Edytuj ogłoszenie</h3>
                @if($advert->verified)
                    <small>Jeśli dokonasz zmian w ogłoszeniu, nie będą one widoczne aż do momentu zaakceptowania ich przez Administratora.</small>                
                @endif
            </div>
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