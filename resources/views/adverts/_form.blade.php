<form action="{{ route(...$route) }}" method="POST" name="{{ $name }}" id="advert-form-va" enctype="multipart/form-data">
    @csrf
    @method($method)
    <h5 class="card-title pb-1 border-bottom">Informacje podstawowe</h5>
    <div class="form-group">
        <label for="title">Tytuł ogłoszenia*</label>
        <input type="text" name="title" id="title" class="form-control" value="{{ (isset($advert)) ? $advert->title :  old('title') }}" data-validation-length="min:5" data-validation-name="Tytuł" data-validation-rqmessage="Tytuł jest wymagany" required>
    </div>
    <div class="row">
        <div class="form-group col-4">
            <label for="rent">Czynsz*</label>
            <div class="row">
                <div class="col-10">
                    <input type="number" name="rent" id="rent" class="form-control" value="{{ (isset($advert)) ? $advert->rent :  old('rent') }}" data-validation-range="min:100" required>
                </div>
                <div class="d-flex align-items-end col-2 pl-0">
                    <span class="self-end">zł</span>
                </div>
            </div>
        </div>
        <div class="form-group col-4">
            <label for="rent">Opłaty dodatkowe</label>
            <div class="row">
                    <div class="col-10">
                    <input type="number" name="bills" id="bills" class="form-control" value="{{ (isset($advert)) ? $advert->bills :  old('bills') }}" placeholder="0">
                </div>
                <div class="d-flex align-items-end col-2 pl-0">
                    <span class="self-end">zł</span>
                </div>
            </div>
        </div>
        <div class="form-group col-4">
            <label for="rent">Kaucja</label>
            <div class="row">
                    <div class="col-10">
                    <input type="number" name="deposit" id="deposit" class="form-control" value="{{ (isset($advert)) ? $advert->deposit :  old('deposit') }}" placeholder="0">
                </div>
                <div class="d-flex align-items-end col-2 pl-0">
                    <span class="self-end">zł</span>
                </div>
            </div>
        </div>
    </div>
    <h5 class="card-title pb-1 border-bottom">Zdjęcia</h5>
    @isset($advert)
        <image-upload-form :advert="{{ $advert }}"></image-upload-form>
    @else
        <image-upload-form></image-upload-form>
    @endisset
    <h5 class="card-title pb-1 border-bottom">Lokalizacja</h5>
    @if(isset($advert->city))
        <div class="row">
            <div class="form-group col-6">
                <label for="city_id">Miasto*</label>
                <input type="text" value="{{ $advert->city->name }}" class="form-control" disabled>
                <input type="hidden" name="city_id" value="{{ $advert->city->id }}">
            </div>
            <div class="form-group col-6">
                <label for="street_id">Ulica</label>
                <input type="text" value="{{ (isset($advert->street)) ? $advert->street->name : '' }}" class="form-control" disabled>
                <input type="hidden" value="{{ (isset($advert->street)) ? $advert->street->id : '' }}">
            </div>
        </div>
    @else
        <div class="row">
            <div class="form-group col-6">
                <label for="city_id">Miasto*</label>
                <select name="city_id" id="city_id" class="d-none"></select>
            </div>
            <div class="form-group col-6">
                <label for="street_id">Ulica</label>
                <select name="street_id" id="street_id" class="d-none"></select>
            </div>
        </div>
    @endif
    <h5 class="card-title pb-1 border-bottom">Informacje szczegółowe</h5>
    <div class="form-group">
        <label for="description">Opis*</label>
        <textarea name="description" id="description" class="form-control" data-validation-length="min:30" rows="5" required>{{ (isset($advert)) ? $advert->description :  old('description') }}</textarea>
    </div>
    <div class="row">
        <div class="form-group col-4">
            <label for="room_size">Wielkość pokoju</label>
            <select name="room_size" id="room_size" class="form-control">
                <option value>wybierz</option>
                <option value="single" {{ (isset($advert)) ? ($advert->room_size == 'single') ? 'selected' : '' :  (old('room_size') == 'single') ? 'selected' : '' }}>jednoosobowy</option>
                <option value="double" {{ (isset($advert)) ? ($advert->room_size == 'double') ? 'selected' : '' :  (old('room_size') == 'double') ? 'selected' : '' }}>dwuosobowy</option>
                <option value="triple" {{ (isset($advert)) ? ($advert->room_size == 'triple') ? 'selected' : '' :  (old('room_size') == 'triple') ? 'selected' : '' }}>trzyosobowy lub większy</option>
            </select>
        </div>
        <div class="form-group col-4">
            <label for="property_type">Rodzaj zabudowy</label>
            <select name="property_type" id="property_type" class="form-control">
                <option value>wybierz</option>
                <option value="block" {{ (isset($advert)) ? ($advert->property_type == 'block') ? 'selected' : '' :  (old('property_type') == 'block') ? 'selected' : '' }}>Blok</option>
                <option value="house" {{ (isset($advert)) ? ($advert->property_type == 'house') ? 'selected' : '' :  (old('property_type') == 'house') ? 'selected' : '' }}>Dom wolnostojący</option>
                <option value="tenement" {{ (isset($advert)) ? ($advert->property_type == 'tenement') ? 'selected' : '' :  (old('property_type') == 'tenement') ? 'selected' : '' }}>Kamienica</option>
                <option value="apartment" {{ (isset($advert)) ? ($advert->property_type == 'apartment') ? 'selected' : '' :  (old('property_type') == 'apartment') ? 'selected' : '' }}>Apartamentowiec</option>
                <option value="loft" {{ (isset($advert)) ? ($advert->property_type == 'loft') ? 'selected' : '' :  (old('property_type') == 'loft') ? 'selected' : '' }}>Loft</option>
            </select>
        </div>
        <div class="form-group col-4">
            <label for="property_size">Ilość pokoi</label>
            <select name="property_size" id="property_size" class="form-control">
                @for($i = 1; $i < 13; $i++)
                    <option value="{{ $i }}" {{ (isset($advert)) ? ($advert->property_size == $i) ? 'selected' : '' :  (old('property_size') == $i) ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>
        </div>
    </div>
    <h5 class="card-title pb-1 border-bottom">Dostępność</h5>
    <div class="row">
        <div class="form-group col-4">
            <label for="available_from">Dostępność od</label>
            <input type="text" name="available_from" id="available_from" class="form-control" value="{{ (isset($advert)) ? $advert->available_from :  old('available_from') }}" autocomplete="off">
        </div>
        <div class="form-group col-4">
            <label for="minumum_stay">Minimalny czas pobytu</label>
            <select name="minimum_stay" id="minimum_stay" class="form-control">
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
        <div class="form-group col-4">
            <label for="maximum_stay">Maksymalny czas pobytu</label>
            <select name="maximum_stay" id="maximum_stay" class="form-control">
                <option value>Brak preferencji</option>
                <option value="1" {{ (isset($advert)) ? ($advert->maximum_stay == 1) ? 'selected' : '' :  (old('maximum_stay') == 1) ? 'selected' : '' }}>1 miesiąc</option>
                <option value="2" {{ (isset($advert)) ? ($advert->maximum_stay == 2) ? 'selected' : '' :  (old('maximum_stay') == 2) ? 'selected' : '' }}>2 miesiące</option>
                <option value="3" {{ (isset($advert)) ? ($advert->maximum_stay == 3) ? 'selected' : '' :  (old('maximum_stay') == 3) ? 'selected' : '' }}>3 miesiące</option>
                <option value="4" {{ (isset($advert)) ? ($advert->maximum_stay == 4) ? 'selected' : '' :  (old('maximum_stay') == 4) ? 'selected' : '' }}>4 miesiące</option>
                <option value="5" {{ (isset($advert)) ? ($advert->maximum_stay == 5) ? 'selected' : '' :  (old('maximum_stay') == 5) ? 'selected' : '' }}>5 miesięcy</option>
                <option value="6" {{ (isset($advert)) ? ($advert->maximum_stay == 6) ? 'selected' : '' :  (old('maximum_stay') == 6) ? 'selected' : '' }}>6 miesięcy</option>
                <option value="12" {{ (isset($advert)) ? ($advert->maximum_stay == 12) ? 'selected' : '' :  (old('maximum_stay') == 12) ? 'selected' : '' }}>1 rok</option>
                <option value="15" {{ (isset($advert)) ? ($advert->maximum_stay == 15) ? 'selected' : '' :  (old('maximum_stay') == 15) ? 'selected' : '' }}>1 Rok i 3 miesiące</option>
                <option value="18" {{ (isset($advert)) ? ($advert->maximum_stay == 18) ? 'selected' : '' :  (old('maximum_stay') == 18) ? 'selected' : '' }}>1 Rok i 6 miesięcy</option>
                <option value="24" {{ (isset($advert)) ? ($advert->maximum_stay == 24) ? 'selected' : '' :  (old('maximum_stay') == 24) ? 'selected' : '' }}>2 lata</option>
                <option value="36" {{ (isset($advert)) ? ($advert->maximum_stay == 36) ? 'selected' : '' :  (old('maximum_stay') == 36) ? 'selected' : '' }}>3 lata</option>
            </select>
        </div>
    </div>
    <h5 class="card-title pb-1 border-bottom">Informacje dodatkowe</h5>
    <div class="row mx-0">
        <div class="custom-control custom-checkbox col-4">
            <input type="checkbox" name="furnished" id="furnished" value="1" class="custom-control-input"  {{ (isset($advert)) ? ($advert->furnished) ? 'checked' : '' :  (old('furnished')) ? 'checked' : '' }}>
            <label for="furnished" class="custom-control-label">Meble</label>
        </div>
        <div class="custom-control custom-checkbox col-4">
            <input type="checkbox" name="living_room" id="living_room" value="1" class="custom-control-input"  {{ (isset($advert)) ? ($advert->living_room) ? 'checked' : '' :  (old('living_room')) ? 'checked' : '' }}>
            <label for="living_room" class="custom-control-label">Salon</label>
        </div>
        <div class="custom-control custom-checkbox col-4">
            <input type="checkbox" name="parking" id="parking" value="1" class="custom-control-input"  {{ (isset($advert)) ? ($advert->parking) ? 'checked' : '' :  (old('parking')) ? 'checked' : '' }}>
            <label for="parking" class="custom-control-label">Parking</label>
        </div>
    </div>
    <div class="row mx-0">
        <div class="custom-control custom-checkbox col-4">
            <input type="checkbox" name="broadband" id="broadband" value="1" class="custom-control-input"  {{ (isset($advert)) ? ($advert->broadband) ? 'checked' : '' :  (old('broadband')) ? 'checked' : '' }}>
            <label for="broadband" class="custom-control-label">Internet</label>
        </div>
    </div>
    <h5 class="card-title pb-1 border-bottom">Preferencje względem lokatora</h5>
    <div class="row">
        <div class="form-group col-4">
            <label for="gender">Płeć</label>
            <select name="gender" id="gender" class="form-control">
                <option value>Brak preferencji</option>
                <option value="f" {{ (isset($advert)) ? ($advert->gender == 'f') ? 'selected' : '' :  (old('gender') == 'f') ? 'selected' : '' }}>Kobieta</option>
                <option value="m" {{ (isset($advert)) ? ($advert->gender == 'm') ? 'selected' : '' :  (old('gender') == 'm') ? 'selected' : '' }}>Męszczyzna</option>
            </select>
        </div>
        <div class="form-group col-4">
            <label for="occupation">Zatrudnienie</label>
            <select name="occupation" id="occupation" class="form-control">
                <option value>Brak preferencji</option>
                <option value="student" {{ (isset($advert)) ? ($advert->occupation == 'student') ? 'selected' : '' :  (old('occupation') == 'student') ? 'selected' : '' }}>Student</option>
                <option value="professional" {{ (isset($advert)) ? ($advert->occupation == 'professional') ? 'selected' : '' :  (old('occupation') == 'professional') ? 'selected' : '' }}>Zatrudniony</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-4">
            <label for="minimum_age">Minimalny wiek</label>
            <select name="minimum_age" id="minimum_age" class="form-control">
                <option value>Brak preferencji</option>
                <option value="18">18</option>
            </select>
        </div>
        <div class="form-group col-4">
            <label for="maximum_age">Maksymalny wiek</label>
            <select name="maximum_age" id="maximum_age" class="form-control">
                <option value>N</option>
                <option value="99">99</option>
            </select>
        </div>
    </div>
    <div class="row mx-0">
        <div class="custom-control custom-checkbox col-4">
            <input type="checkbox" name="couples" id="couples" class="custom-control-input" value="1" {{ (isset($advert)) ? ($advert->couples) ? 'checked' : '' :  (old('couples')) ? 'checked' : '' }}>
            <label for="couples" class="custom-control-label">Pary</label>
        </div>
        <div class="custom-control custom-checkbox col-4">
            <input type="checkbox" name="pets" id="pets" value="1" class="custom-control-input" {{ (isset($advert)) ? ($advert->pets) ? 'checked' : '' :  (old('pets')) ? 'checked' : '' }}>
            <label for="pets" class="custom-control-label">Zwierzeta</label>
        </div>
        <div class="custom-control custom-checkbox col-4">
            <input type="checkbox" name="smoking" id="smoking" value="1" class="custom-control-input" {{ (isset($advert)) ? ($advert->smoking) ? 'checked' : '' :  (old('smoking')) ? 'checked' : '' }}>
            <label for="smoking" class="custom-control-label">Tylko dla niepalących</label>
        </div>
    </div>
    @if($method == 'POST')
        <div class="text-justify small my-4">
            <p>Dodając ogłoszenie ackeptuję <a href="{{ route('termsAndConditions') }}" target="_blank" rel="noopener noreferrer">Regulamin serwisu alez.pl.</a></p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc lacus mauris, sodales quis malesuada eleifend, consequat eget libero. Donec bibendum sagittis eleifend. Vestibulum diam turpis, sodales et eros eget, rhoncus vestibulum mauris. Vestibulum semper, lectus ut luctus sollicitudin, est lectus molestie magna, eu posuere nulla lacus a elit. Nulla quis imperdiet ligula. Suspendisse volutpat ac est quis convallis. Sed egestas neque sed lectus laoreet, non viverra urna consectetur. Suspendisse ut est non nisl interdum tincidunt. Suspendisse dignissim sapien volutpat purus tempus tincidunt. Nulla facilisi.
        </div>
    @endif
    <div class="text-center">
        <button type="submit" class="btn btn-primary">{{ $button }}</button>
    </div>
    @include('components._errors')
</form>