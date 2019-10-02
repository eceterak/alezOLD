<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Alez.pl - pokoje na wynajem') }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/_master.css') }}">
    <script>    
        window.App = {!! json_encode([
            'signedIn' =>  Auth::check(),
            'user' => Auth::user()
        ]) !!};
    </script>
</head>
<body>
    <div id="app">
        <header>
            @include('layouts.components._header', ['class' => 'navbar-light'])
            <div id="breadcrumbs">
                <section class="container">
                    @yield('breadcrumbs')
                </section>
            </div>
        </header>
        <main class="container py-4">
            @yield('content')
        </main>
        <footer id="footer" class="border-top">
            @include('layouts.components._footer')
        </footer>
        <flash-message message="{{ session('flash') }}"></flash-message>
        @if(!Request::is('login'))
            @if(!auth()->user())
                @include('layouts.components._modal-login')
            @elseif(auth()->user() && !auth()->user()->hasVerifiedEmail())
                @include('layouts.components._modal-account-unverified')
            @endif
        @endif
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>