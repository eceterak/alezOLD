@extends('layouts.master')

@section('breadcrumbs')
    @include('users._menu')
@endsection

@section('content')
    @if($adverts->count())
        <div class="advert-list">
            @foreach($adverts as $advert)
<<<<<<< HEAD
                <div class="advert mb-3 pb-3 border-bottom">
                    <div class="row no-gutters">
                        <div class="col-4 col-lg-2 d-flex align-items-center">
                            <a href="{{ route('adverts.show', [$advert->city->slug, $advert->slug]) }}"><img src="{{ $advert->featured_photo_path }}" class="img-fluid"></a>
                        </div>
                        <div class="col-8 col-lg-10 pl-3">
                            <div class="row h-100 align-content-lg-center">
                                <div class="col-12 col-lg-7 pr-lg-0">
                                    <h5 class="title mb-0">
                                        <a href="{{ route('adverts.show', [$advert->city->slug, $advert->slug]) }}">{{ $advert->title }}</a>
                                    </h5>
                                    <p class="small text-muted mb-0 d-none d-lg-block">Pokój {{ $advert->room_size_translated }}, {{ $advert->city->name }}</p>
                                </div>
                                <div class="col-lg-2 pr-0 text-lg-center my-2 my-lg-0">
                                    <p class="small font-weight-bold mb-0 d-inline mr-4">{{ $advert->visits }}<span class="mt-2 text-xs ml-2"><i class="fas fa-eye"></i></span></p>
                                    <p class="small mb-0 font-weight-bold d-inline">
                                        @if($advert->conversations->count() > 0)        
                                            <a href="{{ route('conversations.advert', $advert->slug) }}">{{ $advert->conversations->count() }}
=======
                <div class="card advert mb-3">
                    <div class="card-body">
                        <div class="row no-gutters">
                            <div class="col-4 col-lg-2 d-flex align-items-center">
                                <a href="{{ route('adverts.show', [$advert->city->slug, $advert->slug]) }}"><img src="{{ $advert->featured_photo_path }}" class="img-fluid"></a>
                            </div>
                            <div class="col-8 col-lg-10 pl-3">
                                <div class="row h-100 align-content-lg-center">
                                    <div class="col-12 col-lg-7 pr-0">
                                        <h5 class="title mb-0">
                                            <a href="{{ route('adverts.show', [$advert->city->slug, $advert->slug]) }}">{{ $advert->title }}</a>
                                        </h5>
                                        <p class="small text-muted mb-0">Pokój {{ $advert->room_size_translated }}, {{ $advert->city->name }}</p>
                                    </div>
                                    <div class="col-lg-2 pr-0 text-lg-center my-2 my-lg-0">
                                        <p class="small font-weight-bold mb-0 d-inline mr-4">{{ $advert->visits }}<span class="mt-2 text-xs ml-2"><i class="fas fa-eye"></i></span></p>
                                        <p class="small mb-0 font-weight-bold d-inline">
                                            @if($advert->conversations->count() > 0)        
                                                <a href="{{ route('conversations.advert', $advert->slug) }}">{{ $advert->conversations->count() }}
                                                    <span class="mt-2 text-xs ml-2">
                                                        <i class="fas fa-envelope"></i>
                                                    </span>
                                                </a>
                                            @else
                                                {{ $advert->conversations->count() }}
>>>>>>> 15ac1e857bcc019b8e56e5adbb56ae2465c9fc78
                                                <span class="mt-2 text-xs ml-2">
                                                    <i class="fas fa-envelope"></i>
                                                </span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-lg-3 text-lg-right">
                                        <a href="{{ route('adverts.edit', [$advert->city->slug, $advert->slug]) }}" class="btn btn-sm btn-primary mr-2 font-weight-bold">Edytuj</a>
                                        <button class="btn btn-sm btn-danger d-inline font-weight-bold" data-toggle="modal" data-target="#advertDeleteConfirmationModal" data-endpoint="{{ route('adverts.destroy', [$advert->city->slug, $advert->slug]) }}">Zakończ</button>
                                    </div>
                                </div>
                                <div class="col-lg-3 text-lg-right">
                                    <a href="{{ route('adverts.edit', [$advert->city->slug, $advert->slug]) }}" class="btn btn-sm btn-primary mr-2 font-weight-bold">Edytuj</a>
                                    <button class="btn btn-sm btn-danger d-inline font-weight-bold" data-toggle="modal" data-target="#advertDeleteConfirmationModal" data-endpoint="{{ route('adverts.destroy', [$advert->city->slug, $advert->slug]) }}">Zakończ</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-4">
            {{ $adverts->links() }}
        </div>
        <div class="modal fade" id="advertDeleteConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header border-0 pb-0">
                        <h6 class="mb-0">Czy na pewno chcesz zakończyć to ogłoszenie?</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="POST" class="d-inline-block" id="confirmationForm">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Tak, zakończ</button>
                            <button type="button" class="btn btn-secondary ml-2 btn-sm" data-dismiss="modal">Anuluj</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="card">
            <div class="card-body text-center">
                <p>Nie masz żadnych aktywnych ogłoszeń.</p>
                <a href="{{ route('adverts.create') }}" class="btn btn btn-secondary ml-2">Dodaj jedno już teraz!</a>
            </div>
        </div>
    @endif
@endsection