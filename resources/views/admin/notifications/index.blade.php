@extends('admin.layouts.master')
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-flag fa-xs mr-2"></i>Zadania</h5>
        </div>
        @if($notifications->count())
            <table class="table mb-0 px-2">
                <tbody>
                    @foreach($notifications as $notification)
                        <tr>
                            <td>{!! $notification->data['message'] !!}</td>
                            <td class="fit"><a href="{{ $notification->data['link'] }}" class="btn btn-sm btn-primary">Sprawdź</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if($notifications->hasPages())
                <div class="card-footer">
                    {{ $notifications->links() }}
                </div>
            @endif
        @else
            <div class="card-body">
                <p class="card-text text-center">Brak zadań</p>
            </div>
        @endif      
    </div>
@endsection