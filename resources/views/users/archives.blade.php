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
                                    <a href="{{ route('adverts.show', [$advert->city->slug, $advert->slug]) }}" class="text-muted">{{ $advert->title }}</a>
                                    @if(!$advert->verified)
                                        <button type="button" class="btn btn-link btn-sm p-0 text-warning" data-toggle="tooltip" data-placement="right" title="Ogłoszenie oczekuje na weryfikację przez Administratora.">
                                            <i class="fas fa-exclamation-circle"></i>
                                        </button>
                                    @endif
                                    @if($advert->archived)
                                        <button type="button" class="btn btn-link btn-sm p-0 text-warning" data-toggle="tooltip" data-placement="right" title="Ogłoszenie archiwalne.">
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
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $adverts->links() }}
        </div>
        @else
            <div class="card-body text-center pt-0">
                <p>Nie masz żadnych archiwalnych ogłoszeń.</p>
            </div>
        @endif
    </div>
        
@endsection