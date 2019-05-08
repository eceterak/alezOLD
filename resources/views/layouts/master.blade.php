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
    <link rel="stylesheet" href="{{ asset('css/master.css') }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
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
                <a href="{{ route('adverts.create') }}" class="btn btn-reverse">Dodaj ogłoszenie</a>
            </div>
        </nav>
    </div>
    <div class="bg-grey-lighter border-t border-b border-grey-light">
        <div class="container pt-6 pb-8" id="app">
            @yield('lead')
        </div>
    </div>
    <div class="container pt-4 pb-8">
        @yield('content')
{{--         <footer class="border-t border-grey mt-20 pt-4">
            <div class="flex -mx-4">
                <div class="w-1/3 px-4 text-xs">Lorem ipsum dolor sit amet consectetur adipisicing elit. Illo modi rem, eveniet ipsum expedita incidunt necessitatibus at explicabo nam dolorem dolores quaerat et perspiciatis, non officiis cumque maxime corporis eius.</div>
                <div class="w-1/3 px-4 text-xs">Lorem ipsum dolor sit amet consectetur adipisicing elit. Illo modi rem, eveniet ipsum expedita incidunt necessitatibus at explicabo nam dolorem dolores quaerat et perspiciatis, non officiis cumque maxime corporis eius.</div>
                <div class="w-1/3 px-4 text-xs">
                    <ul class="list-reset">
                        <li>Home</li>
                        <li>Pokoje</li>
                        <li>Miasta</li>
                        <li>Twoje konto</li>
                    </ul>
                </div>
            </div>
        </footer> --}}
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/poppa.js') }}"></script>
    <script src="{{ asset('js/master.js') }}"></script>
</body>
</html>