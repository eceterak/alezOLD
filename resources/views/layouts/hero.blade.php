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
        <div class="hero" style="background-image: url({{ asset('images/hero.jpg') }});">
            <header>
                @include('layouts.components._header', ['class' => 'navbar-dark'])
            </header>
            <section class="container">
                <header class="text-center text-white">
                    <h1 class="hero-header">Twoj kawałek podłogi</h1>
                    <p class="hero-sub">Pokoje na wynajem w największych miastach Polski</p>
                </header>
            </section>
            <section class="container pt-3 pb-5">
                <search-bar endpoint="{{ route('search.index') }}"></search-bar>
            </section>
            @if(isset($suggestedCities) && $suggestedCities->count())
                <section class="container pb-7">
                    <div class="text-center text-white" id="popular-cities">
                        <h5 class="mb-3">Popularne miasta</h5>
                        <div class="d-flex justify-content-center ">
                            @foreach($suggestedCities as $city)
                                <a href="{{ route('cities.show', $city->slug) }}" class="btn btn-primary mx-1">{{ $city->name }}</a>
                            @endforeach
                        </div>
                    </div>
                </section>
            @endif
        </div>
        <main>
            @yield('content')
        </main>
        <footer id="footer">
            @include('layouts.components._footer')
        </footer>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>