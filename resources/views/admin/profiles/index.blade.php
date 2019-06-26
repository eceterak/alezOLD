@extends('admin.layouts.master')
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-users fa-xs mr-2"></i>Użytkownicy</h5>
            <a href="{{ route('admin.cities.create') }}" class="btn btn-primary btn-sm">Dodaj</a>
        </div>
        <div>
            @if($profiles->count())
                <table class="table">
                    <thead>
                        <th>Nazwa</th>
                        <th>Email</th>
                        <th>Ogłoszenia</th>
                        <th>Konto założone</th>
                        <th>Akcja</th>
                    </thead>
                    <tbody>
                        @foreach($profiles as $profile)
                            <tr>
                                <td>{{ $profile->name }}</td>
                                <td>{{ $profile->email }}</td>
                                <td>{{ $profile->adverts_count }}</td>
                                <td class="fit">{{ $profile->created_at }}</td>
                                <td class="fit">delete</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $profiles->links() }}
            @else
                <p>Brak miast do wyświetlenia</p>
            @endif
        </div>
    </div>
@endsection