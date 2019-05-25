@extends('layouts.master')

@section('lead')

    @include('users._menu', ['title' => 'Wysłane'])

    @if($conversations->count())

        <table class="table">
            <tbody>
                @foreach($conversations as $conversation)
                    <tr>
                        <td>
                            @if($conversation->hasNewMessagesFor($profile))
                                <p><strong><a href="{{ route('conversations.show', $conversation->id) }}">{{ $conversation->messages()->first()->body }}</a></strong></p>
                            @else
                                <p><a href="{{ route('conversations.show', $conversation->id) }}">{{ $conversation->messages()->first()->body }}</a></p>    
                            @endif
                        </td>
                        <td class="fit">
                            <p class="text-xs text-grey-darkest"></p>
                        </td>
                        <td class="fit">
                            <p class="text-xs text-grey-darkest">{{ $conversation->updated_at }}</p>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    @endif

@endsection