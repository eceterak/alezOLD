<div class="card-body">
    <form action="{{ route(...$route) }}" method="POST" class="form">
        @csrf
        @method($method)
        <div class="form-group">
            <label for="name">Nazwa</label>
            <input type="text" name="name" id="name" value="{{ (isset($street)) ? $street->name :  old('name') }}" class="form-control">
        </div>
        <div class="form-row">
            <div class="form-group col-6">
                <label for="lat">Latitude</label>
                <input type="text" name="lat" id="lat" value="{{ (isset($street)) ? $street->lat :  old('lat') }}" class="form-control">
            </div>
            <div class="form-group col-6">
                <label for="lon">Longitude</label>
                <input type="text" name="lon" id="lon" value="{{ (isset($street)) ? $street->lon :  old('lon') }}" class="form-control">
            </div>
        </div>
        <button class="btn btn-primary">{{ $button }}</button>
    </form>
    @include('admin._errors')
</div>