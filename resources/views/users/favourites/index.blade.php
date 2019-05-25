@extends('layouts.master')

@section('lead')

    @include('users._menu', ['title' => 'Odebrane'])

    @if($favourites->count())

        <table class="table">
            <tbody>
                @foreach($favourites as $favourite)
                    <tr>
                        <td>
                            <p><a href="{{ route('adverts.show', [$favourite->advert->city->slug, $favourite->advert->slug]) }}">{{ $favourite->advert->title }}</a></p>
                            <p class="mt-2 text-xs text-grey-darkest">{{ $favourite->advert->created_at }}</p>
                        </td>
                        <td class="fit">
                            <form action="{{ route('adverts.favourite.delete', [$favourite->advert->city->slug, $favourite->advert->slug]) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-small bg-red text-white border-red inline">Usuń</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    @endif

@endsection