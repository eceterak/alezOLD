@extends('admin.layouts.master')

@section('content')
    <div class="card">
        <header>
            <h3>Dodaj miasto</h3>
        </header>
        <div class="card-content">
            <form action="{{ route('admin.cities.store') }}" method="POST" class="form">
                @csrf
                <div class="form-group">
                    <label for="name">Nazwa</label>
                    <input type="text" name="name" id="name">
                </div>
                <button class="btn btn-reverse">Dodaj</button>
            </form>
        </div>
    </div>
@endsection