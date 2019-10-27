$(function() {

    $('#city_id', 'form[name="create_new_advert"]').combobox({
        required: true,
        requiredMessage: 'Miasto jest wymagane'
    });

    $('#street_id').combobox({
        disabled: true
    });

    $('#available_from', 'form[name="create_new_advert"]').datepicker({
        dateFormat: 'yy-mm-dd'
    });

    //$('#search_master_form select[name="room_size"]').selectmenu();

    // Poppa
    $('#advert-form-va').validation({
        requiredMessage: function(name) {
            return 'To pole jest wymagane';
        },
        liveValidation: false
    });

    /** 
     * Bootstrap 
     */ 

    // Tabs
    var hash = window.location.hash;

    if(hash) {
        $('nav.nav a').removeClass('active');
        $('.tab-pane').removeClass('show active');
        $('nav.nav a[href="' + hash + '"]').addClass('active');
        $(hash).addClass('show active');
    }

    $('.nav-tabs a').click(function (e) {
        $(this).tab('show');
        window.location.hash = this.hash;
    });

    // Tooltip
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });

    // Modals
    if(!window.App.signedIn || !(window.App.user && window.App.user.email_verified_at)) {
        $('.accountWarning').on('focus click', function(event) {
            event.preventDefault();

            $('#accountWarningnModal').modal('toggle');
        });
    }

    $('.contact-show').on('focus click', function(event) {
        event.preventDefault();

        $('#contact-modal').modal('toggle');
    });

    $('.filters-show').on('focus click', function(event) {
        event.preventDefault();

        $('#filters-modal').modal('toggle');
    });

    $('#advertDeleteConfirmationModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var endpoint = button.data('endpoint');
        
        $(this).find('form#confirmationForm').attr('action', endpoint);
    });

    // User menu active item
    $('.user-menu li a').each(function(key, item) {
        if(item.href == window.location.href) {
            $(item).addClass('active');
            $(item).parent().addClass('d-block');
        }
    });

    // Disable empty inputs when applying filters to clear the url a bit.
    $('form[name="advertFiltersForm"]').submit(function(e) {
        var inputs = $('input, select', this);

        inputs.each(function(key, input) {
            $input = $(input);

            if($input.val() == '') {
                $input.attr('disabled', true);
            }
        });
    });

    // mBox
    $('.mBox').mBox({
        imagesPerPage: 5
    });

    $.fn.goTo = function() {
        if($(this).length > 0) {
            $(document.documentElement, document.body).animate({
                scrollTop: $(this).offset().top
            }, 600);
        }
    }

    // Display filters on mobile
    // $('.filters-show, .filters-hide').on('click', function() {
    //     $('.filter-box').fadeToggle('fast');
    // });
});