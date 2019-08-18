@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-body"> 
            <h3 class="card-title mb-4">Dodaj ogłoszenie</h3>
            @include('adverts._form', [
                'route' => ['adverts.store', session('create_advert_token')],
                'name' => 'create_new_advert',
                'method' => 'POST',
                'button' => 'Dodaj ogłoszenie'
            ])
        </div>
    </div>

    {{-- <div class="mx-auto col-11">
        <h4 class="mb-4">Wybierz swój formularz</h4>
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Prosty formularz</h5>
                        <p class="card-text">Masz wolny pokój na wynajem i niewiele wolnego czasu? Skorzystaj z prostego formularza i dodaj ogłoszenie w kilka minut!</p>
                        <div class="text-center">
                            <button class="btn btn-primary">Dodaj ogłoszenie</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Formularz szczegółowy</h5>
                        <p class="card-text">Dla wymagających użytkowników chcących dokładnie określić na jakich warunkach pokój będzie wynajmowany.</p>
                        <div class="text-center">
                            <button class="btn btn-secondary">Dodaj ogłoszenie</button>
                        </div>
                    </div>        
                </div>        
            </div>
        </div>
    </div> --}}
@endsection