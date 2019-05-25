<div class="flex flex-col">
    <div>
        <h3 class="mb-6 font-normal">{{ $title }}</h3>
    </div>
    <ul class="menu list-reset mb-4">
        <li><a href="{{ route('home') }}">Ogłoszenia</a></li>
        <li><a href="{{ route('conversations.inbox') }}">Odebrane</a></li>
        <li><a href="{{ route('conversations.sent') }}">Wysłane</a></li>
        <li><a href="{{ route('favourites') }}">Obserwowane</a></li>
        <li><a href="{{ route('settings') }}">Ustawienia</a></li>
    </ul>
</div>