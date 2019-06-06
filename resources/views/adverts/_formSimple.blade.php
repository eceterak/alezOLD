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
    <image-upload-form :temp="{{ 123 }}"></image-upload-form>
    <h5 class="card-title pb-1 border-bottom">Lokalizacja</h5>
    @if(isset($advert->city))
        <div class="row">
            <div class="col-6">
                <label for="city_id">Miasto*</label>
                <input type="text" value="{{ $advert->city->name }}" disabled>
                <input type="hidden" name="city_id" value="{{ $advert->city->id }}">
            </div>
            <div class="col-6">
                <label for="street_id">Ulica</label>
                <input type="text" value="{{ (isset($advert->street)) ? $advert->street->name : '' }}" disabled>
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
            <label for="room_size">Wielkość pokoju</label>
            <select name="room_size" id="room_size" class="form-control">
                <option value>wybierz</option>
                <option value="single" {{ (isset($advert)) ? ($advert->room_size == 'single') ? 'selected' : '' :  (old('room_size') == 'single') ? 'selected' : '' }}>jednoosobowy</option>
                <option value="double" {{ (isset($advert)) ? ($advert->room_size == 'double') ? 'selected' : '' :  (old('room_size') == 'double') ? 'selected' : '' }}>dwuosobowy</option>
                <option value="triple" {{ (isset($advert)) ? ($advert->room_size == 'triple') ? 'selected' : '' :  (old('room_size') == 'triple') ? 'selected' : '' }}>trzyosobowy lub większy</option>
            </select>
        </div>
        <div class="form-group col-4">
            <label for="available_from">Dostępność od</label>
            <input type="text" name="available_from" id="available_from" class="form-control" value="{{ (isset($advert)) ? $advert->available_from :  old('available_from') }}" autocomplete="off">
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