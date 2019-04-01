<div class="card">
    <header>
        <h3>{{ $header }}</h3>
    </header>
    <div class="card-content">
        <form action="{{ route(...$route) }}" method="POST" class="form">
            @csrf
            @method($method)
            <div class="form-group">
                <label for="title">Tytuł</label>
                <input type="text" name="title" id="title" value="{{ $room->title }}">
            </div>
            <div class="form-group">
                <label for="description">Opis</label>
                <textarea name="description" id="description">{{ $room->description }}</textarea>
            </div>
            <div class="form-group">
                <label for="rent">Czynsz</label>
                <input type="number" name="rent" id="rent" value="{{ $room->rent }}">
            </div>
            @if(App\City::form()->count())
                <div class="form-group">
                    <label for="city_id">Miasto</label>
                    <select name="city_id" id="city_id">
                        @foreach (App\City::form() as $id => $name)
                            <option value="{{ $id }}" {{ (isset($room->city->id) && $id === $room->city->id) ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
            <button type="submit" class="btn btn-reverse">{{ $button }}</button>
        </form>
        @if($errors->any())
            <div class="mt-4">
                <ul class="list-reset">
                    @foreach($errors->all() as $error)
                        <li class="p-2 text-sm text-red">{{ $error }}</li>
                    @endforeach  
                </ul>
            </div>
        @endif
    </div>
</div>