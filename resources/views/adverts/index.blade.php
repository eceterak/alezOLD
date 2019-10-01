@extends('layouts.master')
@section('breadcrumbs')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h3>Wszystkie ogłoszenia</h3>
            <p class="mb-0">{{ ($adverts->total() > 1) ? 'Znaleziono '.$adverts->total().' ogłoszeń' : ($adverts->total() <= 0 ? '' : 'Znaleziono 1 ogłoszenie') }}</p>
        </div>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-3">
            @include('cities._filters')
        </div>
        <div class="col-md-9 pl-4">
            @include('adverts._list')
        </div>
    </div>
@endsection