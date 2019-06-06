@extends('layouts.master')

@section('lead')

    @include('users._menu', [
        'title' => $advert->title,
        'subtitle' => ''
    ])

    @if($conversations->count())
        <div class="card">
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
        </div>
    @endif

@endsection