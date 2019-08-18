@extends('admin.layouts.master')
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-city fa-xs mr-2"></i>Miasta</h5>
            <a href="{{ route('admin.cities.create') }}" class="btn btn-primary btn-sm">Dodaj</a>
        </div>
        <div>
            @if($cities->count())
                <table class="table">
                    <tbody>
                        <thead>
                            <th>Nazwa</th>
                            <th>Gmina</th>
                            <th>Powiat</th>
                            <th>Województwo</th>
                            <th>Ogłoszenia</th>
                            <th>Akcja</th>
                        </thead>
                        @foreach($cities as $city)
                            <tr>
                                <td><a href="{{ route('admin.cities.edit', $city->slug) }}">{{ $city->name }}</a></td>
                                <td>{{ $city->community }}</td>
                                <td>{{ $city->county }}</td>
                                <td>{{ $city->state }}</td>
                                <td class="fit"><i class="fas fa-stream mr-2"></i>{{ $city->adverts_count }}</td>
                                <td class="fit">
                                    <form action="{{ route('admin.cities.destroy', [$city->slug]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if($cities->hasPages())
                <div class="card-footer">
                    {{ $cities->links() }}
                </div>
            @endif
            @else
                <p>Brak miast do wyświetlenia</p>
            @endif
        </div>
    </div>
@endsection