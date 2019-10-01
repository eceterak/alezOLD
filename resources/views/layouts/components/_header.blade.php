<nav class="navbar {{ isset($class) ? $class : '' }}" id="navbar-top">
    <div class="container">
        <a href="{{ route('index') }}" class="navbar-brand">www.alez.pl</a>
        {{-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu-top">
            <span class="navbar-toggler-icon"></span>
        </button> --}}
        <div id="menu-top">
            {{-- <ul class="navbar-nav nav-pills mr-auto align-items-center">
                <li class="nav-item">
                    <a href="{{ route('index') }}" class="nav-link">Strona główna</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('aboutUs') }}" class="nav-link">O nas</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('contact') }}" class="nav-link">Kontakt</a>
                </li>
            </ul> --}}
            <ul class="nav ml-auto d-none d-lg-flex">
                @guest
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="btn btn-link font-weight-bold d-none d-md-block">Logowanie/rejestracja</a>
                    </li>
                @endguest
                @auth
                    <li class="nav-item dropdown">
                        <div class="dropdown d-lg-inline-block mr-2">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ auth()->user()->name }}
                                @if($notifications = auth()->user()->notifications_count)
                                    <span class="badge badge-light mx-1">{{ $notifications }}</span>
                                @endif
                            </button>
                            <div class="dropdown-menu shadow" aria-labelledby="dropdownMenuButton">
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
                                    <button type="submit" class="btn btn-sm btn-primary">Wyloguj</button>
                                </form>
                            </div>
                        </div>
                    </li>
                @endauth
                <li class="nav-item">
                    <a href="{{ route('adverts.create') }}" class="btn btn-primary font-weight-bold">Dodaj ogłoszenie</a>
                </li>
            </ul>
            <ul class="nav ml-auto d-lg-none">
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="btn btn-link font-weight-bold"><i class="fas fa-user fa-lg"></i></a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('adverts.create') }}" class="btn btn-link font-weight-bold"><i class="fas fa-plus fa-lg"></i></a>
                </li>
            </ul>
        </div>
    </div>
</nav>