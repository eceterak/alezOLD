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
    <div class="container mx-auto">
        <nav class="flex justify-between items-center py-3 border-b border-grey">
            <div>
                <h1><a href="/" class="text-teal font-normal tracking-wide no-underline">{{ config('app.short', 'Alez.pl') }}</a></h1>
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
            </div>
        </nav>
        <nav class="flex">
            <ul class="flex list-reset">
                <li>Miasta</li>
                <li>Ogłoszenia</li>
                <li>Użytkownicy</li>
            </ul>
        </nav>
        <div class="card py-5">
            @yield('content')
        </div>
    </div>
</body>
</html>