<div class="d-flex">
    <div class="d-sm-block d-lg-none">
        <i class="fas fa-chevron-left fa-xs mr-4"></i>
    </div>
    <nav>
        <ul class="nav user-menu">
            <li class="nav-item d-none"><a href="{{ route('home') }}" class="nav-link">Ogłoszenia</a></li>
            <li class="nav-item d-none"><a href="{{ route('archives') }}" class="nav-link">Archiwum</a></li>
            <li class="nav-item d-none"><a href="{{ route('conversations.inbox') }}" class="nav-link">Odebrane</a></li>
            <li class="nav-item d-none"><a href="{{ route('conversations.sent') }}" class="nav-link">Wysłane</a></li>
            <li class="nav-item d-none"><a href="{{ route('subscriptions') }}" class="nav-link">Obserwowane</a></li>
            <li class="nav-item d-none"><a href="{{ route('favourites') }}" class="nav-link">Ulubione</a></li>
            <li class="nav-item d-none"><a href="{{ route('settings') }}" class="nav-link">Ustawienia</a></li>
            {{-- <li class="nav-item">
                <form action="{{ route('logout') }}" method="POST" class="dropdown-item">
                    @csrf
                    <button type="submit" class="btn btn-link">Wyloguj</button>
                </form>
            </li> --}}
        </ul>
    </nav>
</div>