@extends('admin.layouts.master')

@section('content')
<div class="card">
    @include('admin.cities._form', [
        'route' => ['admin.cities.store'],
        'method' => 'POST',
        'button' => 'Dodaj'
    ])
</div>
@endsection