@component('mail::message')
<h2>Cześć {{ ucfirst($advert->user->name) }},</h2>

Twoje ogłoszenie zostało właśnie zweryfikowane przez administratora i jest widoczne dla innych użytkowników.

@component('mail::button', ['url' => route('adverts.show', [$advert->city->slug, $advert->slug])])
Twoje ogłoszenie
@endcomponent
@endcomponent