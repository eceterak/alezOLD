$(function() {

    $('#city', 'form[name="search_master_form"]').autocomplete({
        minLength: 3,
        delay: 500,
        source: function(request, response) {
            axios.get('/ajax/cities', {
                params: {
                    city: request.term
                }
            }).then(function(cities) {
                response($.map(cities.data, function(city) {
                    return {
                        label: city.name + ', ' + city.county + ', ' + city.state,
                        value: city.id
                    }
                }));       
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

  $.widget( "custom.combobox", {
    options : {
        url: '/ajax/cities',
        disabled: false,
        requiredMessage: '',
        required: false
    },
    _create: function() {
        this.wrapper = $("<span>")
            .addClass("custom-combobox")
            .insertAfter(this.element);

        this.element.hide();
        this._createAutocomplete();
    },
    _createAutocomplete: function() {
        this.input = $("<input>")
        .appendTo(this.wrapper)
        .attr("title", "")
        .attr('required', this.options.required)
        .attr('data-validation-rqmessage', this.options.requiredMessage)
        .addClass("form-control custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left")
        .attr('disabled', this.options.disabled)
        .autocomplete({
            delay: 0,
            minLength: 3,
            source: (this.options._source) ? this.options._source : $.proxy(this, "_source")
        })
        .tooltip({
            classes: {
                "ui-tooltip": "ui-state-highlight"
            }
        });

        this._on(this.input, {
            autocompleteselect: function(event, ui ) {
                let el = $('<option>').val(ui.item.value).text(ui.item.label);
                this.element.find('option')
                    .remove()
                    .end()
                    .append(el);

                this._trigger("select", event, {
                    item: el
                });

                event.target.value = ui.item.label;

                $.ajax({
                    url: '/ajax/streets',
                    method: 'GET',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        city_id: ui.item.value,
                    }
                }).done(function(streets) {
                    if(streets.length) {
                        $('#street_id').data('custom-combobox').input.autocomplete('option', 'source', function(request, response) {
                            var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
                            response($.map(streets, function(street) {
                                if(street.name && (!request.term || matcher.test(street.name))) {
                                    return {
                                        label: street.name,
                                        value: street.id
                                    };
                                }
                            }));
                        }).autocomplete('option', 'select', function(event, ui) {
                            let el = $('<option>').val(ui.item.value).text(ui.item.label);
                            $('#street_id').find('option')
                                .remove()
                                .end()
                                .append(el);
                                
                            event.target.value = ui.item.label;
    
                            return false;
                        })
                        .attr('disabled', false);
                    }

                });

                return false;
            },

            autocompletechange: "_removeIfInvalid"
        });
    },
          
    _source: function(request, response) {
        $.ajax({
            url: this.options.url,
            method: 'GET',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                city: request.term
            },
            success: function(cities) {
                /* $.each(cities, function(key, city) {
                    console.log(city);
                }); */
                response($.map(cities, function(city) {
                    return {
                        label: city.name + ', ' + city.county + ', ' + city.state,
                        value: city.id
                    }
                }));
            }
        });
    },

    enable: function() {
        this.input.attr('disabled', false);

        return this;
    },
  
    _removeIfInvalid: function( event, ui ) {

      // Selected an item, nothing to do
      if ( ui.item ) {
        return;
      }

      // Search for a match (case-insensitive)
      var value = this.input.val(),
        valueLowerCase = value.toLowerCase(),
        valid = false;
      this.element.children( "option" ).each(function() {
        if ( $( this ).text().toLowerCase() === valueLowerCase ) {
          this.selected = valid = true;
          return false;
        }
      });

      // Found a match, nothing to do
      if ( valid ) {
        return;
      }

      // Remove invalid value
      this.input
        .val( "" )
        .attr( "title", value + " didn't match any item" )
        .tooltip( "open" );
      this.element.val( "" );
      this._delay(function() {
        this.input.tooltip( "close" ).attr( "title", "" );
      }, 2500 );
      this.input.autocomplete( "instance" ).term = "";
    },
  
    _destroy: function() {
      this.wrapper.remove();
      this.element.show();
    }

  });

    $('#city_id', 'form[name="create_new_advert"]').combobox({
        'required': true,
        'requiredMessage': 'Miasto jest wymagane'
    });

    $('#street_id').combobox({
        'disabled': true
    });

    $('#available_from', 'form[name="create_new_advert"]').datepicker({
        dateFormat: 'yy-mm-dd'
    });

    $('#advert-form-va').validation({
        requiredMessage: function(name) {
            return name + ' jest wymagany';
        },
        liveValidation: true
    });

    // Bootstrap

    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });

    if(!window.App.signedIn || !(window.App.user && window.App.user.email_verified_at)) {
        $('.accountWarning').on('focus click', function(event) {
            event.preventDefault();

            $('#accountWarningnModal').modal('toggle');
        });
    }

    $('#advertDeleteConfirmationModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var endpoint = button.data('endpoint');
        
        $(this).find('form#confirmationForm').attr('action', endpoint);
    });

    $('form[name="advertFiltersForm"]').submit(function(e) {
        var inputs = $('input, select', this);

        inputs.each(function(key, input) {
            $input = $(input);

            if($input.val() == '') {
                $input.attr('disabled', true);
            }
        });
    });

});