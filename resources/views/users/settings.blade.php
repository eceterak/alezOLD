@extends('layouts.master')

@section('breadcrumbs')
    @include('users._menu')
@endsection

@section('content')
    <div class="row">
        <div class="col-3">
            <avatar-form :user="{{ $profile }}"></avatar-form>
        </div>
        <div class="col-9">
            <form action="{{ route('settings.update') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="phone">Numer telefonu</label>
                    <input type="number" name="phone" id="phone" placeholder="Numer telefonu" class="form-control" value="{{ $profile->phone }}">
                </div>
                <div class="form-group">
                        <label for="bio">Kilka słów o Tobie</label>
                    <textarea name="bio" id="bio" rows="5" class="form-control">{{ $profile->bio }}</textarea>
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
                <ul class="list-group list-group-horizontal list-group-btn list-group-flush mt-4">
                    <li class="list-group-item border-0">
                        <button class="btn btn-primary" type="submit">Zapisz</button>
                    </li>
                    <li class="list-group-item border-0">
                        <a href="{{ route('password.change') }}" class="btn btn-secondary">Zmień hasło</a>
                    </li>
                    <li class="list-group-item border-0">
                        <button class="btn btn-danger" data-toggle="modal" data-target="#accountDeleteConfirmation" data-endpoint="{{ route('account.delete') }}" type="button">Usuń konto</button>
                    </li>
                </ul>
            </form>
            @include('components._errors')
        </div>
    </div>
    <div class="modal fade" id="accountDeleteConfirmation" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content align-items-center">
                <div class="modal-header border-0 pb-0">
                    <h5 class="mb-0">Czy na pewno chcesz usunąć swoje konto?</h5>
                </div>
                <div class="modal-body">
                    <form action="{{ route('account.delete') }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Usuń konto</button>
                        <button type="button" class="btn btn-secondary ml-2 btn-sm" data-dismiss="modal">Anuluj</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection