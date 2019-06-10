<div class="flex flex-col">
    <div>
        <h3 class="mb-6 font-normal">{{ $title }}</h3>
        <p>{{ $subtitle }}</p>
    </div>
    <ul class="nav nav-tabs user-menu">
        <li class="nav-item"><a href="{{ route('home') }}" class="nav-link">Ogłoszenia</a></li>
        <li class="nav-item"><a href="{{ route('archives') }}" class="nav-link">Archiwum</a></li>
        <li class="nav-item"><a href="{{ route('conversations.inbox') }}" class="nav-link">Odebrane</a></li>
        <li class="nav-item"><a href="{{ route('conversations.sent') }}" class="nav-link">Wysłane</a></li>
        <li class="nav-item"><a href="{{ route('subscriptions') }}" class="nav-link">Obserwowane</a></li>
        <li class="nav-item"><a href="{{ route('favourites') }}" class="nav-link">Ulubione</a></li>
        <li class="nav-item"><a href="{{ route('settings') }}" class="nav-link">Ustawienia</a></li>
    </ul>
</div>