@extends('layouts.master')
@section('lead')
    <header class="flex justify-between mb-4">
        <div>
            <h3 class="text-grey-darker">{{ $profile->path }}</h3>
            <p>{{ $profile->created_at->diffForHumans() }}</p>
            @if($profile->bio) 
                <p>{{ $profile->bio }}</p> 
            @endif
            <p class="text-grey-darker mt-1">
                Ogłoszenia użytkownika
            </p>
        </div>
    </header>
    @include('adverts._list')
@endsection