<div class="d-flex">
    <div class="d-sm-block d-lg-none">
        <a href="{{ route('home-mobile') }}" class="text-body"><i class="fas fa-arrow-left fa-sm"></i></a>
    </div>
    <nav>
        <ul class="nav user-menu">
            <li class="nav-item"><a href="{{ route('home') }}" class="nav-link">Ogłoszenia</a></li>
            <li class="nav-item"><a href="{{ route('archives') }}" class="nav-link">Archiwum</a></li>
            <li class="nav-item"><a href="{{ route('conversations.inbox') }}" class="nav-link">Odebrane</a></li>
            <li class="nav-item"><a href="{{ route('conversations.sent') }}" class="nav-link">Wysłane</a></li>
            <li class="nav-item"><a href="{{ route('subscriptions') }}" class="nav-link">Obserwowane</a></li>
            <li class="nav-item"><a href="{{ route('favourites') }}" class="nav-link">Ulubione</a></li>
            <li class="nav-item"><a href="{{ route('settings') }}" class="nav-link">Ustawienia</a></li>
        </ul>
    </nav>
</div>