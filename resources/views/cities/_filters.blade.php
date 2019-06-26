<form action="{{ url()->full() }}" method="GET" class="form" name="advertFiltersForm">
    <section class="filter-group">
        <p class="filter-title">Zasięg wyszukiwania</p>
        <div class="form-group">
            <select name="radius" id="radius" class="form-control">
                <option value>0 km</option>
                <option value="5" {{ (request('radius') == 5) ? 'selected' : '' }}>5 km</option>
                <option value="10" {{ (request('radius') == 10) ? 'selected' : '' }}>10 km</option>
                <option value="15" {{ (request('radius') == 15) ? 'selected' : '' }}>15 km</option>
                <option value="25" {{ (request('radius') == 25) ? 'selected' : '' }}>25 km</option>
                <option value="50" {{ (request('radius') == 50) ? 'selected' : '' }}>50 km</option>
            </select>
        </div>
    </section>
    <section class="filter-group">
        <p class="filter-title">Czynsz</p>
        <div class="row">
            <div class="form-group col-6">
                <input type="number" name="rentmin" id="rentmin" class="form-control" placeholder="min" min="1" max="9999" value="{{ request('rentmin') }}">
            </div>
            <div class="form-group col-6">
                <input type="number" name="rentmax" id="rentmax" class="form-control" placeholder="max" min="1" max="9999" value="{{ request('rentmax') }}">
            </div>
        </div>
    </section>
    <section class="filter-group">
        <p class="filter-title">Długość pobytu</p>
        <div class="form-group row mb-2">
            <label for="minstay" class="col-4">min</label>
            <div class="col-8">
                <select name="minstay" id="minstay" class="form-control">
                    <option value>-</option>
                    <option value="1" {{ (request('minstay') == 1) ? 'selected' : '' }}>1 miesiąc</option>
                    <option value="2" {{ (request('minstay') == 2) ? 'selected' : '' }}>2 miesiące</option>
                    <option value="3" {{ (request('minstay') == 3) ? 'selected' : '' }}>3 miesiące</option>
                    <option value="4" {{ (request('minstay') == 4) ? 'selected' : '' }}>4 miesiące</option>
                    <option value="5" {{ (request('minstay') == 5) ? 'selected' : '' }}>5 miesięcy</option>
                    <option value="6" {{ (request('minstay') == 6) ? 'selected' : '' }}>6 miesięcy</option>
                    <option value="12" {{ (request('minstay') == 12) ? 'selected' : '' }}>1 rok</option>
                    <option value="15" {{ (request('minstay') == 15) ? 'selected' : '' }}>1 Rok i 3 miesiące</option>
                    <option value="18" {{ (request('minstay') == 18) ? 'selected' : '' }}>1 Rok i 6 miesięcy</option>
                    <option value="24" {{ (request('minstay') == 24) ? 'selected' : '' }}>2 lata</option>
                    <option value="36" {{ (request('minstay') == 36) ? 'selected' : '' }}>3 lata</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="maxstay" class="col-4">max</label>
            <div class="col-8">
                <select name="maxstay" id="maxstay" class="form-control">
                    <option value>-</option>
                    <option value="1" {{ (request('maxstay') == 1) ? 'selected' : '' }}>1 miesiąc</option>
                    <option value="2" {{ (request('maxstay') == 2) ? 'selected' : '' }}>2 miesiące</option>
                    <option value="3" {{ (request('maxstay') == 3) ? 'selected' : '' }}>3 miesiące</option>
                    <option value="4" {{ (request('maxstay') == 4) ? 'selected' : '' }}>4 miesiące</option>
                    <option value="5" {{ (request('maxstay') == 5) ? 'selected' : '' }}>5 miesięcy</option>
                    <option value="6" {{ (request('maxstay') == 6) ? 'selected' : '' }}>6 miesięcy</option>
                    <option value="12" {{ (request('maxstay') == 12) ? 'selected' : '' }}>1 rok</option>
                    <option value="15" {{ (request('maxstay') == 15) ? 'selected' : '' }}>1 Rok i 3 miesiące</option>
                    <option value="18" {{ (request('maxstay') == 18) ? 'selected' : '' }}>1 Rok i 6 miesięcy</option>
                    <option value="24" {{ (request('maxstay') == 24) ? 'selected' : '' }}>2 lata</option>
                    <option value="36" {{ (request('maxstay') == 36) ? 'selected' : '' }}>3 lata</option>
                </select>
            </div>
        </div>
    </section>
    <section class="filter-group">
        <p class="filter-title">Wielkość pokoju</p>
        <div class="custom-control custom-radio">
            <input type="radio" class="custom-control-input" name="roomsize" id="roomsize" value checked>
            <label for="roomsize" class="custom-control-label">Wszystkie</label>
        </div>
        <div class="custom-control custom-radio">
            <input type="radio" class="custom-control-input" name="roomsize" id="single" value="single" {{ (request('roomsize') == 'single') ? 'checked' : '' }}>
            <label for="single" class="custom-control-label">Jednoosobowy</label>
        </div>
        <div class="custom-control custom-radio">
            <input type="radio" class="custom-control-input" name="roomsize" id="double" value="double" {{ (request('roomsize') == 'double') ? 'checked' : '' }}>
            <label for="double" class="custom-control-label">Dwuosobowy</label>
        </div>
        <div class="custom-control custom-radio">
            <input type="radio" class="custom-control-input" name="roomsize" id="triple" value="triple" {{ (request('roomsize') == 'triple') ? 'checked' : '' }}>
            <label for="triple" class="custom-control-label">Trzyosobowy i więcej</label>
        </div>
    </section>
    <section class="filter-group">
        <p class="filter-title">Pokój dla</p>
        <div class="custom-control custom-radio">
            <input type="radio" class="custom-control-input" name="gender" id="gender" value checked>
            <label for="gender" class="custom-control-label">Bez znaczenia</label>
        </div>
        <div class="custom-control custom-radio">
            <input type="radio" class="custom-control-input" name="gender" id="female" value="f" {{ (request('gender') == 'f') ? 'checked' : '' }}>
            <label for="female" class="custom-control-label">Kobiety</label>
        </div>
        <div class="custom-control custom-radio">
            <input type="radio" class="custom-control-input" name="gender" id="male" value="m" {{ (request('gender') == 'm') ? 'checked' : '' }}>
            <label for="male" class="custom-control-label">Męszczyzny</label>
        </div>
        <div class="custom-control custom-checkbox mb-2">
            <input type="checkbox" name="couples" id="couples" value="1" class="custom-control-input" {{ request('couples') ? 'checked' : '' }}>
            <label for="couples" class="custom-control-label">Pary</label>
        </div>
    </section>
    <section class="filter-group">
        <p class="filter-title">Preferowany</p>
        <div class="custom-control custom-radio">
            <input type="radio" class="custom-control-input" name="occupation" id="occupation" value checked>
            <label for="occupation" class="custom-control-label">Bez znaczenia</label>
        </div>
        <div class="custom-control custom-radio">
            <input type="radio" class="custom-control-input" name="occupation" id="student" value="student" {{ request('occupation') == 'student' ? 'checked' : '' }}>
            <label for="student" class="custom-control-label">Student</label>
        </div>
        <div class="custom-control custom-radio">
            <input type="radio" class="custom-control-input" name="occupation" id="professional" value="professional" {{ request('occupation') == 'professional' ? 'checked' : '' }}>
            <label for="professional" class="custom-control-label">Pracujący</label>
        </div>
    </section>
    <section class="filter-group">
        <p class="filter-title">Wiek</p>
        <div class="row">
            <div class="form-group col-6">
                <input type="number" name="agemin" id="agemin" class="form-control" placeholder="min" value="{{ request('agemin') }}">
            </div>
            <div class="form-group col-6">
                <input type="number" name="agemax" id="agemax" class="form-control" placeholder="max" value="{{ request('agemax') }}">
            </div>
        </div>
    </section>
    <section class="filter-group">
        <p class="filter-title">Wolny od</p>
        <div class="form-group">
            <select name="availability" id="availability" class="form-control">
                <option value>-</option>
                <option value="now" {{ request('availability') == 'now' ? 'selected' : '' }}>Od zaraz</option>
                <option value="30" {{ request('availability') == 30 ? 'selected' : '' }}>W ciągu miesiąca</option>
                <option value="90" {{ request('availability') == 90 ? 'selected' : '' }}>W ciągu 90 dni</option>
            </select>
        </div>
    </section>
    <section class="filter-group">
        <p class="filter-title">Inne</p>
        <div class="custom-control custom-radio">
            <input type="radio" class="custom-control-input" name="smoking" id="smoking" value checked>
            <label for="smoking" class="custom-control-label">Dla palących/niepalących</label>
        </div>
        <div class="custom-control custom-radio">
            <input type="radio" class="custom-control-input" name="smoking" id="nonsmokers" value="nonsmokers" {{ request('smoking') == 'nonsmokers' ? 'checked' : '' }}>
            <label for="nonsmokers" class="custom-control-label">Dla niepalących</label>
        </div>
        <div class="custom-control custom-radio">
            <input type="radio" class="custom-control-input" name="smoking" id="smokers" value="smokers" {{ request('smoking') == 'smokers' ? 'checked' : '' }}>
            <label for="smokers" class="custom-control-label">Dla palących</label>
        </div>
        <div class="custom-control custom-checkbox mb-2">
            <input type="checkbox" name="pets" id="pets" class="custom-control-input" value="1" {{ request('pets') ? 'checked' : '' }}>
            <label for="pets" class="custom-control-label">Zwierzęta akceptowane</label>
        </div>
        <div class="custom-control custom-checkbox mb-2">
            <input type="checkbox" name="parking" id="parking" class="custom-control-input" value="1" {{ request('parking') ? 'checked' : '' }}>
            <label for="parking" class="custom-control-label">Miejsce parkingowe</label>
        </div>
    </section>

    @if(request()->filled('sort'))
        <input type="hidden" name="sort" value="{{ request('sort') }}">
    @endif
    <button type="submit" class="btn btn-outline-primary">Szukaj</button>
</form>