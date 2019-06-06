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
    <script>    
        window.App = {!! json_encode([
            'signedIn' =>  Auth::check(),
            'user' => Auth::user()
        ]) !!};
    </script>
</head>
<body>
    <div id="app">
        <div class="bg-white">
            <nav class="container d-flex justify-content-between py-2">
                <a class="navbar-brand" href="/">Alez.pl</a>                
                <div id="navbarSupportedContent">
                    @guest
                        <a class="btn btn-secondary mr-2" href="{{ route('login') }}">Zaloguj</a>
                    @endguest
                    @auth
                        {{-- <user-notifications></user-notifications> --}}
                        <div class="dropdown d-inline-block mx-2">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                {{ auth()->user()->name }}
                                @if($notifications = auth()->user()->notifications_count)
                                    <span class="badge badge-light mx-1">{{ $notifications }}</span>
                                @endif
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="{{ route('home') }}">Moje ogłoszenia</a>
                                <a class="dropdown-item" href="{{ route('conversations.inbox') }}">
                                    Wiadomości 
                                    @if($unreadMessages = auth()->user()->hasUnreadNotificationsOfType('YouHaveANewMessage')) 
                                        <span class="badge badge-danger ml-2">{{ $unreadMessages }}</span>
                                    @endif
                                </a>
                                <a class="dropdown-item" href="{{ route('subscriptions') }}">
                                    Obserwowane
                                    @if($unreadAdverts = auth()->user()->hasUnreadNotificationsOfType('AdvertWasAdded')) 
                                        <span class="badge badge-danger ml-2">{{ $unreadAdverts }}</span>
                                    @endif
                                </a>
                                <a class="dropdown-item" href="{{ route('favourites') }}">Ulubione</a>
                                <a class="dropdown-item" href="{{ route('settings') }}">Ustawienia</a>
                                <form action="{{ route('logout') }}" method="POST" class="dropdown-item">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-secondary">Wyloguj</button>
                                </form>
                            </div>
                        </div>
                    @endauth
                    <a href="{{ route('adverts.create') }}" class="btn btn-primary">Dodaj ogłoszenie</a>
                </div>
            </nav>
            <div class="bg-light">
                <div class="container py-4">
                    @yield('lead')
                </div>
            </div>
            <div class="container py-4">
                @yield('content')
                    <footer>
                        <div class="row">

                            <div class="col-3">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item border-0 p-0">Alez.pl</li>
                                    <li class="list-group-item border-0 p-0"><a href="{{ route('aboutUs') }}">O nas</a></li>
                                    <li class="list-group-item border-0 p-0"><a href="{{ route('privacyPolicy') }}">Polityka prywatności</a></li>
                                    <li class="list-group-item border-0 p-0"><a href="{{ route('termsAndConditions') }}">Regulamin serwisu</a></li>
                                </ul>
                            </div>
                            <div class="col-3">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item border-0 p-0">Mapa strony</li>
                                    <li class="list-group-item border-0 p-0"><a href="{{ route('cities') }}">Miasta</a></li>
                                    <li class="list-group-item border-0 p-0"><a href="{{ route('home') }}">Twoje konto</a></li>
                                    <li class="list-group-item border-0 p-0"><a href="{{ route('adverts.create') }}">Dodaj ogłoszenie</a></li>
                                </ul>
                            </div>
                            <div class="col-3">
                                <p class="mb-0">Kontakt</p>
                                <p>Możesz skontaktować się z nami od poniedziałku do piątku w godzinach od 9:00 do 17:00</p>
                            </div>
                            <div class="col-3">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item border-0 p-0"><a href="#"><i class="fas fa-phone mr-2 fa-xs"></i>+48 777 888 999</a></li>
                                    <li class="list-group-item border-0 p-0"><a href="#"><i class="fas fa-envelope mr-2 fa-xs"></i>help@alez.pl</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between text-left small pt-2">
                            <p class="mb-0">Copyright &copy; {{ \Carbon\Carbon::now()->year }} alez.pl</p>
                            <p class="mb-0">Korzystanie z serwisu oznacza akceptację <a href="{{ route('termsAndConditions') }}">regulaminu</a></p>
                        </div>
                    </footer>
                </div>
            <flash-message message="{{ session('flash') }}"></flash-message>
            @if(!auth()->user())
                <div class="modal fade" id="accountWarningnModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Zaloguj się aby kontynuować</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <nav class="nav nav-tabs mb-0" role="tablist">
                                    <a class="nav-link active" data-toggle="tab" href="#login">Zaloguj się</a>
                                    <a class="nav-link" data-toggle="tab" href="#register">Zarejestruj się</a>
                                </nav>
                                <div class="tab-content py-4">
                                    <div class="tab-pane fade show active" id="login" role="tabpanel">
                                        @include('auth.forms._login')
                                    </div>
                                    <div class="tab-pane fade" id="register" role="tabpanel">
                                        @include('auth.forms._register')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif(auth()->user() && !auth()->user()->hasVerifiedEmail())
                <div class="modal fade" id="accountWarningnModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Ta akcja wymaga potwierdzenia adresu email.</p>
                                <p>Kliknij <a href="{{ route('verification.resend') }}">tutaj</a> jeżeli nie otrzymałeś/aś wiadomości weryfikacyjnej.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/poppa.js') }}"></script>
    <script src="{{ asset('js/master.js') }}"></script>
</body>
</html>