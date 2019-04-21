$(function() {

    $('#city', 'form[name="search_master_form"]').autocomplete({

        minLength: 3,

        source: function(request, response) {
            $.ajax({
                url: '/ajax/cities',
                method: 'POST',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    city: request.term
                },
                success: function(cities) {
                    console.log(cities);
                    response($.map(cities, function(city) {
                        return {
                            label: city.name,
                            value: city.id
                        }
                    }));
                }
            });
        },

        focus: function(event, ui) {
            $('#city').val(ui.item.label);
        },

        select: function(event, ui) {
            $('#city').val(ui.item.label);
            $('#city_id').val(ui.item.value);

            $('form[name="search_master_form"]').submit();
            return false;
        }

    });

});