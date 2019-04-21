<div class="card">
    <header>
        <h3>{{ $header }}</h3>
    </header>
    <div class="card-content">

        <form action="{{ route(...$route) }}" method="POST" class="form">
                
            @csrf
            @method($method)

            {{-- @if(App\City::form()->count())
                <div class="form-group">
                    <label for="city_id">Miasto</label>
                    <select name="city_id" id="city_id">
                        @foreach (App\City::form() as $id => $name)
                            <option value="{{ $id }}" {{ (isset($room->city->id) && $id === $room->city->id) ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            <div class="form-group">
                <label for="address">Adres</label>
                <input type="text" name="address" id="address">
            </div>

            <div class="form-group">
                <label for="property_size">Wielkosc niruchomosci</label>
                <select name="property_size" id="property_size">
                    @for($i = 0; $i < 12; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>

            <div class="form-group">
                <label for="property_type">Rodzaj nieruchomosci</label>
                <select name="property_type" id="property_type">
                    @for($i = 0; $i < 12; $i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>

            <div class="form-group">
                <label for="landlord">Jestem</label>
                <select name="landlord" id="landlord">
                    @for($i = 0; $i < 12; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>           

            <div class="form-group">
                <label for="living_room">Posiada salon</label>
                <input type="checkbox" name="living_room" id="living_room">
            </div>

            <div class="form-group">
                <label for="room_size">Wielkosc pokoju</label>
                <input type="radio" name="room_size">1
                <input type="radio" name="room_size">2
            </div>
            
            <div class="form-group">
                <label for="furnished">Pokoj umeblowany</label>
                <input type="checkbox" name="furnished" id="furnished">
            </div>
            
            <div class="form-group">
                <label for="ensuite">Pokoj samowystarczalny</label>
                <input type="checkbox" name="ensuite" id="ensuite">
            </div>

            <div class="form-group">
                <label for="rent">Czynsz</label>
                <input type="number" name="rent" id="rent" value="{{ $room->rent }}">
            </div>

            <div class="form-group">
                <label for="rent">Depozyt</label>
                <input type="number" name="deposit" id="deposit" value="{{ $room->rent }}">
            </div>

            <div class="form-group">
                <label for="bills_included">Rachunki wliczone w cene</label>
                <input type="checkbox" name="bills_included" id="bills_included">
            </div>
            
            <div class="form-group">
                <label for="broadband">Internet</label>
                <input type="checkbox" name="broadband" id="broadband">
            </div>
            
            <div class="form-group">
                <label for="available_day">Pokoj dostepny od</label>
                <select name="available_day" id="available_day">
                    <option value="1">1</option>
                    <option value="2">2</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="available_month">Pokoj dostepny od</label>
                <select name="available_month" id="available_month">
                    <option value="1">1</option>
                    <option value="2">2</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="available_year">Pokoj dostepny od</label>
                <select name="available_year" id="available_year">
                    <option value="1">1</option>
                    <option value="2">2</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="minumum_stay">Minimalny czas pobytu</label>
                <select name="minimum_stay" id="minimum_stay">
                    <option value="1">1</option>
                    <option value="2">2</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="maximum_stay">Maksymalny czas pobytu</label>
                <select name="maximum_stay" id="maximum_stay">
                    <option value="1">1</option>
                    <option value="2">2</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="short_term">Dostepny krotkoterminowo</label>
                <input type="checkbox" name="short_term" id="short_term">
            </div>
            
            <div class="form-group">
                <label for="days_available">Dostepnosc</label>
                <select name="days_available" id="days_available">
                    <option value="7 dni w tygodniu">7 dni w tygodniu</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="smoking">Palacze</label>
                <input type="checkbox" name="smoking" id="smoking">
            </div>
            
            <div class="form-group">
                <label for="gender">Preferowana plec</label>
                <select name="gender" id="gender">
                    <option value="N">N</option>
                    <option value="N">M</option>
                    <option value="N">K</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="ocupation">Zatrudnienie</label>
                <select name="ocupation" id="ocupation">
                    <option value="N">N</option>
                    <option value="N">M</option>
                    <option value="N">K</option>
                </select>
            </div>

            <div class="form-group">
                <label for="pets">Zwierzeta</label>
                <input type="checkbox" name="pets" id="pets">
            </div>

            <div class="form-group">
                <label for="minimum_age">Minimalny wiek</label>
                <select name="minimum_age" id="minimum_age">
                    <option value="N">N</option>
                    <option value="N">M</option>
                    <option value="N">K</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="maximum_age">Maksymalny wiek</label>
                <select name="maximum_age" id="maximum_age">
                    <option value="N">N</option>
                    <option value="N">M</option>
                    <option value="N">K</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="couples">Pary</label>
                <input type="checkbox" name="couples" id="couples">
            </div>
            
            <div class="form-group">
                <label for="description">Opis</label>
                <textarea name="description" id="description">{{ $room->description }}</textarea>
            </div> --}}
            
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