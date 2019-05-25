@extends('layouts.master')

@section('lead')

    @include('users._menu', ['title' => 'Ustawienia'])

    <div class="flex -mx-3">
        <div class="w-2/3 px-3">
            <div class="card">
                <div class="card-body text-center">
                    <avatar-form :user="{{ $profile }}"></avatar-form>
                </div>
            </div>
        </div>
        <div class="w-1/3 px-3">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('password.change') }}">Zmień hasło</a>
                    <a href="{{ route('password.change') }}">Usuń konto</a>
                </div>
            </div>
        </div>
    </div>

@endsection