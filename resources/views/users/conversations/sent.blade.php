@extends('layouts.master')

@section('lead')

    @include('users._menu', [
        'title' => 'Wysłane',
        'subtitle' => 'Wysłane wiadomości'
    ])

    <div class="card">
        @if($conversations->count())
            <table class="table">
                <tbody>
                    @foreach($conversations as $conversation)
                        <tr>
                            <td>
                                <p class="card-text">
                                    @if($conversation->hasNewMessagesFor($profile))
                                        <strong><a href="{{ route('conversations.show', $conversation->id) }}">{{ str_limit($conversation->messages()->first()->body, 80) }}</a></strong>
                                    @else
                                        <a href="{{ route('conversations.show', $conversation->id) }}">{{ str_limit($conversation->messages()->first()->body, 80) }}</a>
                                    @endif
                                </p>
                            </td>
                            <td class="fit small">
                                <p @if($conversation->advert->archived) style="text-decoration: line-through;" @endif class="mb-0">
                                    <a href="{{ route('adverts.show', [$conversation->advert->city->slug, $conversation->advert->slug]) }}">{{ $conversation->advert->title }}<i class="fas fa-link fa-xs ml-1"></i></a>
                                </p>
                            </td>
                            <td class="fit">
                                <p class="mb-0">{!! $conversation->interlocutor->path !!}</p>
                            </td>
                            <td class="fit">
                                @if($conversation->updated_at->diffInDays() < 1)
                                    <p class="card-text text-muted">{{ $conversation->updated_at->format('H:i') }}</p>
                                @else
                                    @if($conversation->updated_at->diffInYears() < 1)
                                        <p class="card-text text-muted">{{ $conversation->updated_at->format('j F') }}</p>
                                    @else
                                        <p class="card-text text-muted">{{ $conversation->updated_at->format('j F Y') }}</p>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="card-body text-center">
                <p class="card-text">Nie masz żadnych wysłanych wiadomości</p>
            </div>
        @endif
    </div>

@endsection