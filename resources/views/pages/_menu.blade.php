<div class="flex flex-col">
    <div>
        <h3 class="mb-6 font-normal">{{ $title }}</h3>
    </div>
    <ul class="list-reset mb-4">
        <li><a href="{{ route('home') }}">Ogłoszenia</a></li>
        <li><a href="{{ route('conversations.inbox') }}">Odebrane</a></li>
        <li><a href="{{ route('home') }}">Wysłane</a></li>
        <li><a href="{{ route('home') }}">Obserwowane</a></li>
        <li><a href="{{ route('home') }}">Ustawienia</a></li>
    </ul>
</div>