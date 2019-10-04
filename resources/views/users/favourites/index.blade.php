@extends('layouts.master')

@section('breadcrumbs')
    @include('users._menu')
@endsection

@section('content')
    @if($favourites->count())
        <div class="advert-list">
            @foreach($favourites as $favourite)
                <div class="advert">
                    <div class="row no-gutters">
                        <div class="col-4 col-lg-1 d-flex align-items-center">
                            <a href="{{ route('adverts.show', [$favourite->advert->city->slug, $favourite->advert->slug]) }}"><img src="{{ $favourite->advert->featured_photo_path }}" alt="" class="img-fluid"></a>
                        </div>
                        <div class="col-8 col-lg-11 pl-3">
                            <div class="row h-100 align-content-lg-center">
                                <div class="col-lg-9 pr-lg-0">
                                    <h5 class="title mb-0">
                                        <a href="{{ route('adverts.show', [$favourite->advert->city->slug, $favourite->advert->slug]) }}">{{ $favourite->advert->title }}</a>
                                    </h5>
                                    <p class="small text-muted mb-0">Pokój {{ $favourite->advert->room_size_translated }}, {{ $favourite->advert->city->name }}</p>
                                </div>
                                <div class="col-lg-3 text-lg-right">
                                    <form action="{{ route('adverts.favourite.delete', [$favourite->advert->city->slug, $favourite->advert->slug]) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger d-inline">Usuń</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        {{ $favourites->onEachSide(1)->links() }}
        @else
            <p class="text-center mb-0">Nie masz żadnych zapisanych ogłoszeń</p>
        @endif
    </div>
@endsection

