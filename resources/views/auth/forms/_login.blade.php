<form method="POST" action="{{ route('login') }}" class="form">
    @csrf
    <div class="form-group">
        <input id="email" type="email" placeholder="Email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
        @if ($errors->has('email'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-group">
        <input id="password" type="password" placeholder="Hasło" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
        @if ($errors->has('password'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
    </div>
    <div class="custom-control custom-checkbox mb-4">
        <input type="checkbox" name="remember" id="remember" value="1" class="custom-control-input" checked {{ old('remember') ? 'checked' : '' }}>
        <label for="remember" class="custom-control-label">Zapamiętaj mnie</label>
    </div>
    <div class="d-flex justify-content-between form-group mb-0">
        <button type="submit" class="btn btn-primary">Zaloguj</button>
        @if (Route::has('password.request'))
            <a class="btn btn-link" href="{{ route('password.request') }}">Nie pamiętasz hasła?</a>
        @endif
    </div>
</form>
<div class="small mt-4">
    <p class="card-text">Logując się ackeptuję <a href="{{ route('termsAndConditions') }}" target="_blank" rel="noopener noreferrer">Regulamin serwisu alez.pl.</a></p>
    <p class="card-text text-justify">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsam ea possimus est delectus exercitationem? Error ducimus animi culpa impedit quisquam voluptatum saepe repellendus, nihil nobis, illo, ipsum ab. Laudantium, doloremque?</p>
</div>