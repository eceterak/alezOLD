<ul class="list-reset flex">
    <li class="card-tab"><a href="{{ route('admin.cities.edit', $city->slug) }}">Miasto</a></li>
    <li class="card-tab"><a href="{{ route('admin.cities.streets', $city->slug) }}">Ulice</a></li>
    <li class="card-tab"><a href="{{ route('admin.cities.adverts', $city->slug) }}">Ogłoszenia</a></li>
</ul>
<div class="card">
    {{ $slot }}
</div>