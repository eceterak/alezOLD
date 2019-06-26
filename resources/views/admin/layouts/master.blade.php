<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Alez.pl - pokoje na wynajem') }}</title>
    <link rel="stylesheet" href="{{ asset('admin/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/dashboard.css') }}">
    <script>    
        window.App = {!! json_encode([
            'signedIn' =>  Auth::check(),
            'user' => Auth::user()
        ]) !!};
    </script>
</head>
<body class="bg-secondary">
    <div class="container" id="app">
        <div class="shadow bg-dashboard">
            <nav class="d-flex justify-content-between navbar bg-primary">
                <a href="{{ route('admin.dashboard') }}" class="text-white navbar-brand">Alez</a>
                <div class="text-white">
                    @if($notifications = auth()->user()->notifications_count)
                        <a href="{{ route('admin.notifications') }}" class="btn btn-sm btn-light text-dark"><i class="fas fa-bell mr-1"></i>{{ $notifications }}</a>
                    @endif
                    <span class="mx-2">{{ auth()->user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline-block">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-light"><i class="fas fa-power-off"></i></button>
                    </form>
                </div>
            </nav>
            @include('admin.layouts._menu')
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">Home</a>
                    </li>
                    @if(count(Request::segments())) 
                        @for($i = 1; $i < count(Request::segments()); $i++)
                            <li class="breadcrumb-item">{{ ucfirst(Request::segments()[$i]) }}</li>
                        @endfor
                    @endif
                </ol>
            </nav>
            <div class="pb-4">
                <div class="container">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    <flash-message message="{{ session('flash') }}"></flash-message>
    <script src="{{ asset('admin/js/app.js') }}"></script>
</body>
</html>