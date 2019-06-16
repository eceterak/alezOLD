@extends('layouts.master')

@section('lead')

    @include('users._menu', [
        'title' => 'Obserwowane',
        'subtitle' => 'Miasta które obserwujesz'
    ])

    <h5 class="mt-4">Obserwowane miasta</h5>
        @if($subscriptions->count())
        <div class="card mb-4">
            <table class="table">
                <tbody>
                    @foreach($subscriptions as $subscription)
                        <tr>
                            <td>{{ $subscription->city->name }}</td>
                            <td class="fit">
                                <form action="{{ route('city.unsubscribe', $subscription->city->slug) }}" method="POST" class="inline-block">
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
        @else
            <div class="card">
                <div class="card-body text-center">
                    <p class="card-text">Nie obserwujesz żadnych miast</p>
                </div>
            </div>
        @endif

    <h5 class="mt-4">Powiadomienia</h5>
        @if($notifications->count())
        <div class="card mb-4">
            <table class="table">
                <tbody>
                    @foreach($notifications as $notification)
                        <tr>
                            <td>
                                @if($notification->unread())
                                    <strong>{!! $notification->data['message'] !!}</strong>
                                @else
                                    {!! $notification->data['message'] !!}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="card">
            <div class="card-body text-center">
                <p class="card-text">Nie masz żadnych powiadomień</p>
            </div>
        </div>
    @endif

@endsection