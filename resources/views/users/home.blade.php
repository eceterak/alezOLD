@extends('layouts.master')

@section('lead')

    @include('users._menu', [
        'title' => 'Twoje ogłoszenia',
        'subtitle' => 'Tutaj znajdziesz swoje ogłoszenia'
    ])

    <div class="card">
        <ul class="list-group list-group-horizontal small">
            <li class="list-group-item border-0 bg-transparent"><a href="{{ route('home') }}">Aktywne</a></li>
            <li class="list-group-item border-0 bg-transparent"><a href="{{ route('archives') }}">Archiwum</a></li>
        </ul>

        @if($adverts->count())
            <table class="table">
                <tbody>
                    @foreach($adverts as $advert)
                        <tr>
                            <td style="width: 5rem;"><img src="{{ $advert->featured_photo_path }}" alt="" class="img-fluid"></td>
                            <td>
                                <p class="card-text mb-0">
                                    <a href="{{ route('adverts.show', [$advert->city->slug, $advert->slug]) }}">{{ $advert->title }}</a>
                                    @if(!$advert->verified)
                                        <button type="button" class="btn btn-link btn-sm p-0 text-warning" data-toggle="tooltip" data-placement="right" title="Ogłoszenie oczekuje na weryfikację przez Administratora.">
                                            <i class="fas fa-exclamation-circle"></i>
                                        </button>
                                    @endif
                                </p>
                                <p class="card-text"><small>{{ $advert->created_at }}</small></p>
                            </td>
                            <td>
                                <p class="small card-text">{{ $advert->visits }}<span class="mt-2 text-xs text-grey-darkest ml-2"><i class="fas fa-eye"></i></span></p>
                            </td>
                            <td>
                                <p class="small card-text">
                                    @if($advert->conversations->count() > 0)        
                                        <a href="{{ route('conversations.advert', $advert->slug) }}">{{ $advert->conversations->count() }}
                                            <span class="mt-2 text-xs text-grey-darkest ml-2">
                                                <i class="fas fa-envelope"></i>
                                            </span>
                                        </a>
                                    @else
                                        {{ $advert->conversations->count() }}
                                        <span class="mt-2 text-xs text-grey-darkest ml-2">
                                            <i class="fas fa-envelope"></i>
                                        </span>
                                    @endif
                                </p>
                            </td>
                            <td class="fit">
                                <a href="{{ route('adverts.edit', [$advert->city->slug, $advert->slug]) }}" class="btn btn-sm btn-outline-primary mr-2">Edytuj</a>
                                <button class="btn btn-sm btn-danger d-inline" data-toggle="modal" data-target="#advertDeleteConfirmationModal" data-endpoint="{{ route('adverts.destroy', [$advert->city->slug, $advert->slug]) }}">Zakończ</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
        @else
            <div class="card-body text-center pt-0">
                <p>Nie masz żadnych aktywnych ogłoszeń.</p>
                <a href="{{ route('adverts.create') }}" class="btn btn btn-secondary ml-2">Dodaj jedno już teraz!</a>
            </div>
        @endif
    </div>
        
@endsection