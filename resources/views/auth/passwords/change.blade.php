@extends('layouts.master')

@section('breadcrumbs')
    <h3 class="mb-0">Zmień hasło</h3>
@endsection

@section('content')
    <form method="POST" action="{{ route('password.change.store') }}" class="form">
        @csrf
        <div class="form-group row">
            <label for="password" class="col-md-4 col-form-label text-md-right">Nowe hasło</label>
            <div class="col-md-6">
                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group row">
            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Powtórz nowe hasło</label>
            <div class="col-md-6">
                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
            </div>
        </div>
        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">Zmień hasło</button>
            </div>
        </div>
    </form>
@endsection
