<div class="card">
    <header>
        <h3>{{ $header }}</h3>
    </header>
    <div class="card-content">

        <form action="{{ route(...$route) }}" method="POST" name="create_new_advert" class="form">
                
            @csrf
            @method($method)

            <div class="mb-4 pb-1 border-b border-grey">
                <h3>Informacje podstawowe</h3>
            </div>

            <div class="form-group">
                <label for="title">Tytuł ogłoszenia</label>
                <input type="text" name="title" id="title">
            </div>

            <div class="flex -mx-4">
                <div class="form-group w-1/3 px-4">
                    <label for="rent">Czynsz</label>
                    <div class="flex -mx-2">
                        <div class="w-2/3 px-2">
                            <input type="number" name="rent" id="rent" value="{{ $room->rent }}">
                        </div>
                        <div class="w-1/3 px-2">
                           <span>zł</span>
                        </div>
                    </div>
                </div>

                <div class="form-group w-1/3 px-4">
                    <label for="rent">Opłaty dodatkowe</label>
                    <input type="number" name="bills" id="bills" value="{{ $room->bills }}">
                </div>

                <div class="form-group w-1/3 px-4">
                    <label for="rent">Depozyt</label>
                    <input type="number" name="deposit" id="deposit" value="{{ $room->rent }}">
                </div>
            </div>

            <div class="flex -mx-4">
                <div class="form-group w-1/3 px-4">
                    <label for="room_size">Wielkość pokoju</label>
                    <select name="room_size" id="room_size">
                        <option value>wybierz</option>
                        <option value="single">jednoosobowy</option>
                        <option value="double">dwuosobowy</option>
                        <option value="three">trzyosobowy</option>
                    </select>
                </div>

                <div class="form-group w-1/3 px-4">
                    <label for="room_size">Jestem</label>
                    <select name="room_size" id="room_size">
                        <option value="live_in">Właścicielem nieruchomości</option>
                        <option value="agent">Pośrednikiem</option>
                    </select>
                </div>
            </div>

            <div class="mb-4 pb-1 border-b border-grey">
                <h3>Lokalizacja</h3>
             </div>

            <div class="flex -mx-4">
                <div class="form-group w-1/2 px-4">
                    <label for="city_id">Miasto</label>
                    <select name="city_id" id="city_id"></select>
                </div>
    
                <div class="form-group w-1/2 px-4">
                    <label for="street_id">Ulica</label>
                    <select name="street_id" id="street_id"></select>
                </div>
            </div>

            <div class="mb-4 pb-1 border-b border-grey">
                <h3>Informacje szczegółowe</h3>
            </div>

            <div class="form-group">
                <label for="description">Opis</label>
                <textarea name="description" id="description">{{ $room->description }}</textarea>
            </div>

            <div class="flex -mx-4">
                <div class="form-group w-1/3 px-4">
                    <label for="property_type">Rodzaj zabudowy</label>
                    <select name="property_type" id="property_type">
                        <option value>wybierz</option>
                        <option value="block">Blok</option>
                        <option value="house">Dom wolnostojący</option>
                        <option value="tenement">Kamienica</option>
                        <option value="apartment">Apartamentowiec</option>
                        <option value="loft">Loft</option>
                    </select>
                </div>
                <div class="form-group w-1/3 px-4">
                    <label for="property_size">Ilość pokoi</label>
                    <select name="property_size" id="property_size">
                        @for($i = 1; $i < 13; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
            </div>

            <div class="mb-4 pb-1 border-b border-grey">
                <h3>Dostępność</h3>
            </div>
            
            <div class="flex -mx-4">
                <div class="form-group w-1/3 px-4">
                    <label for="available_from">Dostępność od</label>
                    <input type="text" name="available_from" id="available_from">
                </div>
                <div class="form-group w-1/3 px-4">
                    <label for="minumum_stay">Minimalny czas pobytu</label>
                    <select name="minimum_stay" id="minimum_stay">
                        <option value>Brak</option>
                        <option value="1">1 miesiąc</option>
                        <option value="2">2 miesiące</option>
                        <option value="3">3 miesiące</option>
                        <option value="4">4 miesiące</option>
                        <option value="5">5 miesięcy</option>
                        <option value="6">6 miesięcy</option>
                        <option value="7">7 miesięcy</option>
                        <option value="8">8 miesięcy</option>
                        <option value="9">9 miesięcy</option>
                        <option value="10">10 miesięcy</option>
                        <option value="11">11 miesięcy</option>
                        <option value="12">1 rok</option>
                        <option value="15">1 Rok i 3 miesiące</option>
                        <option value="18">1 Rok i 6 miesięcy</option>
                        <option value="24">2 lata</option>
                    </select>
                </div>
                <div class="form-group w-1/3 px-4">
                    <label for="maximum_stay">Maksymalny czas pobytu</label>
                    <select name="maximum_stay" id="maximum_stay">
                            <option value>Brak</option>
                            <option value="1">1 miesiąc</option>
                            <option value="2">2 miesiące</option>
                            <option value="3">3 miesiące</option>
                            <option value="4">4 miesiące</option>
                            <option value="5">5 miesięcy</option>
                            <option value="6">6 miesięcy</option>
                            <option value="7">7 miesięcy</option>
                            <option value="8">8 miesięcy</option>
                            <option value="9">9 miesięcy</option>
                            <option value="10">10 miesięcy</option>
                            <option value="11">11 miesięcy</option>
                            <option value="12">1 rok</option>
                            <option value="15">1 Rok i 3 miesiące</option>
                            <option value="18">1 Rok i 6 miesięcy</option>
                            <option value="24">2 lata</option>
                    </select>
                </div>
            </div>


            <div class="mb-4 pb-1 border-b border-grey">
                <h3>Informacje dodatkowe</h3>
            </div>            

            <div class="flex -mx-4">
                <div class="form-group w-1/3 px-4">
                    <input type="checkbox" name="furnished" id="furnished">
                    <label for="furnished">Meble</label>
                </div>
                <div class="form-group w-1/3 px-4">
                    <input type="checkbox" name="living_room" id="living_room">
                    <label for="living_room">Salon</label>
                </div>
                <div class="form-group w-1/3 px-4">
                    <input type="checkbox" name="parking" id="parking">
                    <label for="parking">Parking</label>
                </div>
            </div>
            <div class="flex -mx-4">
                <div class="form-group w-1/3 px-4">
                    <input type="checkbox" name="furnished" id="furnished">
                    <label for="furnished">Internet</label>
                </div>
            </div>

            <div class="mb-4 pb-1 border-b border-grey">
                <h3>Desired tenetant</h3>
            </div>

            <div class="flex -mx-4">
                <div class="form-group w-1/3 px-4">
                    <label for="gender">Płeć</label>
                    <select name="gender" id="gender">
                        <option value="N">Brak preferencji</option>
                        <option value="N">Kobieta</option>
                        <option value="N">Męszczyzna</option>
                    </select>
                </div>
                
                <div class="form-group w-1/3 px-4">
                    <label for="ocupation">Zatrudnienie</label>
                    <select name="ocupation" id="ocupation">
                        <option value="N">Brak preferencji</option>
                        <option value="N">Student</option>
                        <option value="N">Zatrudniony</option>
                    </select>
                </div>
                <div class="form-group w-1/3 px-4">
                    <label for="minimum_age">Przedział wiekowy</label>
                    <select name="minimum_age" id="minimum_age">
                        <option value="N">Brak preferencji</option>
                        <option value="N">18 - 30</option>
                        <option value="N">31 - 50</option>
                        <option value="N">51+</option>
                    </select>
                </div>
            </div>
            <div class="flex -mx-4">
                <div class="form-group w-1/3 px-4">
                    <label for="minimum_age">Minimalny wiek</label>
                    <select name="minimum_age" id="minimum_age">
                        <option value="N">N</option>
                        <option value="N">M</option>
                        <option value="N">K</option>
                    </select>
                </div>
                
                <div class="form-group w-1/3 px-4">
                    <label for="maximum_age">Maksymalny wiek</label>
                    <select name="maximum_age" id="maximum_age">
                        <option value="N">N</option>
                        <option value="N">M</option>
                        <option value="N">K</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group w-1/3 px-4">
                <label for="couples">Pary</label>
                <input type="checkbox" name="couples" id="couples">
            </div>

            <div class="form-group w-1/3 px-4">
                <label for="pets">Zwierzeta</label>
                <input type="checkbox" name="pets" id="pets">
            </div>

            <div class="form-group w-1/3 px-4">
                <label for="smoking">Palacze</label>
                <input type="checkbox" name="smoking" id="smoking">
            </div>

            {{--

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