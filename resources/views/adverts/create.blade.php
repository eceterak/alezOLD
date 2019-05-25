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

    {{-- <div class="mx-auto w-7/8">
        <h3 class="mb-6">Wybierz swój formularz</h3>
        <div class="flex -mx-6">
            <div class="w-1/2 px-5">
                <div class="card">
                    <div class="card-body">
                        <h3>Prosty formularz</h3>
                        <p class="my-4 leading-loose">Masz pokój na wynajem i niewiele wolnego czasu? Skorzystaj z prostego formularza i dodaj ogłoszenie w kilka minut!</p>
                        <div class="text-center">
                            <button class="btn btn-primary">Dodaj ogłoszenie</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-1/2 px-6">
                <div class="card">
                    <div class="card-body">
                        <h3>Formularz szczegółowy</h3>
                        <p class="my-4 leading-loose">Dla wymagających użytkowników chcących dokładnie określić na jakich warunkach pokój będzie wynajmowany.</p>
                        <div class="text-center">
                            <button class="btn btn-reverse">Dodaj ogłoszenie</button>
                        </div>
                    </div>        
                </div>        
            </div>
        </div>
    </div> --}}
@endsection