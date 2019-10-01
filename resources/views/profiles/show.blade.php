@extends('layouts.master')
@section('breadcrumbs')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h3 class="text-grey-darker">{{ $profile->name }}</h3>
            <p class="text-muted mt-1 mb-0">{{ $profile->created_at->diffForHumans() }}</p>
        </div>
        <img src="{{ $profile->avatar_path }}" alt="" class="card-img-top img-fluid rounded-circle" style="width: 5rem; height: 5rem;">
    </div>
@endsection
@section('content')
    <header class="flex justify-between mb-4">
        <div>
            @if($profile->bio)
                <p class="mb-4">{{ $profile->bio }}</p> 
            @endif
            <h5>Ogłoszenia użytkownika</h5>
        </div>
    </header>
    @include('adverts._listUser')
@endsection