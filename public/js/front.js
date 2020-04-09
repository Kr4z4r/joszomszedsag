$(document).ready(function(){
    $(document).on('keyup','input#postcode.autocomplete', function() {
        let _this = $(this);
        if(!$(this).hasClass('invalid')) {
            $(this).addClass('invalid');
        }

        let ajaxResponse = '', parsed = '', ac_post_codes = {};
        let element = $(this);

        $.ajax({
            beforeSend: function (jqXHR, settings) {
                jqXHR.setRequestHeader('X-CSRF-TOKEN', $('meta[name="token"]').attr('content'));
            },
            type: "POST",
            url: '/postcode-autocomplete', // This is what I have updated
            data: {post_code: $('input#postcode.autocomplete').val()}
        }).done(function( response ) {
            ajaxResponse = response;
            parsed = JSON.parse(ajaxResponse);

            ac_post_codes= {};

            for (var key in parsed) {
                if(parsed.hasOwnProperty(key)) {
                    ac_post_codes[parsed[key]['post_code']] = null;
                }
            }
            $('input#postcode.autocomplete').autocomplete({
                data: ac_post_codes,
                onAutocomplete: function(elem) {
                    let city_name = parsed.map(function(obj){
                        if (obj['post_code'] === elem) {
                            return obj['name'];
                        }
                    });
                    console.log(city_name);
                    // TODO: change to select!
                    $('input#city').val(city_name[0]).addClass('valid');

                    $('input#postcode.autocomplete').addClass('valid');
                    $('input#street').attr('disabled', false);
                    $('input#house_number').attr('disabled', false);
                    M.updateTextFields();
                }
            });

            _this.trigger('click');
        });
    });
    
    // Autocomplete for street names
    var streetAutocomplete = function (element) {
        try {
            const promise = axios.get('https://nominatim.openstreetmap.org/search?accept-language=hu,en', {
                params: {
                    format: 'json',
                    city: element.parent('.input-field').prev('.input-field').find('input').val(),
                    street: '1 '+element.val(),
                    addressdetails: 1,
                }
            }).then(function(response) {
                let helperObj = {};
                Object.keys(response.data).forEach(function(elem) {
                    if(helperObj[response.data[elem].address.road] !== 'undefined') {
                        helperObj[response.data[elem].address.road] = null;
                    }
                });
                element.autocomplete({
                    data: helperObj,
                    onAutocomplete: function () {
                        element.addClass('valid');
                        element.removeClass('invalid');

                        let elemId = element.attr('id').split('_');

                        if(elemId.length && elemId[0] === 'area' && parseInt(elemId[2]) < 5) {
                            let parentRow = element.parents('.area-input-group').parent('.row');
                            let inputGroup  = parentRow.find('.area-input-group:last-of-type');
                            parentRow.append('<div class="area-input-group">'+inputGroup.html()+'</div>');
                            let addedRow = parentRow.find('.area-input-group:last-of-type');

                            inputGroup.find('input[id*="house-number"').attr('disabled', false);

                            addedRow.find('input').each(function () {
                                let idHelper = $(this).attr('id').split('_');
                                idHelper[2] = parseInt(idHelper[2])+1;
                                $(this).attr('id', idHelper.join('_'));
                                $(this).parent().find('label').attr('for', idHelper.join('_'));
                                if(idHelper[1] === 'street' || idHelper[1] === 'from-house-number') {
                                    $(this).val('');

                                    if(idHelper[1] === 'street') {
                                        $(this).next('ul.autocomplete-content').hide();
                                    }
                                    $(this).attr('disabled', 'disabled');
                                    $(this).removeClass('valid');
                                } else if(idHelper[1] === 'postcode') {
                                    $(this).removeClass('valid');
                                    initiatePostcodeAc(idHelper[2]);
                                } else {
                                    $(this).attr('disabled', 'disabled');
                                    $(this).removeClass('valid');
                                }
                            });
                        }
                    }
                });
                let instance = M.Autocomplete.getInstance(element);
                instance.open();
            });
        } catch (error) {
            console.error(error);
        }
    };

    let timeout = null;
    $(document).on('keyup','input#street, input[id^="area_street_"]', function() {
        if(!$(this).hasClass('invalid')) {
            $(this).addClass('invalid');
        }

        let element = $(this);

        clearTimeout(timeout);

        timeout = setTimeout(function () {
            streetAutocomplete(element);
        }, 1000);
    });

    // Select from and to time in the volunteer form
    $('.timepicker').timepicker({
        twelveHour: false,
        i18n: {
            cancel: 'Mégse',
            clear: 'Törlés',
            done: 'Ok'
        }
    });

    // Multiselect initiation
    $(document).ready(function(){
        $('select').formSelect();
    });

    // Validation
    $(document).on('change', 'input[name="has_corona"], input[name="in_quarantine"], input[name="has_chronic"]', function(){
       if($(this).prop('checked') === true) {
            if($('input[name="is_healthy"]').attr('disabled') !== true) {
                $('input[name="is_healthy"]').attr('disabled', true);
            }
       } else {
           if($('input[name="is_healthy"]').attr('disabled') !== false && $(this).parents('form').find('input[type="checkbox"]:checked').length === 0) {
               $('input[name="is_healthy"]').attr('disabled', false);
           }
       }
    });

    $(document).on('change', 'input[name="is_healthy"]', function(){
        if($(this).prop('checked') === true) {
            $('input[name="has_corona"], input[name="in_quarantine"], input[name="has_chronic"]').attr('disabled', true);
        } else {
            $('input[name="has_corona"], input[name="in_quarantine"], input[name="has_chronic"]').attr('disabled', false);
        }
    });

    // Help Request form validation
    $(document).on('submit', 'form#helprequest_reg_form', function(e) {
        let error = [], selectErr = false;

        if($(this).find('input.invalid').length > 0) {
            error.push('Kérem töltse ki a pirossal aláhúzott mezőket!');
        }

        $(this).find('select').each(function() {
            if($(this).val() === null || $(this).val().length === 0) {
                selectErr = true;
            }
        });

        if(selectErr === true) {
            error.push('Kérem ellenőrizze hogy megadta-e születési évét és segítségkérésének okát!');
        }

        if($(this).find('input[name="has_corona"]:checked, input[name="in_quarantine"]:checked, input[name="has_chronic"]:checked, input[name="is_healthy"]:checked').length === 0) {
            error.push('Kérem válassza ki az egészségi státuszát!');
        }

        if(error.length > 0) {
            e.preventDefault();
            let formElement = $(this);
            formElement.find('.form-errors ul').html('');
            $.each(error, function(index, data) {
                formElement.find('.form-errors ul').append(
                    '<li>'+data+'</li>'
            )
            });
            $('html, body').animate({
                scrollTop: $(this).offset().top
            }, 250);
        }
    });

    // Volunteer registration form validation
    $(document).on('submit', 'form#volunteer_reg_form', function(e) {
        let error = [];

        if($(this).find('input.invalid').length > 0) {
            error.push('Kérem töltse ki a pirossal aláhúzott mezőket!');
        }

        if($(this).find('select#birth_year').val() === null) {
            error.push('Kérem adja meg születési évét!');
        }

        if($(this).find('input[name^="area_street"]').val().length === 0) {
            error.push('Kérem adjon meg legalább egy utcát a vállalt körzetében!');
        }

        if(error.length > 0) {
            e.preventDefault();
            let formElement = $(this);
            formElement.find('.form-errors ul').html('');
            $.each(error, function(index, data) {
                formElement.find('.form-errors ul').append(
                    '<li>'+data+'</li>'
                )
            });
            $('html, body').animate({
                scrollTop: $(this).offset().top
            }, 250);
        }
    });

});