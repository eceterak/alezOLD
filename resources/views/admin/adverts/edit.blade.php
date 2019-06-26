@extends('admin.layouts.master')
@section('content')
    @if($advert->archived)
        <div class="alert alert-warning"><i class="fas fa-archive mr-2 fa-sm"></i>Ogłoszenie archiwalne</div>
    @endif
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0 d-inline">Edytuj ogłoszenie</h5>
                <p class="small mb-0">Dodano {{ $advert->created_at }} przez {!! $advert->user->path !!}</p>
            </div>
            <div class="d-flex">
                @if($advert->hasPendingRevision)
                    <button class="btn btn-sm btn-warning d-inline mr-2 text-white" data-toggle="modal" data-target="#advertRevisionModal"><i class="fas fa-eye"></i></button>
                @endif
                <verify-button verified="{{ $advert->verified }}"></verify-button>
                <form action="{{ route('admin.adverts.destroy', $advert->slug) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger d-inline-block"><i class="fas fa-trash "></i></button>
                </form>
            </div>
        </div>
        <div class="card-body">
            @include('admin.adverts._form', [
                'route' => ['admin.adverts.update', [$advert->slug]],
                'name' => 'create_new_advert',
                'header' => 'Edytuj ogłoszenie',
                'method' => 'PATCH',
                'button' => 'Zapisz'
            ])
        </div>
    </div>
    @if($advert->hasPendingRevision)
        <div class="modal fade" id="advertRevisionModal" tabindex="-1" role="dialog" aria-labelledby="advert revision modal" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header border-0 pb-0">
                        <h6 class="mb-0">Zmiany w ogłoszeniu</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table">
                            <thead>
                                <th>Atrybut</th>
                                <th>Przed zmianą</th>
                                <th>Po zmianie</th>
                            </thead>
                            @foreach($advert->revision as $key => $value)
                                <tr>
                                    <td>{{ $key }}</td><td>{{ $advert->{$key} }}</td><td>{{ $value }}</td>
                                </tr>
                            @endforeach
                        </table>
                        <div class="d-flex">
                            <form action="{{ route('admin.adverts.revision.store', $advert->slug) }}" method="POST" class="mr-2">
                                @csrf
                                <button class="btn btn-primary btn-sm">Zaakceptuj</button>
                            </form>
                            <form action="{{ route('admin.adverts.revision.destroy', $advert->slug) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Odrzuć</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection