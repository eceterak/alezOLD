<div class="modal fade" id="filters-modal" tabindex="-1" role="dialog" aria-labelledby="filtersModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Filtrowanie</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ url()->full() }}" method="GET" class="form" name="advertFiltersForm">
                    <section class="filter-group mt-2 mt-lg-0">
                        <p class="filter-title">Czynsz</p>
                        <div class="form-row">
                            <div class="form-group col-5 pl-">
                                <input type="number" name="rentmin" id="rentmin" class="form-control form-control-sm" placeholder="min" min="1" max="9999" value="{{ request('rentmin') }}">
                            </div>
                            <div class="col-2 d-flex justify-content-center">
                                <p class="text-center mb-0 align-self-end">do</p>
                            </div>
                            <div class="form-group col-5">
                                <input type="number" name="rentmax" id="rentmax" class="form-control form-control-sm" placeholder="max" min="1" max="9999" value="{{ request('rentmax') }}">
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
                        <p class="filter-title">Dostępność od</p>
                        <div class="form-group">
                            <select name="availability" id="availability" class="form-control form-control-sm">
                                <option value>-</option>
                                <option value="now" {{ request('availability') == 'now' ? 'selected' : '' }}>Od zaraz</option>
                                <option value="30" {{ request('availability') == 30 ? 'selected' : '' }}>W ciągu miesiąca</option>
                                <option value="90" {{ request('availability') == 90 ? 'selected' : '' }}>W ciągu 90 dni</option>
                            </select>
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
                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" name="gender" id="couples" value="couples" {{ (request('gender') == 'couples') ? 'checked' : '' }}>
                            <label for="couples" class="custom-control-label">Pary</label>
                        </div>
                    </section>
                    <section class="filter-group">
                        <p class="filter-title">Długość najmu</p>
                        <div class="form-group row mb-2">
                            <label for="staymin" class="col-4">min</label>
                            <div class="col-8">
                                <select name="staymin" id="staymin" class="form-control form-control-sm">
                                    <option value>-</option>
                                    <option value="1" {{ (request('staymin') == 1) ? 'selected' : '' }}>1 miesiąc</option>
                                    <option value="2" {{ (request('staymin') == 2) ? 'selected' : '' }}>2 miesiące</option>
                                    <option value="3" {{ (request('staymin') == 3) ? 'selected' : '' }}>3 miesiące</option>
                                    <option value="4" {{ (request('staymin') == 4) ? 'selected' : '' }}>4 miesiące</option>
                                    <option value="5" {{ (request('staymin') == 5) ? 'selected' : '' }}>5 miesięcy</option>
                                    <option value="6" {{ (request('staymin') == 6) ? 'selected' : '' }}>6 miesięcy</option>
                                    <option value="12" {{ (request('staymin') == 12) ? 'selected' : '' }}>1 rok</option>
                                    <option value="15" {{ (request('staymin') == 15) ? 'selected' : '' }}>1 Rok i 3 miesiące</option>
                                    <option value="18" {{ (request('staymin') == 18) ? 'selected' : '' }}>1 Rok i 6 miesięcy</option>
                                    <option value="24" {{ (request('staymin') == 24) ? 'selected' : '' }}>2 lata</option>
                                    <option value="36" {{ (request('staymin') == 36) ? 'selected' : '' }}>3 lata</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="staymax" class="col-4">max</label>
                            <div class="col-8">
                                <select name="staymax" id="staymax" class="form-control form-control-sm">
                                    <option value>-</option>
                                    <option value="1" {{ (request('staymax') == 1) ? 'selected' : '' }}>1 miesiąc</option>
                                    <option value="2" {{ (request('staymax') == 2) ? 'selected' : '' }}>2 miesiące</option>
                                    <option value="3" {{ (request('staymax') == 3) ? 'selected' : '' }}>3 miesiące</option>
                                    <option value="4" {{ (request('staymax') == 4) ? 'selected' : '' }}>4 miesiące</option>
                                    <option value="5" {{ (request('staymax') == 5) ? 'selected' : '' }}>5 miesięcy</option>
                                    <option value="6" {{ (request('staymax') == 6) ? 'selected' : '' }}>6 miesięcy</option>
                                    <option value="12" {{ (request('staymax') == 12) ? 'selected' : '' }}>1 rok</option>
                                    <option value="15" {{ (request('staymax') == 15) ? 'selected' : '' }}>1 Rok i 3 miesiące</option>
                                    <option value="18" {{ (request('staymax') == 18) ? 'selected' : '' }}>1 Rok i 6 miesięcy</option>
                                    <option value="24" {{ (request('staymax') == 24) ? 'selected' : '' }}>2 lata</option>
                                    <option value="36" {{ (request('staymax') == 36) ? 'selected' : '' }}>3 lata</option>
                                </select>
                            </div>
                        </div>
                    </section>
                    <section class="filter-group">
                        <p class="filter-title">Wiek</p>
                        <div class="form-row">
                            <div class="form-group col-5">
                                <input type="number" name="agemin" id="agemin" class="form-control form-control-sm" placeholder="min" value="{{ request('agemin') }}">
                            </div>
                            <div class="col-2 d-flex justify-content-center">
                                <p class="text-center mb-0 align-self-end">do</p>
                            </div>
                            <div class="form-group col-5">
                                <input type="number" name="agemax" id="agemax" class="form-control form-control-sm" placeholder="max" value="{{ request('agemax') }}">
                            </div>
                        </div>
                    </section>
                    <section class="filter-group">
                        <p class="filter-title">Wyposażenie</p>
                        <div class="custom-control custom-checkbox mb-2">
                            <input type="checkbox" name="furnished" id="furnished" class="custom-control-input" value="1" {{ request('furnished') ? 'checked' : '' }}>
                            <label for="furnished" class="custom-control-label">Meble</label>
                        </div>
                        <div class="custom-control custom-checkbox mb-2">
                            <input type="checkbox" name="broadband" id="broadband" class="custom-control-input" value="1" {{ request('broadband') ? 'checked' : '' }}>
                            <label for="broadband" class="custom-control-label">Internet</label>
                        </div>
                        <div class="custom-control custom-checkbox mb-2">
                            <input type="checkbox" name="parking" id="parking" class="custom-control-input" value="1" {{ request('parking') ? 'checked' : '' }}>
                            <label for="parking" class="custom-control-label">Miejsce parkingowe</label>
                        </div>
                        <div class="custom-control custom-checkbox mb-2">
                            <input type="checkbox" name="living_room" id="living_room" class="custom-control-input" value="1" {{ request('living_room') ? 'checked' : '' }}>
                            <label for="living_room" class="custom-control-label">Wspólny salon</label>
                        </div>
                        <div class="custom-control custom-checkbox mb-2">
                            <input type="checkbox" name="garage" id="garage" class="custom-control-input" value="1" {{ request('garage') ? 'checked' : '' }}>
                            <label for="garage" class="custom-control-label">Garaż</label>
                        </div>
                        <div class="custom-control custom-checkbox mb-2">
                            <input type="checkbox" name="broadband" id="broadband" class="custom-control-input" value="1" {{ request('broadband') ? 'checked' : '' }}>
                            <label for="broadband" class="custom-control-label">Ogród</label>
                        </div>
                    </section>
                    <section class="filter-group">
                        <p class="filter-title">Inne</p>
                        <div class="custom-control custom-checkbox mb-2">
                            <input type="checkbox" class="custom-control-input" name="smoking" id="smoking" value="1" {{ request('smoking') == '1' ? 'checked' : '' }}>
                            <label for="smoking" class="custom-control-label">Dla palących</label>
                        </div>
                        <div class="custom-control custom-checkbox mb-2">
                            <input type="checkbox" name="pets" id="pets" class="custom-control-input" value="1" {{ request('pets') ? 'checked' : '' }}>
                            <label for="pets" class="custom-control-label">Zwierzęta akceptowane</label>
                        </div>
                    </section>
                
                    @if(request()->filled('sort'))
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                    @endif
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btn-block">Zatwierdź</button>
            </div>
        </div>
    </div>
