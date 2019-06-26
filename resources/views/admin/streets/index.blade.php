@extends('admin.layouts.master')
@section('content')
    @component('admin.cities._card', ['city' => $city])
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-road fa-xs mr-2"></i>Ulice w {{ $city->name }}<small class="text-grey-darker">&nbsp;[{{ $city->streets->count() }}]</small></h5>
            <div class="d-flex">
                <a href="{{ route('admin.streets.create', $city->slug) }}" class="btn btn-primary btn-sm">Dodaj</a>
            </div>
        </div>
        @if($streets->count())
            <table class="table">
                <thead>
                    <tr>
                        <th>Nazwa</th>
                        <th>Longitude</th>
                        <th>Latitude</th>
                        <th class="fit">Akcja</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($streets as $street)
                        <tr>
                            <td><a href="{{ route('admin.streets.edit', [$city->slug, $street->id]) }}">{{ $street->name }}</a></td>
                            <td>{{ $street->lat }}</td>
                            <td>{{ $street->lon }}</td>
                            <td class="fit">
                                <form action="{{ route('admin.streets.destroy', [$city->slug, $street->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if($streets->hasPages())
                <div class="card-footer">
                    {{ $streets->links() }}
                </div>
            @endif
        @else
        <div class="card-content">
            <p>Brak ulic w tym mieście</p>
        </div>
        @endif
    @endcomponent
@endsection