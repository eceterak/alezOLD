<form action="{{ route(...$route) }}" method="POST" class="form">
    @csrf
    @method($method)
    <div class="input-group">
        <label for="name">Nazwa</label>
        <input type="text" name="name" id="name" value="{{ (isset($street)) ? $street->name :  old('name') }}" class="form-control">
    </div>
    <div class="input-group">
        <label for="lat">Latitude</label>
        <input type="text" name="lat" id="lat" value="{{ (isset($street)) ? $street->lat :  old('lat') }}" class="form-control">
    </div>
    <div class="input-group">
        <label for="lon">Longitude</label>
        <input type="text" name="lon" id="lon" value="{{ (isset($street)) ? $street->lon :  old('lon') }}" class="form-control">
    </div>
    <button class="btn btn-reverse">{{ $button }}</button>
</form>
@include('admin._errors')