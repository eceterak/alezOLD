@extends('admin.layouts.master')

@section('content')

    <div class="card">
        <header>
            <h3>Ostatnia aktywność</h3>
        </header>
        <div class="card-content">
            @if($activities->count())
                <ul class="list-reset">
                    @foreach($activities as $activity)
                        <li>
                            @include("admin.dashboard.activities.{$activity->description}")
                        </li>
                    @endforeach
                </ul>
            @else
                <p>Brak aktywności</p>
            @endif      
        </div>
    </div>

@endsection