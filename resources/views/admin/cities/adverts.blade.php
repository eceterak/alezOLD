@extends('admin.layouts.master')
@section('content')
    @component('admin.cities._card', ['city' => $city])
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-stream fa-xs mr-2"></i>Ogłoszenia w {{ $city->name }} <small>[{{ $adverts->count() }}]</small></h5>
            <div class="d-flex">
                <button data-toggle="collapse" data-target="#advertsFilters" class="btn btn-outline-primary btn-sm mr-2">Filtruj</button>
                <a href="{{ route('admin.adverts.create') }}" class="btn btn-primary btn-sm">Dodaj</a>
            </div>
        </div>
        <div class="collapse card-body bg-light show" id="advertsFilters">
            @include('admin.adverts._filters')
        </div>
        @if($adverts->count())
            <table class="table">
                <tbody>
                    @foreach($adverts as $advert)
                        <tr>
                            <td class="fit pr-0 text-center">
                                @if($advert->archived)
                                    <i class="fas fa-archive text-secondary"></i>
                                @elseif(!$advert->verified)
                                    <button type="button" class="btn btn-link btn p-0 text-danger" data-toggle="tooltip" data-placement="right" title="Ogłoszenie oczekuje na weryfikację przez Administratora.">
                                        <i class="fas fa-exclamation"></i>
                                    </button>
                                @elseif($advert->hasPendingRevision)
                                    <button type="button" class="btn btn-link btn p-0 text-danger" data-toggle="tooltip" data-placement="right" title="Ogłoszenie oczekuje na potwierdzenie zmian.">
                                        <i class="fas fa-edit text-warning"></i>
                                    </button>
                                @else
                                    <i class="fas fa-check text-success"></i>
                                @endif
                            </td>
                            <td style="width: 5rem;"><img src="{{ $advert->featured_photo_path }}" alt="" class="img-fluid"></td>
                            <td>
                                <p class="card-text mb-0">
                                    <a href="{{ route('adverts.show', [$advert->city->slug, $advert->slug]) }}">{{ $advert->title }}</a>
                                </p>
                                <p class="card-text"><small>{{ $advert->created_at }}</small></p>
                            </td>
                            <td>
                                <p class="small card-text"><a href="{{ route('admin.cities.edit', $advert->city->slug) }}">{{ $advert->city->name }}</a></p>
                            </td>
                            <td>
                                <p class="small card-text">{{ $advert->user->name }}</p>
                            </td>
                            <td>
                                <p class="small card-text">{{ $advert->visits }}<span class="mt-2 text-xs text-grey-darkest ml-2"><i class="fas fa-eye"></i></span></p>
                            </td>
                            <td class="fit">
                                <a href="{{ route('admin.adverts.edit', $advert->slug) }}" class="btn btn-sm btn-primary mr-2"><i class="fas fa-edit"></i></a>
                                <button class="btn btn-sm btn-danger d-inline" data-toggle="modal" data-target="#advertDeleteConfirmationModal" data-endpoint="{{ route('adverts.destroy', [$advert->city->slug, $advert->slug]) }}"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($adverts->hasPages())
            <div class="card-footer">
                {{ $adverts->links() }}
            </div>
        @endif
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
            <div class="card-body text-center">
                <p class="mb-0">Brak ogłoszeń</p>
            </div>
        @endif
    @endcomponent
@endsection