</div>

{{-- <div class="py-6 py-lg-0">
    <div class="d-flex justify-content-between filters-header align-items-center">
        <p class="h5 m-0 my-lg-2">Filtrowanie</p>
        <button type="button" class="close d-md-none filters-hide" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <form action="{{ url()->full() }}" method="GET" class="form" name="advertFiltersForm">
        <section class="filter-group mt-2 mt-lg-0">
            <p class="filter-title">Czynsz</p>
            <div class="form-row">
                <div class="form-group col-5 pl-">
                    <input type="number" name="rentmin" id="rentmin" class="form-control form-control-sm" placeholder="min" min="1" max="9999" value="{{ request('rentmin') }}">
                </div>
                <div class="col-2 d-flex justify-content-center">
                    <p class="text-center mb-0 align-self-end">do</p>
                </div>
                <div class="form-group col-5">
                    <input type="number" name="rentmax" id="rentmax" class="form-control form-control-sm" placeholder="max" min="1" max="9999" value="{{ request('rentmax') }}">
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
            <p class="filter-title">Dostępność od</p>
            <div class="form-group">
                <select name="availability" id="availability" class="form-control form-control-sm">
                    <option value>-</option>
                    <option value="now" {{ request('availability') == 'now' ? 'selected' : '' }}>Od zaraz</option>
                    <option value="30" {{ request('availability') == 30 ? 'selected' : '' }}>W ciągu miesiąca</option>
                    <option value="90" {{ request('availability') == 90 ? 'selected' : '' }}>W ciągu 90 dni</option>
                </select>
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
            <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" name="gender" id="couples" value="couples" {{ (request('gender') == 'couples') ? 'checked' : '' }}>
                <label for="couples" class="custom-control-label">Pary</label>
            </div>
        </section>
        <section class="filter-group">
            <p class="filter-title">Długość najmu</p>
            <div class="form-group row mb-2">
                <label for="staymin" class="col-4">min</label>
                <div class="col-8">
                    <select name="staymin" id="staymin" class="form-control form-control-sm">
                        <option value>-</option>
                        <option value="1" {{ (request('staymin') == 1) ? 'selected' : '' }}>1 miesiąc</option>
                        <option value="2" {{ (request('staymin') == 2) ? 'selected' : '' }}>2 miesiące</option>
                        <option value="3" {{ (request('staymin') == 3) ? 'selected' : '' }}>3 miesiące</option>
                        <option value="4" {{ (request('staymin') == 4) ? 'selected' : '' }}>4 miesiące</option>
                        <option value="5" {{ (request('staymin') == 5) ? 'selected' : '' }}>5 miesięcy</option>
                        <option value="6" {{ (request('staymin') == 6) ? 'selected' : '' }}>6 miesięcy</option>
                        <option value="12" {{ (request('staymin') == 12) ? 'selected' : '' }}>1 rok</option>
                        <option value="15" {{ (request('staymin') == 15) ? 'selected' : '' }}>1 Rok i 3 miesiące</option>
                        <option value="18" {{ (request('staymin') == 18) ? 'selected' : '' }}>1 Rok i 6 miesięcy</option>
                        <option value="24" {{ (request('staymin') == 24) ? 'selected' : '' }}>2 lata</option>
                        <option value="36" {{ (request('staymin') == 36) ? 'selected' : '' }}>3 lata</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="staymax" class="col-4">max</label>
                <div class="col-8">
                    <select name="staymax" id="staymax" class="form-control form-control-sm">
                        <option value>-</option>
                        <option value="1" {{ (request('staymax') == 1) ? 'selected' : '' }}>1 miesiąc</option>
                        <option value="2" {{ (request('staymax') == 2) ? 'selected' : '' }}>2 miesiące</option>
                        <option value="3" {{ (request('staymax') == 3) ? 'selected' : '' }}>3 miesiące</option>
                        <option value="4" {{ (request('staymax') == 4) ? 'selected' : '' }}>4 miesiące</option>
                        <option value="5" {{ (request('staymax') == 5) ? 'selected' : '' }}>5 miesięcy</option>
                        <option value="6" {{ (request('staymax') == 6) ? 'selected' : '' }}>6 miesięcy</option>
                        <option value="12" {{ (request('staymax') == 12) ? 'selected' : '' }}>1 rok</option>
                        <option value="15" {{ (request('staymax') == 15) ? 'selected' : '' }}>1 Rok i 3 miesiące</option>
                        <option value="18" {{ (request('staymax') == 18) ? 'selected' : '' }}>1 Rok i 6 miesięcy</option>
                        <option value="24" {{ (request('staymax') == 24) ? 'selected' : '' }}>2 lata</option>
                        <option value="36" {{ (request('staymax') == 36) ? 'selected' : '' }}>3 lata</option>
                    </select>
                </div>
            </div>
        </section>
        <section class="filter-group">
            <p class="filter-title">Wiek</p>
            <div class="form-row">
                <div class="form-group col-5">
                    <input type="number" name="agemin" id="agemin" class="form-control form-control-sm" placeholder="min" value="{{ request('agemin') }}">
                </div>
                <div class="col-2 d-flex justify-content-center">
                    <p class="text-center mb-0 align-self-end">do</p>
                </div>
                <div class="form-group col-5">
                    <input type="number" name="agemax" id="agemax" class="form-control form-control-sm" placeholder="max" value="{{ request('agemax') }}">
                </div>
            </div>
        </section>
        <section class="filter-group">
            <p class="filter-title">Wyposażenie</p>
            <div class="custom-control custom-checkbox mb-2">
                <input type="checkbox" name="furnished" id="furnished" class="custom-control-input" value="1" {{ request('furnished') ? 'checked' : '' }}>
                <label for="furnished" class="custom-control-label">Meble</label>
            </div>
            <div class="custom-control custom-checkbox mb-2">
                <input type="checkbox" name="broadband" id="broadband" class="custom-control-input" value="1" {{ request('broadband') ? 'checked' : '' }}>
                <label for="broadband" class="custom-control-label">Internet</label>
            </div>
            <div class="custom-control custom-checkbox mb-2">
                <input type="checkbox" name="parking" id="parking" class="custom-control-input" value="1" {{ request('parking') ? 'checked' : '' }}>
                <label for="parking" class="custom-control-label">Miejsce parkingowe</label>
            </div>
            <div class="custom-control custom-checkbox mb-2">
                <input type="checkbox" name="living_room" id="living_room" class="custom-control-input" value="1" {{ request('living_room') ? 'checked' : '' }}>
                <label for="living_room" class="custom-control-label">Wspólny salon</label>
            </div>
            <div class="custom-control custom-checkbox mb-2">
                <input type="checkbox" name="garage" id="garage" class="custom-control-input" value="1" {{ request('garage') ? 'checked' : '' }}>
                <label for="garage" class="custom-control-label">Garaż</label>
            </div>
            <div class="custom-control custom-checkbox mb-2">
                <input type="checkbox" name="broadband" id="broadband" class="custom-control-input" value="1" {{ request('broadband') ? 'checked' : '' }}>
                <label for="broadband" class="custom-control-label">Ogród</label>
            </div>
        </section>
        <section class="filter-group">
            <p class="filter-title">Inne</p>
            <div class="custom-control custom-checkbox mb-2">
                <input type="checkbox" class="custom-control-input" name="smoking" id="smoking" value="1" {{ request('smoking') == '1' ? 'checked' : '' }}>
                <label for="smoking" class="custom-control-label">Dla palących</label>
            </div>
            <div class="custom-control custom-checkbox mb-2">
                <input type="checkbox" name="pets" id="pets" class="custom-control-input" value="1" {{ request('pets') ? 'checked' : '' }}>
                <label for="pets" class="custom-control-label">Zwierzęta akceptowane</label>
            </div>
        </section>
    
        @if(request()->filled('sort'))
            <input type="hidden" name="sort" value="{{ request('sort') }}">
        @endif

        <button type="submit" class="btn btn-primary d-none d-lg-block">Zatwierdź</button>

        <div class="d-lg-none bg-white fixed-bottom p-2 text-center border-top">
            <div class="row">
                <div class="col-6 border-right-1">
                    <button type="submit" class="btn btn-primary">Zatwierdź</button>
                </div>
                <div class="col-6">
                    <button type="submit" class="btn btn-secondary filters-hide">Anuluj</button>
                </div>
            </div>
        </div>
    </form>
</div> --}}