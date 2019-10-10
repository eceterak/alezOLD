<div class="mb-2">
    <ul class="list-group list-group-horizontal sort-group align-items-center small">
        <li class="list-group-item pl-0">Sortuj:</li>
        <li class="list-group-item {{ (request()->has('sort') && request()->sort == 'date') ? 'disabled' : '' }}"><a href="{{ request()->fullUrlWithQuery(['sort' => 'date']) }}">Najnowsze</a></li>
        <li class="list-group-item {{ (request()->has('sort') && request()->sort == 'rent_asc') ? 'disabled' : '' }}"><a href="{{ request()->fullUrlWithQuery(['sort' => 'rent_asc']) }}">Najtańsze</a></li>
        <li class="list-group-item {{ (request()->has('sort') && request()->sort == 'rent_desc') ? 'disabled' : '' }}"><a href="{{ request()->fullUrlWithQuery(['sort' => 'rent_desc']) }}">Najdroższe</a></li>
        <li class="list-group-item d-block d-lg-none ml-auto pr-0"><button class="btn btn-sm btn-primary filters-show">Filtruj<i class="fas fa-filter fa-xs ml-1"></i></button></li>
    </ul>
</div>