@extends('layouts.master')

@section('breadcrumbs')
    <div class="d-flex align-items-center">
        <img src="{{ $profile->avatar_path }}" alt="" class="card-img-top img-fluid rounded-circle mr-3" style="width: 2rem; height: 2rem;">
        <h3 class="mb-0">{{ ucfirst($profile->name) }}</h3>
        <div class="ml-auto">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-sm btn-secondary">Wyloguj</button>
            </form>
        </div>
    </div>
@endsection

@section('content')
    <ul class="list-group user-menu">
        <li class="list-group-item"><a href="{{ route('home') }}" class="nav-link"><i class="fas fa-dollar-sign mr-2"></i>Ogłoszenia</a></li>
        <li class="list-group-item"><a href="{{ route('archives') }}" class="nav-link"><i class="fas fa-archive mr-2"></i>Archiwum</a></li>
        <li class="list-group-item"><a href="{{ route('conversations.inbox') }}" class="nav-link"><i class="fas fa-envelope mr-2"></i>Odebrane</a></li>
        <li class="list-group-item"><a href="{{ route('conversations.sent') }}" class="nav-link"><i class="fas fa-share-square mr-2"></i>Wysłane</a></li>
        <li class="list-group-item"><a href="{{ route('subscriptions') }}" class="nav-link"><i class="fas fa-eye mr-2"></i>Obserwowane</a></li>
        <li class="list-group-item"><a href="{{ route('favourites') }}" class="nav-link"><i class="far fa-star mr-2"></i>Ulubione</a></li>
        <li class="list-group-item"><a href="{{ route('settings') }}" class="nav-link"><i class="fas fa-cogs mr-2"></i>Ustawienia</a></li>
    </ul>
@endsection