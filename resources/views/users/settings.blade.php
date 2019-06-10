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
                            <input type="number" name="phone" id="phone" placeholder="Numer telefonu" class="form-control" value="{{ $profile->phone }}">
                        </div>
                        <div class="form-group">
                            <textarea name="bio" id="bio" rows="5" class="form-control" placeholder="Kilka słów o Tobie...">{{ $profile->bio }}</textarea>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="email_notifications" id="email_notifications" value="1" class="custom-control-input" {{ ($profile->email_notifications) ? 'checked' : '' }} value="1">
                            <label for="email_notifications" class="custom-control-label">Powiadomienia mailowe</label>
                            <button type="button" class="btn btn-link btn-sm p-0 text-primary" data-toggle="tooltip" data-placement="right" title="Odznacz to pole jeżeli nie chcesz otrzymywać powiadomień mailowych.">
                                    <i class="fas fa-question-circle"></i>
                            </button>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="hide_phone" id="hide_phone" value="1" class="custom-control-input" {{ ($profile->hide_phone) ? 'checked' : '' }} value="1">
                            <label for="hide_phone" class="custom-control-label">Ukryj numer telefonu</label>
                            <button type="button" class="btn btn-link btn-sm p-0 text-primary" data-toggle="tooltip" data-placement="right" title="Zaznacz to pole jeżeli nie chcesz wyświetlać numeru telefonu w Twoich ogłoszeniach.">
                                    <i class="fas fa-question-circle"></i>
                            </button>
                        </div>
                        <button class="btn btn-primary mt-4">Zapisz</button>
                    </form>
                    @include('components._errors')
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