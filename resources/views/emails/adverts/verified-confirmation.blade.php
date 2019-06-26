@component('mail::message')
Cześć, {{ ucfirst($advert->user->name) }}

Twoje ogłoszenie zostało zweryfikowane przez administratora i jest widoczne dla innych użytkowników.

@component('mail::button', ['url' => route('adverts.show', [$advert->city->slug, $advert->slug])])
Twoje ogłoszenie
@endcomponent

Dziękujemy za korzystanie z serwisu,<br>
{{ config('app.name') }}
@endcomponent
