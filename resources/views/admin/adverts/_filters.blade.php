<form action="{{ url()->full() }}" method="GET" class="form" name="advertFiltersForm">
    <div class="form-group form-row">
        <div class="col-3">
            <label for="verified" class="small">Status weryfikacji</label>
            <select name="verified" id="verified" class="form-control form-control-sm">
                <option value="">Wszystkie</option>
                <option value="n" {{ (request('verified') == 'n') ? 'selected' : '' }}>Niezweryfikowane</option>
                <option value="y" {{ (request('verified') == 'y') ? 'selected' : '' }}>Zweryfikowane</option>
            </select>
        </div>
        <div class="col-3">
            <label for="revised" class="small">Oczekujące na potwierdzenie zmian</label>
            <select name="revised" id="revised" class="form-control form-control-sm">
                <option value="">Wszystkie</option>
                <option value="y" {{ (request('revised') == 'y') ? 'selected' : '' }}>Nieoczekujące</option>
                <option value="n" {{ (request('revised') == 'n') ? 'selected' : '' }}>Oczekujące</option>
            </select>
        </div>
        <div class="col-3">
            <label for="archived" class="small">Archiwalne</label>
            <select name="archived" id="archived" class="form-control form-control-sm">
                <option value="">Wszystkie</option>
                <option value="n" {{ (request('archived') == 'n') ? 'selected' : '' }}>Aktywne</option>
                <option value="y" {{ (request('archived') == 'y') ? 'selected' : '' }}>Archiwalne</option>
            </select>
        </div>
        <div class="col-3 d-flex align-items-end justify-content-end">
            @if(request()->filled('sort'))
                <input type="hidden" name="sort" value="{{ request('sort') }}">
            @endif
            <button type="submit" class="btn btn-sm btn-outline-primary"><i class="fas fa-search"></i></button>
        </div>
    </div>
</form>