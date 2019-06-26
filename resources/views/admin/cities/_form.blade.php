<div class="card-body">
    <form action="{{ route(...$route) }}" method="POST" class="form">
        @csrf
        @method($method)
        <section class="form-section form-row">
            <div class="col-12 d-flex justify-content-between">
                <h5 class="form-title">Informacje podstawowe</h5>
                <button class="btn btn-primary btn-sm"><i class="fas fa-star"></i></button>
            </div>
            <div class="form-group col-12">
                <label for="name">Nazwa</label>
                <input type="text" name="name" id="name" value="{{ (isset($city)) ? $city->name :  old('name') }}" class="form-control text-base">
            </div>
        {{-- <div class="flex items-center -mx-4">
            <div class="input-group w-1/5 px-4">
                <input type="checkbox" name="suggested" id="suggested" {{ (isset($city)) ? ($city->suggested) ? 'checked' : '' :  (old('suggested')) ? 'checked' : '' }}>
                <label for="suggested">Sugerowane</label>
            </div>
        </div> --}}
            <div class="form-group col-6">
                <label for="type">Typ</label>
                <input type="text" name="type" value="{{ (isset($city)) ? $city->type :  old('type') }}" class="form-control">
            </div>
            <div class="form-group col-6">
                <label for="importance">Importance</label>
                <input type="number" name="importance" id="importance" value="{{ (isset($city)) ? $city->importance :  old('importance') }}" class="form-control">
            </div>
            <div class="form-group col-6">
                <label for="parent">Miasto nadrzędne</label>
                <input type="text" name="parent" id="parent" value="{{ (isset($city)) ? $city->parent :  old('parent') }}" class="form-control">
            </div>
            <div class="form-group col-6">
                <label for="community">Gmina</label>
                <input type="text" name="community" id="community" value="{{ (isset($city)) ? $city->community :  old('community') }}" class="form-control">
            </div>
            <div class="form-group col-6">
                <label for="county">Powiat</label>
                <input type="text" name="county" id="county" value="{{ (isset($city)) ? $city->county :  old('county') }}" class="form-control">
            </div>
            <div class="form-group col-6">
                <label for="state">Województwo</label>
                <input type="text" name="state" id="state" value="{{ (isset($city)) ? $city->state :  old('state') }}" class="form-control">
            </div>
        </section>
        <section class="form-section form-row">
            <h5 class="form-title col-12">Położenie geograficzne</h5>
            <div class="form-group col-6">
                <label for="lat">Latitiude</label>
                <input type="text" name="lat" id="lat" value="{{ (isset($city)) ? $city->lat :  old('lat') }}" class="form-control">
            </div>
            <div class="form-group col-6">
                <label for="lon">Longtitude</label>
                <input type="text" name="lon" id="lon" value="{{ (isset($city)) ? $city->lon :  old('lon') }}" class="form-control">
            </div>
        </section>
        <section class="form-section form-row">
            <h5 class="form-title col-12">Bounding Box</h5>
            <div class="form-group col-3">
                <label for="west">Zachód</label>
                <input type="text" name="west" id="west" value="{{ (isset($city)) ? $city->west :  old('west') }}" class="form-control">
            </div>
            <div class="form-group col-3">
                <label for="south">Południe</label>
                <input type="text" name="south" id="south" value="{{ (isset($city)) ? $city->south :  old('south') }}" class="form-control">
            </div>
            <div class="form-group col-3">
                <label for="east">Wschód</label>
                <input type="text" name="east" id="east" value="{{ (isset($city)) ? $city->east :  old('east') }}" class="form-control">
            </div>
            <div class="form-group col-3">
                <label for="north">Północ</label>
                <input type="text" name="north" id="north" value="{{ (isset($city)) ? $city->north :  old('north') }}" class="form-control">
            </div>
        </section>
        <button type="submit" class="btn btn-primary">{{ $button }}</button>
    </form>
    @include('admin._errors')
</div>