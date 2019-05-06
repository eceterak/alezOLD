<div class="card">
    <header>
        <h3>{{ $header }}</h3>
    </header>
    <div class="card-content">

        <form action="{{ route(...$route) }}" method="POST" name="{{ $name }}" class="form" id="room-form-va">
                
            @csrf
            @method($method)

            <div class="mb-4 pb-1 border-b border-grey">
                <h3>Informacje podstawowe</h3>
            </div>

            <div class="form-group">
                <label for="title">Tytuł ogłoszenia</label>
                <input type="text" name="title" id="title" value="{{ (isset($room)) ? $room->title :  old('title') }}" data-validation-length="min:3" data-validation-name="Tytuł" data-validation-rqmessage="Tytuł jest wymagany" required>
            </div>

            <div class="flex -mx-4">
                <div class="form-group w-1/3 px-4">
                    <label for="rent">Czynsz</label>
                    <div class="flex -mx-2">
                        <div class="w-2/3 px-2">
                            <input type="number" name="rent" id="rent" value="{{ (isset($room)) ? $room->rent :  old('rent') }}">
                        </div>
                        <div class="w-1/3 flex px-2">
                           <span class="self-end">zł</span>
                        </div>
                    </div>
                </div>

                <div class="form-group w-1/3 px-4">
                    <label for="rent">Opłaty dodatkowe</label>
                    <div class="flex -mx-2">
                        <div class="w-2/3 px-2">
                            <input type="number" name="bills" id="bills" value="{{ (isset($room)) ? $room->bills :  old('bills') }}">
                        </div>
                        <div class="w-1/3 flex px-2">
                            <span class="self-end">zł</span>
                        </div>
                    </div>
                </div>

                <div class="form-group w-1/3 px-4">
                    <label for="rent">Kaucja</label>
                    <div class="flex -mx-2">
                        <div class="w-2/3 px-2">
                            <input type="number" name="deposit" id="deposit" value="{{ (isset($room)) ? $room->deposit :  old('deposit') }}">
                        </div>
                        <div class="w-1/3 flex px-2">
                            <span class="self-end">zł</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex -mx-4">
                <div class="form-group w-1/3 px-4">
                    <label for="room_size">Wielkość pokoju</label>
                    <select name="room_size" id="room_size">
                        <option value>wybierz</option>
                        <option value="single" {{ (isset($room)) ? ($room->room_size == 'single') ? 'selected' : '' :  (old('room_size') == 'single') ? 'selected' : '' }}>jednoosobowy</option>
                        <option value="double" {{ (isset($room)) ? ($room->room_size == 'double') ? 'selected' : '' :  (old('room_size') == 'double') ? 'selected' : '' }}>dwuosobowy</option>
                        <option value="triple" {{ (isset($room)) ? ($room->room_size == 'triple') ? 'selected' : '' :  (old('room_size') == 'triple') ? 'selected' : '' }}>trzyosobowy i większy</option>
                    </select>
                </div>

                <div class="form-group w-1/3 px-4">
                    <label for="landlord">Jestem</label>
                    <select name="landlord" id="landlord">
                        <option value="live_in" {{ (isset($room)) ? ($room->landlord == 'live_in') ? 'selected' : '' :  (old('landlord') == 'live_in') ? 'selected' : '' }}>Właścicielem nieruchomości</option>
                        <option value="agent" {{ (isset($room)) ? ($room->landlord == 'agent') ? 'selected' : '' :  (old('landlord') == 'agent') ? 'selected' : '' }}>Pośrednikiem</option>
                    </select>
                </div>
            </div>

            <div class="mb-4 pb-1 border-b border-grey">
                <h3>Lokalizacja</h3>
             </div>
            
            @if(isset($room))
                <div class="flex -mx-4">
                    <div class="form-group w-1/2 px-4">
                        <label for="city_id">Miasto</label>
                        <input type="text" value="{{ $room->city->name }}" disabled>
                        <input type="hidden" name="city_id" value="{{ $room->city->id }}">
                    </div>
                    <div class="form-group w-1/2 px-4">
                        <label for="street_id">Ulica</label>
                        <input type="text" value="{{ (isset($room->street->name)) ? $room->street->name : '' }}" disabled>
                        <input type="hidden" value="{{ (isset($room->street->id)) ? $room->street->id : '' }}">
                    </div>
                </div>
            @else
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
            @endif


            <div class="mb-4 pb-1 border-b border-grey">
                <h3>Informacje szczegółowe</h3>
            </div>

            <div class="form-group">
                <label for="description">Opis</label>
                <textarea name="description" id="description">{{ (isset($room)) ? $room->description :  old('description') }}</textarea>
            </div>

            <div class="flex -mx-4">
                <div class="form-group w-1/3 px-4">
                    <label for="property_type">Rodzaj zabudowy</label>
                    <select name="property_type" id="property_type">
                        <option value>wybierz</option>
                        <option value="block" {{ (isset($room)) ? ($room->property_type == 'block') ? 'selected' : '' :  (old('property_type') == 'block') ? 'selected' : '' }}>Blok</option>
                        <option value="house" {{ (isset($room)) ? ($room->property_type == 'house') ? 'selected' : '' :  (old('property_type') == 'house') ? 'selected' : '' }}>Dom wolnostojący</option>
                        <option value="tenement" {{ (isset($room)) ? ($room->property_type == 'tenement') ? 'selected' : '' :  (old('property_type') == 'tenement') ? 'selected' : '' }}>Kamienica</option>
                        <option value="apartment" {{ (isset($room)) ? ($room->property_type == 'apartment') ? 'selected' : '' :  (old('property_type') == 'apartment') ? 'selected' : '' }}>Apartamentowiec</option>
                        <option value="loft" {{ (isset($room)) ? ($room->property_type == 'loft') ? 'selected' : '' :  (old('property_type') == 'loft') ? 'selected' : '' }}>Loft</option>
                    </select>
                </div>
                <div class="form-group w-1/3 px-4">
                    <label for="property_size">Ilość pokoi</label>
                    <select name="property_size" id="property_size">
                        @for($i = 1; $i < 13; $i++)
                            <option value="{{ $i }}" {{ (isset($room)) ? ($room->property_size == $i) ? 'selected' : '' :  (old('property_size') == $i) ? 'selected' : '' }}>{{ $i }}</option>
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
                    <input type="text" name="available_from" id="available_from" value="{{ (isset($room)) ? $room->available_from :  old('available_from') }}" autocomplete="off">
                </div>
                <div class="form-group w-1/3 px-4">
                    <label for="minumum_stay">Minimalny czas pobytu</label>
                    <select name="minimum_stay" id="minimum_stay">
                        <option value>Brak preferencji</option>
                        <option value="1" {{ (isset($room)) ? ($room->minimum_stay == 1) ? 'selected' : '' :  (old('minimum_stay') == 1) ? 'selected' : '' }}>1 miesiąc</option>
                        <option value="2" {{ (isset($room)) ? ($room->minimum_stay == 2) ? 'selected' : '' :  (old('minimum_stay') == 2) ? 'selected' : '' }}>2 miesiące</option>
                        <option value="3" {{ (isset($room)) ? ($room->minimum_stay == 3) ? 'selected' : '' :  (old('minimum_stay') == 3) ? 'selected' : '' }}>3 miesiące</option>
                        <option value="4" {{ (isset($room)) ? ($room->minimum_stay == 4) ? 'selected' : '' :  (old('minimum_stay') == 4) ? 'selected' : '' }}>4 miesiące</option>
                        <option value="5" {{ (isset($room)) ? ($room->minimum_stay == 5) ? 'selected' : '' :  (old('minimum_stay') == 5) ? 'selected' : '' }}>5 miesięcy</option>
                        <option value="6" {{ (isset($room)) ? ($room->minimum_stay == 6) ? 'selected' : '' :  (old('minimum_stay') == 6) ? 'selected' : '' }}>6 miesięcy</option>
                        <option value="12" {{ (isset($room)) ? ($room->minimum_stay == 12) ? 'selected' : '' :  (old('minimum_stay') == 12) ? 'selected' : '' }}>1 rok</option>
                        <option value="15" {{ (isset($room)) ? ($room->minimum_stay == 15) ? 'selected' : '' :  (old('minimum_stay') == 15) ? 'selected' : '' }}>1 Rok i 3 miesiące</option>
                        <option value="18" {{ (isset($room)) ? ($room->minimum_stay == 18) ? 'selected' : '' :  (old('minimum_stay') == 18) ? 'selected' : '' }}>1 Rok i 6 miesięcy</option>
                        <option value="24" {{ (isset($room)) ? ($room->minimum_stay == 24) ? 'selected' : '' :  (old('minimum_stay') == 24) ? 'selected' : '' }}>2 lata</option>
                        <option value="36" {{ (isset($room)) ? ($room->minimum_stay == 36) ? 'selected' : '' :  (old('minimum_stay') == 36) ? 'selected' : '' }}>3 lata</option>
                    </select>
                </div>
                <div class="form-group w-1/3 px-4">
                    <label for="maximum_stay">Maksymalny czas pobytu</label>
                    <select name="maximum_stay" id="maximum_stay">
                        <option value>Brak preferencji</option>
                        <option value="1" {{ (isset($room)) ? ($room->minimum_stay == 1) ? 'selected' : '' :  (old('minimum_stay') == 1) ? 'selected' : '' }}>1 miesiąc</option>
                        <option value="2" {{ (isset($room)) ? ($room->minimum_stay == 2) ? 'selected' : '' :  (old('minimum_stay') == 2) ? 'selected' : '' }}>2 miesiące</option>
                        <option value="3" {{ (isset($room)) ? ($room->minimum_stay == 3) ? 'selected' : '' :  (old('minimum_stay') == 3) ? 'selected' : '' }}>3 miesiące</option>
                        <option value="4" {{ (isset($room)) ? ($room->minimum_stay == 4) ? 'selected' : '' :  (old('minimum_stay') == 4) ? 'selected' : '' }}>4 miesiące</option>
                        <option value="5" {{ (isset($room)) ? ($room->minimum_stay == 5) ? 'selected' : '' :  (old('minimum_stay') == 5) ? 'selected' : '' }}>5 miesięcy</option>
                        <option value="6" {{ (isset($room)) ? ($room->minimum_stay == 6) ? 'selected' : '' :  (old('minimum_stay') == 6) ? 'selected' : '' }}>6 miesięcy</option>
                        <option value="12" {{ (isset($room)) ? ($room->minimum_stay == 12) ? 'selected' : '' :  (old('minimum_stay') == 12) ? 'selected' : '' }}>1 rok</option>
                        <option value="15" {{ (isset($room)) ? ($room->minimum_stay == 15) ? 'selected' : '' :  (old('minimum_stay') == 15) ? 'selected' : '' }}>1 Rok i 3 miesiące</option>
                        <option value="18" {{ (isset($room)) ? ($room->minimum_stay == 18) ? 'selected' : '' :  (old('minimum_stay') == 18) ? 'selected' : '' }}>1 Rok i 6 miesięcy</option>
                        <option value="24" {{ (isset($room)) ? ($room->minimum_stay == 24) ? 'selected' : '' :  (old('minimum_stay') == 24) ? 'selected' : '' }}>2 lata</option>
                        <option value="36" {{ (isset($room)) ? ($room->minimum_stay == 36) ? 'selected' : '' :  (old('minimum_stay') == 36) ? 'selected' : '' }}>3 lata</option>
                    </select>
                </div>
            </div>

            <div class="mb-4 pb-1 border-b border-grey">
                <h3>Informacje dodatkowe</h3>
            </div>            

            <div class="flex -mx-4">
                <div class="form-group w-1/3 px-4">
                    <input type="checkbox" name="furnished" id="furnished" value="1" {{ (isset($room)) ? ($room->furnished) ? 'checked' : '' :  (old('furnished')) ? 'checked' : '' }}>
                    <label for="furnished">Meble</label>
                </div>
                <div class="form-group w-1/3 px-4">
                    <input type="checkbox" name="living_room" id="living_room" value="1" {{ (isset($room)) ? ($room->living_room) ? 'checked' : '' :  (old('living_room')) ? 'checked' : '' }}>
                    <label for="living_room">Salon</label>
                </div>
                <div class="form-group w-1/3 px-4">
                    <input type="checkbox" name="parking" id="parking" value="1" {{ (isset($room)) ? ($room->parking) ? 'checked' : '' :  (old('parking')) ? 'checked' : '' }}>
                    <label for="parking">Parking</label>
                </div>
            </div>
            <div class="flex -mx-4">
                <div class="form-group w-1/3 px-4">
                    <input type="checkbox" name="broadband" id="broadband" value="1" {{ (isset($room)) ? ($room->broadband) ? 'checked' : '' :  (old('broadband')) ? 'checked' : '' }}>
                    <label for="broadband">Internet</label>
                </div>
            </div>

            <div class="mb-4 pb-1 border-b border-grey">
                <h3>Desired tenetant</h3>
            </div>

            <div class="flex -mx-4">
                <div class="form-group w-1/3 px-4">
                    <label for="gender">Płeć</label>
                    <select name="gender" id="gender">
                        <option value>Brak preferencji</option>
                        <option value="f" {{ (isset($room)) ? ($room->gender == 'f') ? 'selected' : '' :  (old('gender') == 'f') ? 'selected' : '' }}>Kobieta</option>
                        <option value="m" {{ (isset($room)) ? ($room->gender == 'm') ? 'selected' : '' :  (old('gender') == 'm') ? 'selected' : '' }}>Męszczyzna</option>
                    </select>
                </div>
                <div class="form-group w-1/3 px-4">
                    <label for="ocupation">Zatrudnienie</label>
                    <select name="ocupation" id="ocupation">
                        <option value="N">Brak preferencji</option>
                        <option value="student" {{ (isset($room)) ? ($room->ocupation == 'student') ? 'selected' : '' :  (old('ocupation') == 'student') ? 'selected' : '' }}>Student</option>
                        <option value="professional" {{ (isset($room)) ? ($room->ocupation == 'professional') ? 'selected' : '' :  (old('ocupation') == 'professional') ? 'selected' : '' }}>Zatrudniony</option>
                    </select>
                </div>
                <div class="form-group w-1/3 px-4">
                    <label for="minimum_age">Przedział wiekowy</label>
                    <select name="minimum_age" id="minimum_age">
                        <option value>Brak preferencji</option>
                        <option value="18">18</option>
                        <option value="N">31 - 50</option>
                        <option value="N">51+</option>
                    </select>
                </div>
            </div>
            <div class="form-group w-1/3 px-4">
                <label for="maximum_age">Maksymalny wiek</label>
                <select name="maximum_age" id="maximum_age">
                    <option value>N</option>
                    <option value="99">99</option>
                    <option value="N">K</option>
                </select>
            </div>
            
            <div class="form-group w-1/3 px-4">
                <label for="couples">Pary</label>
                <input type="checkbox" name="couples" id="couples" value="1" {{ (isset($room)) ? ($room->couples) ? 'checked' : '' :  (old('couples')) ? 'checked' : '' }}>
            </div>

            <div class="form-group w-1/3 px-4">
                <label for="pets">Zwierzeta</label>
                <input type="checkbox" name="pets" id="pets" value="1" {{ (isset($room)) ? ($room->pets) ? 'checked' : '' :  (old('pets')) ? 'checked' : '' }}>
            </div>

            <div class="form-group w-1/3 px-4">
                <label for="smoking">Palacze</label>
                <input type="checkbox" name="smoking" id="smoking" value="1" {{ (isset($room)) ? ($room->smoking) ? 'checked' : '' :  (old('smoking')) ? 'checked' : '' }}>
            </div>
            
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