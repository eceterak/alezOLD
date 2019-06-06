@extends('layouts.master')

@section('lead')

    @include('users._menu', [
        'title' => 'Ustawienia',
        'subtitle' => 'Tutaj zmienisz swoje ustawienia'
    ])

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-9">
                    <form action="{{ route('settings.update') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <textarea name="bio" id="bio" rows="5" class="form-control" placeholder="Kilka słów o Tobie...">{{ $profile->bio }}</textarea>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="email_notifications" id="email_notifications" value="1" class="custom-control-input" {{ ($profile->email_notifications) ? 'checked' : '' }} value="1">
                            <label for="email_notifications" class="custom-control-label">Powiadomienia mailowe</label>
                            <p class="small">Odznacz to pole jeżeli nie chcesz otrzymywać powiadomień mailowych.</p>
                        </div>
                        <button class="btn btn-primary">Zapisz</button>
                    </form>
                    <div class="mt-4">
                        <a href="{{ route('password.change') }}" class="btn btn-secondary btn-sm">Zmień hasło</a>
                        <form action="{{ route('account.delete') }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-danger btn-sm">Usuń konto</button>
                        </form>
                    </div>
                </div>
                <div class="col-3">
                    <avatar-form :user="{{ $profile }}"></avatar-form>
                </div>
            </div>
        </div>
    </div>
@endsection