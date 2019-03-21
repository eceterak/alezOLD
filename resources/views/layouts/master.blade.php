<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Alez.pl - pokoje na wynajem') }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="bg-white">
        <nav class="container flex justify-between items-center py-3">
            <div>
                <h1><a href="/" class="text-teal font-normal tracking-wide no-underline">{{ env('APP_SHORT', 'Alez.pl') }}</a></h1>
            </div>
            <div>
                @guest
                    <a href="{{ route('login') }}">{{ __('Login') }}</a>
                    <a href="{{ route('register') }}">{{ __('Register') }}</a>
                @endguest
                @auth
                    <span>Hello {{ auth()->user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit">{{ __('Logout') }}</button>
                    </form>
                @endauth
                <button class="btn">Dodaj ogłoszenie</button>
            </div>
        </nav>
    </div>
    <div class="container mx-auto py-5">
        @yield('content')
    </div>
</body>
</html>