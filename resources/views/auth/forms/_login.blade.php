<h5 class="mb-4">Logowanie</h5>  
<form method="POST" action="{{ route('login') }}" class="form">
    @csrf
    <div class="form-group">
        <label for="login_email">Email</label>
        <input id="login_email" type="email" placeholder="Email" class="form-control {{ $errors->login->has('email') ? ' is-invalid' : '' }}" name="login_email" value="{{ old('login_email') }}" required autofocus>
        <small>test123@gg.com</small>
        @if($errors->login->has('email'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->login->first('email') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-group">
        <label for="login_password">Hasło</label>
        <input id="login_password" type="password" placeholder="Hasło" class="form-control{{ $errors->has('login_password') ? ' is-invalid' : '' }}" name="login_password" required>
        <small>asd1234</small>
        @if ($errors->has('login_password'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('login_password') }}</strong>
            </span>
        @endif
    </div>
    <div class="d-flex justify-content-between form-group mb-0 my-4">
        <button type="submit" class="btn btn-primary">Zaloguj</button>
        @if (Route::has('password.request'))
            <a class="btn btn-link" href="{{ route('password.request') }}">Nie pamiętasz hasła?</a>
        @endif
    </div>
</form>
<div class="small">
    <p class="card-text">Logując się ackeptuję <a href="{{ route('termsAndConditions') }}" target="_blank" rel="noopener noreferrer">Regulamin serwisu alez.pl.</a></p>
    <p class="card-text text-justify">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsam ea possimus est delectus exercitationem? Error ducimus animi culpa impedit quisquam voluptatum saepe repellendus, nihil nobis, illo, ipsum ab. Laudantium, doloremque?</p>
</div>     