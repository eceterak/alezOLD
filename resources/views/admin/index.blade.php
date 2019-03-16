@extends('admin.layouts.master')

@section('content')
    <h2>Hi Admin</h2>

    <div>
        <ul class="list-reset mt-3">
            <li><a href="/admin/pokoje">Pokoje</a></li>
            <li><a href="/admin/miasta">Miasta</a></li>
        </ul>
    </div>
@endsection