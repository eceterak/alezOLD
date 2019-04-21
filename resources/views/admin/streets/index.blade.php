@extends('admin.layouts.master')

@section('content')
    
    @forelse($streets as $street)
        <a href="{{ route('admin.streets.edit', [$street->city->path(), $street->path()]) }}"><p>{{ $street->name }}</p></a>
    @empty
        
    @endforelse

@endsection