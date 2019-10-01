<div class="small">
    <span class="text-muted">Sortuj:</span>
    <div class="d-inline-block">
        <ul class="list-group list-group-horizontal sort-group">
            <li class="list-group-item border-0 bg-transparent {{ (request()->has('sort') && request()->sort == 'date') ? 'disabled' : '' }}"><a href="{{ request()->fullUrlWithQuery(['sort' => 'date']) }}">Najnowsze</a></li>
            <li class="list-group-item border-0 bg-transparent {{ (request()->has('sort') && request()->sort == 'rent_asc') ? 'disabled' : '' }}"><a href="{{ request()->fullUrlWithQuery(['sort' => 'rent_asc']) }}">Najtańsze</a></li>
            <li class="list-group-item border-0 bg-transparent {{ (request()->has('sort') && request()->sort == 'rent_desc') ? 'disabled' : '' }}"><a href="{{ request()->fullUrlWithQuery(['sort' => 'rent_desc']) }}">Najdroższe</a></li>
        </ul>
    </div>
</div>