@extends('admin.layouts.master')
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-bell fa-xs mr-2"></i>Aktywności</h5>
        </div>
        @if($activities->count())
            <table class="table mb-0 px-2">
                <tbody>
                    @foreach($activities as $activity)
                        <tr>
                            <td>
                                @includeIf("admin.dashboard.activities.{$activity->description}")
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="card-body">
                <p>Brak aktywności</p>
            </div>
        @endif      
    </div>
@endsection