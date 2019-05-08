<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Alez.pl - pokoje na wynajem') }}</title>
    <link rel="stylesheet" href="{{ mix('admin/css/app.css') }}">
</head>
<body class="bg-grey-lighter">
    <div class="flex h-screen">
        <div class="lg:w-1/6 lg:block md:hidden bg-brown-darkest text-white px-5">
            <div class="border-b border-grey py-6">ALEZ.pl</div>
            <nav class="navigator">
                <ul>
                    <li><a href="{{ route('admin') }}">Home</a></li>
                    <li><a href="{{ route('admin.cities') }}">Miasta</a></li>
                    <li><a href="{{ route('admin.adverts') }}">Pokoje</a></li>
                    <li><a href="{{ route('admin.adverts') }}">Użytkownicy</a></li>
                </ul>
            </nav>
        </div>
        <div class="lg:w-5/6 sm:w-full bg-creamy">
            <div class="border-b border-grey p-6">
                <div id="breadcrumbs">
                    <ul class="flex list-reset">
                        <li><a href="{{ route('admin') }}">Home</a></li>
                        @if(count(Request::segments())) 
                            @for($i = 1; $i < count(Request::segments()); $i++)
                                <li>&nbsp;/&nbsp;{{ ucfirst(Request::segments()[$i]) }}</li>
                            @endfor
                        @endif
                    </ul>
                </div>
            </div>
            <div class="p-6">
                @yield('content')
            </div>
        </div>
    </div>
    <script src="{{ mix('admin/js/app.js') }}"></script>
</body>
</html>