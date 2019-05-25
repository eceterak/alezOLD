@extends('layouts.master')

@section('lead')

    @include('users._menu', ['title' => 'Twoje ogłoszenia'])

    @if($adverts->count())

        <table class="table">
            <tbody>
                @foreach($adverts as $advert)
                    <tr>
                        <td class="w-24"><img src="{{ $advert->featured_photo_path }}" alt=""></td>
                        <td>
                            <p><a href="{{ route('adverts.show', [$advert->city->slug, $advert->slug]) }}">{{ $advert->title }}</a></p>
                            <p class="mt-2 text-xs text-grey-darkest">{{ $advert->created_at }}</p>
                        </td>
                        <td>
                            <p class="text-sm">{{ $advert->visits }}<span class="mt-2 text-xs text-grey-darkest ml-2"><i class="fas fa-eye"></i></span></p>
                        </td>
                        <td><p class="text-sm">{{ $advert->conversations->count() }}<span class="mt-2 text-xs text-grey-darkest ml-2"><i class="fas fa-envelope"></i></span></p></td>
                        <td class="fit">
                            <a href="{{ route('adverts.edit', [$advert->city->slug, $advert->slug]) }}" class="btn btn-small mr-2">Edytuj</a>
                            <form action="{{ route('adverts.destroy', [$advert->city->slug, $advert->slug]) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-small bg-red text-white border-red inline">Zakończ</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    @endif
        
@endsection