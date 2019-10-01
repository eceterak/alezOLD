@extends('layouts.master')

@section('breadcrumbs')
    <h3 class="mb-0">Zweryfikuj adres email</h3>
@endsection

@section('content')
    <div>
        {{ __('Aby kontynuować zweryfikuj swój adres email. W tym celu kliknij na') }}
        {{ __('Jeśli nie otrzymałeś wiadomości weryfikacyjnej') }}, <a href="{{ route('verification.resend') }}">{{ __('kliknij tutaj aby ponowić ... ') }}</a>.
    </div>
@endsection