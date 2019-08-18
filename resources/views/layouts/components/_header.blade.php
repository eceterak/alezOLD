<nav class="navbar navbar-expand-lg {{ isset($class) ? $class : '' }}" id="navbar-top">
    <div class="container">
        <a href="{{ route('index') }}" class="navbar-brand">www.alez.pl</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu-top">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="menu-top">
            <ul class="navbar-nav nav-pills mr-auto align-items-center">
                <li class="nav-item">
                    <a href="{{ route('index') }}" class="nav-link active">Strona główna</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('aboutUs') }}" class="nav-link">O nas</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('aboutUs') }}" class="nav-link">Kontakt</a>
                </li>
            </ul>
            <ul class="nav">
                <li class="nav-item">
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-link font-weight-bold">Logowanie/rejestracja</a>
                    @endguest
                    @auth
                        <div class="dropdown d-inline-block mx-2">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
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
                    @endauth
                </li>
                <li class="nav-item">
                    <a href="{{ route('adverts.create') }}" class="btn btn-primary font-weight-bold">Dodaj ogłoszenie</a>
                </li>
            </ul>
        </div>
    </div>
</nav>