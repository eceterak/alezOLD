@extends('layouts.master')

@section('lead')
    <div class="text-center mb-5">
        <h1 class="font-normal">Znajdz swoj kawalek podlogi.</h1>
        <p class="mt-2">Znajdz pokoj sposrod tysiecy.</p>
    </div>
    <form action="/" method="get" name="search_master" autocomplete="off" id="search_master" class="flex form p-5 bg-teal rounded">
        <div class="form-group-reverse w-4/5 mb-0">
            <input type="text" name="miasto" placeholder="Wpisz miasto..." autocomplete="off" id="search" class="w-full p-2 rounded">
        </div>
        <div class="w-1/5 ml-4">
            <button class="w-full h-full btn">Szukaj</button>
        </div>
    </form>

    <script>

        var autocomplete;

        var options = {
            types: ['(regions)'],
            componentRestrictions: {country: 'pl'},
            fields: ['place_id', 'name']
        };

        var input = document.getElementById('search');
        var form = document.getElementById('search_master');
        
        function initAutocomplete() 
        {
            autocomplete = new google.maps.places.Autocomplete(input, options);

            autocomplete.addListener('place_changed', submitSearchMasterForm);
        }

        function submitSearchMasterForm() 
        {
            form.submit();
        }

    </script>
@endsection