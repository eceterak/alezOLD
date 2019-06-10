@extends('layouts.master')

@section('lead')

    @include('users._menu', [
        'title' => 'Ulubione',
        'subtitle' => 'Zapisane ogłoszenia'
    ])

    <div class="card">
        @if($favourites->count())
            <table class="table">
                <tbody>
                    @foreach($favourites as $favourite)
                        <tr>
                            <td style="width: 5rem;"><img src="{{ $favourite->advert->featured_photo_path }}" alt="" class="img-fluid"></td>
                            <td>
                                <p class="card-text mb-0" @if($favourite->advert->archived) style="text-decoration: line-through;" @endif>
                                    <a href="{{ route('adverts.show', [$favourite->advert->city->slug, $favourite->advert->slug]) }}">{{ $favourite->advert->title }}</a>
                                </p>
                                <p class="card-text"><small>{{ $favourite->advert->created_at }}</small></p>
                            </td>
                            <td class="fit">
                                <form action="{{ route('adverts.favourite.delete', [$favourite->advert->city->slug, $favourite->advert->slug]) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger d-inline">Usuń</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $favourites->links() }}
        @else
            <div class="card-body text-center">
                <p class="card-text">Nie masz żadnych zapisanych ogłoszeń</p>
            </div>
        @endif
    </div>
@endsection