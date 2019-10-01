@extends('layouts.master')

@section('breadcrumbs')
    <h3>Potrzebujesz pomocy?</h3>
    <p class="mb-0">Skorzystaj z formularza bądź zadzwoń</p>
@endsection

@section('content')
    <div class="row">
        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    <h5>Zadzwoń do nas...</h5>
                    <p>...jesteśmy dostępni od poniedziałku do piątku od 9:00 do 17:00</p>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item border-0 p-0"><a href="#"><i class="fas fa-phone mr-2 fa-xs"></i>+48 777 888 999</a></li>
                        <li class="list-group-item border-0 p-0"><a href="#"><i class="fas fa-envelope mr-2 fa-xs"></i>help@alez.pl</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-8">
            <h5>Formularz kontaktowy</h5>
            <form action="">
                <div class="form-group">
                    <label for="message">Napisz wiadomość</label>
                    <textarea name="message" id="message" rows="10" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="topic">Czego dotyczy Twoja wiadomość</label>
                    <select name="topic" id="topic" class="form-control">
                        <option value="advert">Problem na stronie</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Wyślij</button>
            </form>
        </div>
    </div>
@endsection