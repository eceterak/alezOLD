<form action="{{ route(...$route) }}" method="POST" name="{{ $name }}" class="form" id="advert-form-va" enctype="multipart/form-data">  
    @csrf
    @method($method)
    <div class="mb-4 pb-1 border-b border-grey">
        <h3>Informacje podstawowe</h3>
    </div>
    <div class="form-group">
        <label for="title">Tytuł ogłoszenia*</label>
        <input type="text" name="title" id="title" value="{{ (isset($advert)) ? $advert->title :  old('title') }}" data-validation-length="min:5" data-validation-name="Tytuł" data-validation-rqmessage="Tytuł jest wymagany" required>
    </div>
    <div class="flex -mx-4">
        <div class="form-group w-1/3 px-4">
            <label for="rent">Czynsz*</label>
            <div class="flex -mx-2">
                <div class="w-2/3 px-2">
                    <input type="number" name="rent" id="rent" value="{{ (isset($advert)) ? $advert->rent :  old('rent') }}" data-validation-range="min:100" required>
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
                    <input type="number" name="bills" id="bills" value="{{ (isset($advert)) ? $advert->bills :  old('bills') }}" placeholder="0">
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
                    <input type="number" name="deposit" id="deposit" value="{{ (isset($advert)) ? $advert->deposit :  old('deposit') }}" placeholder="0">
                </div>
                <div class="w-1/3 flex px-2">
                    <span class="self-end">zł</span>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="flex -mx-4">
        <div class="form-group w-1/3 px-4">
            <label for="room_size">Wielkość pokoju</label>
            <select name="room_size" id="room_size">
                <option value>wybierz</option>
                <option value="single" {{ (isset($advert)) ? ($advert->room_size == 'single') ? 'selected' : '' :  (old('room_size') == 'single') ? 'selected' : '' }}>jednoosobowy</option>
                <option value="double" {{ (isset($advert)) ? ($advert->room_size == 'double') ? 'selected' : '' :  (old('room_size') == 'double') ? 'selected' : '' }}>dwuosobowy</option>
            </select>
        </div>
    </div> --}}
    <div class="mb-4 pb-1 border-b border-grey">
        <h3>Zdjęcia</h3>
    </div>
    <image-upload-form :temp=" {{ 123 }}"></image-upload-form>
    <div class="mb-4 pb-1 border-b border-grey">
        <h3>Lokalizacja</h3>
    </div>
    @if(isset($advert->city))
        <div class="flex -mx-4">
            <div class="form-group w-1/2 px-4">
                <label for="city_id">Miasto*</label>
                <input type="text" value="{{ $advert->city->name }}" disabled>
                <input type="hidden" name="city_id" value="{{ $advert->city->id }}">
            </div>
            <div class="form-group w-1/2 px-4">
                <label for="street_id">Ulica</label>
                <input type="text" value="{{ (isset($advert->street)) ? $advert->street->name : '' }}" disabled>
                <input type="hidden" value="{{ (isset($advert->street)) ? $advert->street->id : '' }}">
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
        <label for="description">Opis*</label>
        <textarea name="description" id="description" data-validation-length="min:30" required>{{ (isset($advert)) ? $advert->description :  old('description') }}</textarea>
    </div>
    <div class="flex -mx-4">
        <div class="form-group w-1/3 px-4">
            <label for="property_type">Rodzaj zabudowy</label>
            <select name="property_type" id="property_type">
                <option value>wybierz</option>
                <option value="block" {{ (isset($advert)) ? ($advert->property_type == 'block') ? 'selected' : '' :  (old('property_type') == 'block') ? 'selected' : '' }}>Blok</option>
                <option value="house" {{ (isset($advert)) ? ($advert->property_type == 'house') ? 'selected' : '' :  (old('property_type') == 'house') ? 'selected' : '' }}>Dom wolnostojący</option>
                <option value="tenement" {{ (isset($advert)) ? ($advert->property_type == 'tenement') ? 'selected' : '' :  (old('property_type') == 'tenement') ? 'selected' : '' }}>Kamienica</option>
                <option value="apartment" {{ (isset($advert)) ? ($advert->property_type == 'apartment') ? 'selected' : '' :  (old('property_type') == 'apartment') ? 'selected' : '' }}>Apartamentowiec</option>
                <option value="loft" {{ (isset($advert)) ? ($advert->property_type == 'loft') ? 'selected' : '' :  (old('property_type') == 'loft') ? 'selected' : '' }}>Loft</option>
            </select>
        </div>
        <div class="form-group w-1/3 px-4">
            <label for="property_size">Ilość pokoi</label>
            <select name="property_size" id="property_size">
                @for($i = 1; $i < 13; $i++)
                    <option value="{{ $i }}" {{ (isset($advert)) ? ($advert->property_size == $i) ? 'selected' : '' :  (old('property_size') == $i) ? 'selected' : '' }}>{{ $i }}</option>
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
            <input type="text" name="available_from" id="available_from" value="{{ (isset($advert)) ? $advert->available_from :  old('available_from') }}" autocomplete="off">
        </div>
        <div class="form-group w-1/3 px-4">
            <label for="minumum_stay">Minimalny czas pobytu</label>
            <select name="minimum_stay" id="minimum_stay">
                <option value>Brak preferencji</option>
                <option value="1" {{ (isset($advert)) ? ($advert->minimum_stay == 1) ? 'selected' : '' :  (old('minimum_stay') == 1) ? 'selected' : '' }}>1 miesiąc</option>
                <option value="2" {{ (isset($advert)) ? ($advert->minimum_stay == 2) ? 'selected' : '' :  (old('minimum_stay') == 2) ? 'selected' : '' }}>2 miesiące</option>
                <option value="3" {{ (isset($advert)) ? ($advert->minimum_stay == 3) ? 'selected' : '' :  (old('minimum_stay') == 3) ? 'selected' : '' }}>3 miesiące</option>
                <option value="4" {{ (isset($advert)) ? ($advert->minimum_stay == 4) ? 'selected' : '' :  (old('minimum_stay') == 4) ? 'selected' : '' }}>4 miesiące</option>
                <option value="5" {{ (isset($advert)) ? ($advert->minimum_stay == 5) ? 'selected' : '' :  (old('minimum_stay') == 5) ? 'selected' : '' }}>5 miesięcy</option>
                <option value="6" {{ (isset($advert)) ? ($advert->minimum_stay == 6) ? 'selected' : '' :  (old('minimum_stay') == 6) ? 'selected' : '' }}>6 miesięcy</option>
                <option value="12" {{ (isset($advert)) ? ($advert->minimum_stay == 12) ? 'selected' : '' :  (old('minimum_stay') == 12) ? 'selected' : '' }}>1 rok</option>
                <option value="15" {{ (isset($advert)) ? ($advert->minimum_stay == 15) ? 'selected' : '' :  (old('minimum_stay') == 15) ? 'selected' : '' }}>1 Rok i 3 miesiące</option>
                <option value="18" {{ (isset($advert)) ? ($advert->minimum_stay == 18) ? 'selected' : '' :  (old('minimum_stay') == 18) ? 'selected' : '' }}>1 Rok i 6 miesięcy</option>
                <option value="24" {{ (isset($advert)) ? ($advert->minimum_stay == 24) ? 'selected' : '' :  (old('minimum_stay') == 24) ? 'selected' : '' }}>2 lata</option>
                <option value="36" {{ (isset($advert)) ? ($advert->minimum_stay == 36) ? 'selected' : '' :  (old('minimum_stay') == 36) ? 'selected' : '' }}>3 lata</option>
            </select>
        </div>
        <div class="form-group w-1/3 px-4">
            <label for="maximum_stay">Maksymalny czas pobytu</label>
            <select name="maximum_stay" id="maximum_stay">
                <option value>Brak preferencji</option>
                <option value="1" {{ (isset($advert)) ? ($advert->minimum_stay == 1) ? 'selected' : '' :  (old('minimum_stay') == 1) ? 'selected' : '' }}>1 miesiąc</option>
                <option value="2" {{ (isset($advert)) ? ($advert->minimum_stay == 2) ? 'selected' : '' :  (old('minimum_stay') == 2) ? 'selected' : '' }}>2 miesiące</option>
                <option value="3" {{ (isset($advert)) ? ($advert->minimum_stay == 3) ? 'selected' : '' :  (old('minimum_stay') == 3) ? 'selected' : '' }}>3 miesiące</option>
                <option value="4" {{ (isset($advert)) ? ($advert->minimum_stay == 4) ? 'selected' : '' :  (old('minimum_stay') == 4) ? 'selected' : '' }}>4 miesiące</option>
                <option value="5" {{ (isset($advert)) ? ($advert->minimum_stay == 5) ? 'selected' : '' :  (old('minimum_stay') == 5) ? 'selected' : '' }}>5 miesięcy</option>
                <option value="6" {{ (isset($advert)) ? ($advert->minimum_stay == 6) ? 'selected' : '' :  (old('minimum_stay') == 6) ? 'selected' : '' }}>6 miesięcy</option>
                <option value="12" {{ (isset($advert)) ? ($advert->minimum_stay == 12) ? 'selected' : '' :  (old('minimum_stay') == 12) ? 'selected' : '' }}>1 rok</option>
                <option value="15" {{ (isset($advert)) ? ($advert->minimum_stay == 15) ? 'selected' : '' :  (old('minimum_stay') == 15) ? 'selected' : '' }}>1 Rok i 3 miesiące</option>
                <option value="18" {{ (isset($advert)) ? ($advert->minimum_stay == 18) ? 'selected' : '' :  (old('minimum_stay') == 18) ? 'selected' : '' }}>1 Rok i 6 miesięcy</option>
                <option value="24" {{ (isset($advert)) ? ($advert->minimum_stay == 24) ? 'selected' : '' :  (old('minimum_stay') == 24) ? 'selected' : '' }}>2 lata</option>
                <option value="36" {{ (isset($advert)) ? ($advert->minimum_stay == 36) ? 'selected' : '' :  (old('minimum_stay') == 36) ? 'selected' : '' }}>3 lata</option>
            </select>
        </div>
    </div>
    <div class="mb-4 pb-1 border-b border-grey">
        <h3>Informacje dodatkowe</h3>
    </div>            
    <div class="flex -mx-4">
        <div class="form-group w-1/3 px-4">
            <input type="checkbox" name="furnished" id="furnished" value="1" {{ (isset($advert)) ? ($advert->furnished) ? 'checked' : '' :  (old('furnished')) ? 'checked' : '' }}>
            <label for="furnished">Meble</label>
        </div>
        <div class="form-group w-1/3 px-4">
            <input type="checkbox" name="living_advert" id="living_advert" value="1" {{ (isset($advert)) ? ($advert->living_advert) ? 'checked' : '' :  (old('living_advert')) ? 'checked' : '' }}>
            <label for="living_advert">Salon</label>
        </div>
        <div class="form-group w-1/3 px-4">
            <input type="checkbox" name="parking" id="parking" value="1" {{ (isset($advert)) ? ($advert->parking) ? 'checked' : '' :  (old('parking')) ? 'checked' : '' }}>
            <label for="parking">Parking</label>
        </div>
    </div>
    <div class="flex -mx-4">
        <div class="form-group w-1/3 px-4">
            <input type="checkbox" name="broadband" id="broadband" value="1" {{ (isset($advert)) ? ($advert->broadband) ? 'checked' : '' :  (old('broadband')) ? 'checked' : '' }}>
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
                <option value="f" {{ (isset($advert)) ? ($advert->gender == 'f') ? 'selected' : '' :  (old('gender') == 'f') ? 'selected' : '' }}>Kobieta</option>
                <option value="m" {{ (isset($advert)) ? ($advert->gender == 'm') ? 'selected' : '' :  (old('gender') == 'm') ? 'selected' : '' }}>Męszczyzna</option>
            </select>
        </div>
        <div class="form-group w-1/3 px-4">
            <label for="ocupation">Zatrudnienie</label>
            <select name="ocupation" id="ocupation">
                <option value="N">Brak preferencji</option>
                <option value="student" {{ (isset($advert)) ? ($advert->ocupation == 'student') ? 'selected' : '' :  (old('ocupation') == 'student') ? 'selected' : '' }}>Student</option>
                <option value="professional" {{ (isset($advert)) ? ($advert->ocupation == 'professional') ? 'selected' : '' :  (old('ocupation') == 'professional') ? 'selected' : '' }}>Zatrudniony</option>
            </select>
        </div>
        <div class="form-group w-1/3 px-4">
            <label for="minimum_age">Minimalny wiek</label>
            <select name="minimum_age" id="minimum_age">
                <option value>Brak preferencji</option>
                <option value="18">18</option>
            </select>
        </div>
    </div>
    <div class="flex -mx-4">
        <div class="form-group w-1/3 px-4">
            <label for="maximum_age">Maksymalny wiek</label>
            <select name="maximum_age" id="maximum_age">
                <option value>N</option>
                <option value="99">99</option>
            </select>
        </div>
    </div>
    <div class="flex -mx-4">
        <div class="form-group w-1/3 px-4">
            <input type="checkbox" name="couples" id="couples" value="1" {{ (isset($advert)) ? ($advert->couples) ? 'checked' : '' :  (old('couples')) ? 'checked' : '' }}>
            <label for="couples">Pary</label>
        </div>
        <div class="form-group w-1/3 px-4">
            <input type="checkbox" name="pets" id="pets" value="1" {{ (isset($advert)) ? ($advert->pets) ? 'checked' : '' :  (old('pets')) ? 'checked' : '' }}>
            <label for="pets">Zwierzeta</label>
        </div>
        <div class="form-group w-1/3 px-4">
            <input type="checkbox" name="smoking" id="smoking" value="1" {{ (isset($advert)) ? ($advert->smoking) ? 'checked' : '' :  (old('smoking')) ? 'checked' : '' }}>
            <label for="smoking">Palacze</label>
        </div>
    </div>
    <div class="flex -mx-4">
        <div class="px-4 w-full">
            <p>Dodając ogłoszenie ackeptuję Regulamin serwisu alez.pl.</p>
        </div>
    </div>
    <div>
        <button type="submit" class="btn btn-reverse mt-4">{{ $button }}</button>
    </div>
    @include('components._errors')
</form>