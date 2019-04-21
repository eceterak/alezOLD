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
                <h2><a href="/" class="text-teal text-3xl font-normal tracking-wide no-underline">{{ env('APP_SHORT', 'Alez.pl') }}</a></h2>
            </div>
            <div>
                @guest
                    <a class="btn mr-2" href="{{ route('login') }}">{{ __('Login') }}</a>
                @endguest
                @auth
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="btn mr-2">{{ __('Logout') }}</button>
                    </form>
                @endauth
                <a href="{{ route('rooms.create') }}" class="btn btn-reverse">Dodaj ogłoszenie</a>
            </div>
        </nav>
    </div>
    <div class="bg-grey-lighter">
        <div class="container py-8">
            @yield('lead')
        </div>
    </div>
    <div class="container py-8">
        @yield('content')
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/master.js') }}"></script>
</body>
</html>