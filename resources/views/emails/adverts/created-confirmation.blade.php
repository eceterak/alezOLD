@component('mail::message')
# Yo ziom

Własnie dodales nowe ogloszenie! GJ mate.

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
