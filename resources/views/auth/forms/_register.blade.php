<h5 class="mb-4">Rejestracja nowego konta</h5>
<form method="POST" action="{{ route('register') }}">
    @csrf
    <div class="form-group">
        <label for="name">Imię</label>
        <input id="name" type="text" class="form-control{{ $errors->register->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
        @if ($errors->register->has('name'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->register->first('name') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-group">
        <label for="name">Email</label>
        <input id="email" type="email" class="form-control{{ $errors->register->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
        @if ($errors->register->has('email'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->register->first('email') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-group">
        <label for="name">Hasło</label>
        <input id="password" type="password" class="form-control{{ $errors->register->has('password') ? ' is-invalid' : '' }}"  name="password" required>
        @if ($errors->register->has('password'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->register->first('password') }}</strong>
        </span>
        @endif
    </div>
    <div class="form-group">
        <label for="password-confirm">Powtórz hasło</label>
        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
    </div>
    <div class="form-group my-4">
        <button type="submit" class="btn btn-primary">Zarejestruj się</button>
    </div>
</form>
<div class="small mt-4">
    <p class="card-text">Rejestrując się ackeptuję <a href="{{ route('termsAndConditions') }}" target="_blank" rel="noopener noreferrer">Regulamin serwisu alez.pl.</a></p>
    <p class="card-text text-justify">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsam ea possimus est delectus exercitationem? Error ducimus animi culpa impedit quisquam voluptatum saepe repellendus, nihil nobis, illo, ipsum ab. Laudantium, doloremque?</p>
</div>