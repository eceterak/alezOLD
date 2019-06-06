@extends('layouts.master')

@section('lead')

    @include('users._menu', [
        'title' => 'Obserwowane',
        'subtitle' => 'Miasta które obserwujesz'
    ])

    @if($subscriptions->count())
        <h5>Miasta</h5>
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
    @endif

    @if($notifications->count())
        <h5>Nowe ogłoszenia w obserwowanych miastach</h5>
        <div class="card mb-4">
            <table class="table">
                <tbody>
                    @foreach($notifications as $notification)
                        <tr>
                            <td>{!! $notification->data['message'] !!}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection