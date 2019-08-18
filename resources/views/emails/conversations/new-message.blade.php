@component('mail::message')
<h2>Cześć {{ ucfirst($to->name) }},</h2>

Masz nową wiadomość dotyczącą ogłoszenia <a href="{{ route('adverts.show', [$advert->city->slug, $advert->slug]) }}">{{ $advert->title }}</a>

@component('mail::panel')
<h2 class="margin-0"><a href="{{ route('profiles.show', $from->id) }}">{{ $from->name }}</a></h2>
<p class="panel-item panel-text">{{ $message->body }}</p>
<p class="panel-item panel-footer">{{ $message->created_at }}</p>
@endcomponent

@component('mail::button', ['url' => route('conversations.show', $message->conversation->id)])
Odpowiedz teraz
@endcomponent
@endcomponent