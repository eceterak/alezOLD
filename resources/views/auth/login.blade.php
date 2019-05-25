@extends('layouts.master')

@section('lead')
<div class="card w-2/3 mx-auto">
    <div class="card-body">
        <h3 class="mb-6 font-normal">Zaloguj się</h3>
        <form method="POST" action="{{ route('login') }}" class="form">
            @csrf
            <div class="form-group">
                {{-- <label for="email">{{ __('E-Mail Address') }}</label> --}}
                <input id="email" type="email" placeholder="Email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
                @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group row">
                <div class="col-md-6">
                    <input id="password" type="password" placeholder="Hasło" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                    @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-6 offset-md-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" checked {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label" for="remember">Zapamiętaj mnie</label>
                    </div>
                </div>
            </div>

            <div class="flex justify-between form-group row mb-0">
                <button type="submit" class="btn btn-primary">Zaloguj</button>
                @if (Route::has('password.request'))
                    <a class="btn btn-link" href="{{ route('password.request') }}">Nie pamiętasz hasła?</a>
                @endif
            </div>
        </form>
    </div>
</div>
@endsection
