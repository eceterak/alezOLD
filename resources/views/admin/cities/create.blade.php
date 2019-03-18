@extends('admin.layouts.master')

@section('content')
    <div class="card">
        <header>
            <h3>Dodaj miasto</h3>
        </header>
        <div class="card-content">
            <form action="{{ route('admin.cities.store') }}" method="POST">
                @csrf
                <input type="text" name="name">
                <button class="btn">Dodaj</button>
            </form>
        </div>
    </div>
@endsection