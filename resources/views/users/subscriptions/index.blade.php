@extends('layouts.master')

@section('breadcrumbs')
    @include('users._menu')
@endsection

@section('content')

    <h5>Obserwowane miasta</h5>
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
        <ul class="list-group">
            @foreach($notifications as $notification)
                <li class="list-group-item">
                    @if($notification->unread())
                        <p class="mb-0"><i class="fas fa-bell fa-xs mr-2"></i><strong>{!! $notification->data['message'] !!}</strong></p>
                    @else
                        <p class="mb-0">
                            <i class="far fa-bell fa-xs mr-2"></i>
                            <span>{!! $notification->data['message'] !!}</span>
                            <span class="float-right">{{ $notification->created_at->diffForHumans() }}</span>
                        </p>
                    @endif
                </li>
            @endforeach
        </ul>
    @else
        <div class="card">
            <div class="card-body text-center">
                <p class="card-text">Nie masz żadnych powiadomień</p>
            </div>
        </div>
    @endif

@endsection