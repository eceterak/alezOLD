@component('mail::message')
<h2>Cześć {{ ucfirst($advert->user->name) }},</h2>

Twoje ogłoszenie zostało dodane i oczekuje na weryfikację przez administratora. Pamiętaj, że do czasu weryfikacji, ogłoszenie nie będzie widoczne dla innych użytkowników.

@component('mail::button', ['url' => route('adverts.show', [$advert->city->slug, $advert->slug])])
Twoje ogłoszenie
@endcomponent
@endcomponent