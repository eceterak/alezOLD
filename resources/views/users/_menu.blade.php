<div class="flex flex-col">
    <div>
        <h3 class="mb-6 font-normal">{{ $title }}</h3>
        <p>{{ $subtitle }}</p>
    </div>
    <ul class="list-group list-group-horizontal">
        <li class="list-group-item border-0 bg-transparent pl-0"><a href="{{ route('home') }}">Ogłoszenia</a></li>
        <li class="list-group-item border-0 bg-transparent"><a href="{{ route('conversations.inbox') }}">Odebrane</a></li>
        <li class="list-group-item border-0 bg-transparent"><a href="{{ route('conversations.sent') }}">Wysłane</a></li>
        <li class="list-group-item border-0 bg-transparent"><a href="{{ route('subscriptions') }}">Obserwowane</a></li>
        <li class="list-group-item border-0 bg-transparent"><a href="{{ route('favourites') }}">Ulubione</a></li>
        <li class="list-group-item border-0 bg-transparent"><a href="{{ route('settings') }}">Ustawienia</a></li>
    </ul>
</div>