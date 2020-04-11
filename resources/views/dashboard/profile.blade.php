@extends('dashboard.layout')
@section('site_title', __('Profil'))
@section('page_title')
    <div class="page-title-icon"><i class="pe-7s-user icon-gradient bg-white"></i></div>
    <div>
        {{ __('dashboard.profile') }}
        <div class="page-title-subheading">{{ __('forms.profile_subtitle') }}</div>
    </div>
@endsection
@section('content')
    <form method="post" action="{{route('admin_profile')}}" id="admin_profile_form" class="card-panel hoverable" autocomplete="{{ Str::random(16) }}">
        <div class="row form-successes">
            <ul>
                @if(isset($successes))
                    @foreach ($successes as $success)
                        <li>{{ $success }}</li>
                    @endforeach
                @endif
            </ul>
        </div>
        <div class="row form-errors">
            <ul>
                @if($errors->any())
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                @endif
            </ul>
        </div>
        {{ csrf_field() }}
        @if(isset($current_user->volunteer_data))
        <div class="row">
            <div class="input-field col s12 m3 l5 font-weight-bolder">
                {{ __('forms.suspend_volunteer_status') }}
                <span class="helper-text">{{ __('forms.suspend_volunteer_status_helper_text') }}</span>
            </div>
            <div class="input-field col s12 m3 l3">
                <div class="switch">
                    <label>
                        {{ __('forms.no') }}
                        <input type="checkbox" name="volunteer_status_cancelled" @if($current_user->volunteer_data->status == 0) checked @endif>
                        <span class="lever"></span>
                        {{ __('forms.yes') }}
                    </label>
                </div>
            </div>
            <div class="input-field col s12 m4 center-align">
                <button class="waves-effect waves-light btn-large red" type="submit" name="action">{{ __('forms.save') }}
                    <i class="material-icons right">send</i>
                </button>
            </div>
        </div>
        @else
            <div class="row">
                <div class="input-field col s12 m4 center-align">
                    <a class="waves-effect red btn-large" href="?new_volunteer=1">{{ __('forms.apply_for_volunteer') }}
                        <i class="material-icons right">pan_tool</i>
                    </a>
                </div>
            </div>
        @endif
        <div class="row">
            <h4>{{ __('forms.my_user_data') }}</h4>
        </div>
        <div class="row">
            <div class="input-field col s12 m3">
                <input required disabled name="first_name" id="first_name" type="text" class="validate" value="{{ $current_user->first_name }}">
                <label for="first_name">{{ __('forms.family_name') }}</label>
            </div>
            <div class="input-field col s12 m3">
                <input required disabled name="last_name" id="last_name" type="text" class="validate" value="{{ $current_user->last_name }}">
                <label for="last_name">{{ __('forms.surname') }}</label>
            </div>
            <div class="input-field col s12 m3">
                <input required name="display_name" id="display_name" type="text" class="validate" value="{{ $current_user->display_name }}">
                <label for="display_name">{{ __('forms.nickname') }}</label>
                <span class="helper-text">{{ __('forms.nickname_helper_text') }}</span>
            </div>
            <div class="input-field col s12 m3">
                <select id="birth_year" disabled name="birth_year" class="validate">
                    <option value="" @if($current_user->date_birth == null) selected @endif disabled>Év</option>
                    @for ($i = 2003; $i >= 1961; $i--)
                        <option @if($current_user->date_birth == $i) selected @endif value="{{$i}}">{{$i}}</option>
                    @endfor
                </select>
                <label for="birth_year">{{ __('forms.birth_year') }}</label>
                <span class="helper-text">{{ __('forms.birthday_age_limit_helper_text') }}</span>
            </div>
        </div>
        <div class="row">
            <div class="col s12 @if (setting('site.facebook_profile') == 1) l4 @else l6 @endif">
                <div class="input-field">
                    <input required name="email" id="email" type="email" class="validate" value="{{ $current_user->email }}">
                    <label for="email">{{ __('forms.email') }}</label>
                </div>
            </div>
            <div class="col s12 @if (setting('site.facebook_profile') == 1) l4 @else l6 @endif">
                <div class="input-field">
                    <input required name="phone" id="phone" type="text" class="validate" value="{{ $current_user->phone_number }}">
                    <label for="phone">{{ __('forms.mobile') }}</label>
                </div>
            </div>
            @if (setting('site.facebook_profile') == 1)
                <div class="col s12 l4">
                    <div class="input-field">
                        <input name="facebook_profile" id="facebook_profile" type="text" value="{{ $current_user->facebook_profile }}">
                        <label for="facebook_profile">{{ __('forms.facebook_profile') }}</label>
                    </div>
                </div>
            @endif
        </div>
        <div class="row">
            <div class="input-field col s5 m2">
                <input required type="text" id="postcode" name="postcode" class="autocomplete validate"
                       autocomplete="{{ Str::random(16) }}" value="{{ isset($current_user->home_address)?$current_user->home_address->post_code:null }}">
                <label for="postcode">{{ __('forms.post_code') }}</label>
            </div>
            <div class="input-field col s7 m3">
                <input required type="text" id="city" name="city" autocomplete="{{ Str::random(16) }}"
                       value="{{ isset($current_user->home_address)?$current_user->home_address->city:null }}">
                <label for="city">{{ __('forms.city') }}</label>
            </div>
            <div class="input-field col s9 m5">
                <input required type="text" id="street" name="street" class="autocomplete validate"
                       autocomplete="{{ Str::random(16) }}" value="{{ isset($current_user->home_address)?$current_user->home_address->street:null }}">
                <label for="street">{{ __('forms.street') }}</label>
            </div>
            <div class="input-field col s3 m2">
                <input required type="text" id="house_number" name="house_number" class="validate validate"
                       value="{{ isset($current_user->home_address)?$current_user->home_address->house_number:null }}">
                <label for="house_number">{{ __('forms.house_number') }}</label>
            </div>
        </div>
        @if(isset($current_user->volunteer_data) || Request()->new_volunteer == 1)
            <div class="row">
                @if(Request()->new_volunteer == 1)
                    <h4>{{ __('forms.apply_for_volunteer') }}</h4>
                @else
                    <h4>{{ __('forms.my_volunteer_data') }}</h4>
                @endif
            </div>
            <div class="row">
                <div class="input-field col s12 m4 l3">
                    {{ __('forms.has_car') }}
                </div>
                <div class="input-field col s12 m8 l9">
                    <div class="switch">
                        <label>
                            {{ __('forms.no') }}
                            <input type="checkbox" name="has_car" @if(isset($current_user->volunteer_data) && $current_user->volunteer_data->has_car == 1) checked @endif >
                            <span class="lever"></span>
                            {{ __('forms.yes') }}
                        </label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12 m4 l3">
                    {{ __('forms.availability') }}
                </div>
                <div class="input-field col s12 m4">
                    <select required class="validate" id="availability" name="availability">
                        <option value="" disabled @if(!isset($current_user->volunteer_data) || $current_user->volunteer_data->availability == null) selected @endif>{{ __('forms.please_choose') }}</option>
                        <option @if(isset($current_user->volunteer_data) && $current_user->volunteer_data->availability == 'Délelőtt') selected @endif value="Délelőtt">{{ __('Délelőtt') }}</option>
                        <option @if(isset($current_user->volunteer_data) && $current_user->volunteer_data->availability == 'Délután') selected @endif value="Délután">{{ __('Délután') }}</option>
                        <option @if(isset($current_user->volunteer_data) && $current_user->volunteer_data->availability == 'Reggeltől-Estig') selected @endif value="Reggeltől-Estig">{{ __('Reggeltől-Estig') }}</option>
                        <option @if(isset($current_user->volunteer_data) && $current_user->volunteer_data->availability == '0-24 órában') selected @endif value="0-24 órában">{{ __('0-24 órában') }}</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    {{ __('forms.volunteer_area') }}
                </div>
            </div>
            <div class="row">
                <div class="area-input-group row">
                    <div class="input-field col s5 m1">
                        <input type="text" id="area_postcode_1" name="area_postcode[]" class="autocomplete"
                               autocomplete="{{ Str::random(16) }}" value="{{ isset($current_user->volunteer_data)?$current_user->volunteer_addresses[0]->post_code:null }}">
                        <label for="area_postcode_1">{{ __('forms.post_code') }}</label>
                    </div>
                    <div class="input-field col s7 m2">
                        <input type="text" id="area_city_1" name="area_city[]" value="{{ isset($current_user->volunteer_data)?$current_user->volunteer_addresses[0]->city:null }}">
                        <label for="area_city_1">{{ __('forms.city') }}</label>
                    </div>
                    <div class="input-field col s12 m4">
                        <input type="text" id="area_street_1" name="area_street[]" class="autocomplete"
                               autocomplete="{{ Str::random(16) }}" value="{{ isset($current_user->volunteer_data)?$current_user->volunteer_addresses[0]->street:null }}">
                        <label for="area_street_1">{{ __('forms.street') }}</label>
                    </div>
                    <div class="input-field col s6 m2">
                        <input type="text" id="area_from-house-number_1" name="area_from-house-number[]"
                               class="validate" value="{{ isset($current_user->volunteer_addresses[0]->house_number)?$current_user->volunteer_addresses[0]->house_number:null }}">
                        <label for="area_from-house-number_1">{{ __('forms.from_house_number') }}</label>
                        <span class="helper-text">{{ __('forms.leave_empty_for_whole_street') }}</span>
                    </div>
                    <div class="input-field col s6 m2">
                        <input type="text" id="area_to-house-number_1" name="area_to-house-number[]"
                               class="validate" value="{{ isset($current_user->volunteer_addresses[0]->house_number_2)?$current_user->volunteer_addresses[0]->house_number_2:null }}">
                        <label for="area_to-house-number_1">{{ __('forms.to_house_number') }}</label>
                        <span class="helper-text">{{ __('forms.leave_empty_for_whole_street') }}</span>
                    </div>
                    <div class="input-field col s2 m1">
                        <span class="waves-effect red btn-small font-size-xlg" id="delete_area_address_1" style="display: none">
                            <i class="material-icons font-weight-bolder black-text">delete_forever</i>
                        </span>
                    </div>
                </div>
                @if(isset($current_user->volunteer_data) && $current_user->volunteer_addresses[0]->street)
                    @for($i=1; $i<=min(count($current_user->volunteer_addresses), 4); $i++)
                        <div class="area-input-group row">
                            <div class="input-field col s5 m1">
                                <input type="text" id="area_postcode_{{($i+1)}}" name="area_postcode[]" class="autocomplete"
                                       autocomplete="{{ Str::random(16) }}" @if(isset($current_user->volunteer_addresses[$i]))value="{{ $current_user->volunteer_addresses[$i]->post_code }}"@endif>
                                <label for="area_postcode_{{($i+1)}}">{{ __('forms.post_code') }}</label>
                            </div>
                            <div class="input-field col s7 m2">
                                <input type="text" id="area_city_{{$i+1}}" name="area_city[]" @if(!isset($current_user->volunteer_addresses[$i])) disabled @endif
                                @if(isset($current_user->volunteer_addresses[$i]))value="{{ $current_user->volunteer_addresses[$i]->city }}"@endif>
                                <label for="area_city_{{($i+1)}}">{{ __('forms.city') }}</label>
                            </div>
                            <div class="input-field col s12 m4">
                                <input type="text" @if(!isset($current_user->volunteer_addresses[$i])) disabled @endif id="area_street_{{$i+1}}" name="area_street[]" class="autocomplete"
                                       autocomplete="{{ Str::random(16) }}" @if(isset($current_user->volunteer_addresses[$i]))value="{{ $current_user->volunteer_addresses[$i]->street }}"@endif>
                                <label for="area_street_{{($i+1)}}">{{ __('forms.street') }}</label>
                            </div>
                            <div class="input-field col s6 m2">
                                <input type="text" @if(!isset($current_user->volunteer_addresses[$i])) disabled @endif id="area_from-house-number_{{$i+1}}" name="area_from-house-number[]"
                                       class="validate" @if(isset($current_user->volunteer_addresses[$i]))value="{{ $current_user->volunteer_addresses[$i]->house_number }}"@endif>
                                <label for="area_from-house-number_{{($i+1)}}">{{ __('forms.from_house_number') }}</label>
                                <span class="helper-text">{{ __('forms.leave_empty_for_whole_street') }}</span>
                            </div>
                            <div class="input-field col s6 m2">
                                <input type="text" @if(!isset($current_user->volunteer_addresses[$i])) disabled @endif id="area_to-house-number_{{$i+1}}" name="area_to-house-number[]"
                                       class="validate" @if(isset($current_user->volunteer_addresses[$i]))value="{{ $current_user->volunteer_addresses[$i]->house_number_2 }}"@endif>
                                <label for="area_to-house-number_{{($i+1)}}">{{ __('forms.to_house_number') }}</label>
                                <span class="helper-text">{{ __('forms.leave_empty_for_whole_street') }}</span>
                            </div>
                            <div class="input-field col s3 m1">
                                <span class="waves-effect red btn-small font-size-xlg" id="delete_area_address_{{$i+1}}">
                                    <i class="material-icons font-weight-bolder black-text">delete_forever</i>
                                </span>
                            </div>
                        </div>
                    @endfor
                @endif
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <select multiple id="help_types" name="help_types[]" data-old_value="{{ old('help_types.0') }}">
                        <option value="" disabled @if(!isset($current_user->volunteer_data) || $help_types[0] == null) selected @endif>{{ __('forms.please_choose') }}</option>
                        @foreach($help_types as $help)
                            <option @if(isset($current_user->volunteer_data) && in_array($help->id, json_decode($current_user->volunteer_data->helping_groups))) selected @endif value="{{$help->id}}">{{$help->name}}</option>
                        @endforeach
                    </select>
                    <label for="help_types">{{ __('forms.help_types') }}</label>
                </div>
            </div>
            @if(!isset($current_user->volunteer_data) && isset(Request()->new_volunteer))
                <div class="row">
                    <div class="col">
                        <label>
                            <input required type="checkbox" name="privacy_policy" id="privacy_policy">
                            <span>{{ __('forms.privacy_policy_and_jvh_rules') }}</span>
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label>
                            <input required type="checkbox" name="health_checkbox" id="health_checkbox">
                            <span>{{ __('forms.i_am_healthy') }}
                        </span>
                        </label>
                    </div>
                </div>
            @endif
        @endif
        <div class="row">
            <div class="input-field col s12 center-align">
                <button class="waves-effect waves-light btn-large red" type="submit" name="action">{{ __('forms.save') }}
                    <i class="material-icons right">send</i>
                </button>
            </div>
        </div>
    </form>
@endsection

@section('dashboard_js')
    <script type="text/javascript" defer>
        $(document).ready(function(){
            $(document).on('keyup','input#postcode.autocomplete, input[id^="area_postcode"].autocomplete', function(e) {
                if(e.which <= 40 && e.which >= 37 || e.which === 13) {
                    return;
                }

                let _this = $(this);
                if(!$(this).hasClass('invalid')) {
                    $(this).addClass('invalid');
                }

                let ajaxResponse = '', parsed = '', ac_post_codes = {};

                _this.autocomplete({
                    onAutocomplete: function(elem) {
                        let city_name = parsed.map(function(obj){
                            if (parseInt(obj['post_code']) === parseInt(elem)) {
                                return obj.name;
                            }
                        }).filter(function( elem ) {
                            return elem !== undefined;
                        });

                        let $parentRow = _this.parent('.input-field').parent('.row, .area-input-group');

                        let $cityField = $parentRow.find('input#city, input[id^="area_city"]');

                        if(city_name.length === 1) {
                            $cityField.val(city_name[0]).addClass('valid');
                            $parentRow.find('input#street, input[id^="area_street"]').attr('disabled', false);
                            $cityField.attr('disabled', false);
                        } else if(city_name.length > 1) {
                            let cityNamesObj = {};
                            for (var key in city_name) {
                                cityNamesObj[city_name[key]] = null;
                            }
                            $cityField.attr('disabled', false);
                            $cityField.addClass('invalid');
                            $cityField.val('');
                            $cityField.autocomplete({
                                data: cityNamesObj,
                                onAutocomplete: function () {
                                    $cityField.addClass('valid');
                                    $cityField.removeClass('invalid');
                                    $parentRow.find('input#street, input[id^="area_street"]').attr('disabled', false);
                                }
                            })
                        }
                        _this.addClass('valid');
                        _this.removeClass('invalid');

                        M.updateTextFields();
                    }
                });

                $.ajax({
                    beforeSend: function (jqXHR, settings) {
                        jqXHR.setRequestHeader('X-CSRF-TOKEN', $('meta[name="token"]').attr('content'));
                    },
                    type: "POST",
                    url: '/postcode-autocomplete', // This is what I have updated
                    data: {post_code: _this.val()}
                }).done(function( response ) {
                    ajaxResponse = response;
                    parsed = JSON.parse(ajaxResponse);

                    ac_post_codes= {};

                    for (var key in parsed) {
                        if(parsed.hasOwnProperty(key)) {
                            ac_post_codes[parsed[key]['post_code']] = null;
                        }
                    }
                    var instance = M.Autocomplete.getInstance(_this);

                    instance.updateData(ac_post_codes);
                    instance.open();

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

                                let clickedId = element.attr('id').split('_');

                                if(clickedId[0] === 'area') {
                                    var parentRow = element.parents('.area-input-group').parent('.row');
                                    var inputGroup  = parentRow.find('.area-input-group:last-of-type');
                                    var lastStreetInput = inputGroup.find('input[id*="street"');
                                    var elemId = lastStreetInput.attr('id').split('_');
                                }

                                if(clickedId.length && clickedId[0] === 'area' && parseInt(elemId[2]) < 5 && elemId[2] === clickedId[2]) {

                                    let parentRow = element.parents('.area-input-group').parent('.row');
                                    let inputGroup  = parentRow.find('.area-input-group:last-of-type');
                                    parentRow.append('<div class="area-input-group row">'+inputGroup.html()+'</div>');
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
                                        } else {
                                            $(this).attr('disabled', 'disabled');
                                            $(this).removeClass('valid');
                                        }
                                    });

                                    let idHelper = parseInt(elemId[2]);

                                    addedRow.find('span[id^=delete_area_address_]').attr('id', 'delete_area_address_'+(++idHelper)).show();
                                } else {
                                    let parentRow = element.parent('.input-field').parent('.row');
                                    parentRow.find('input[id="house_number"').attr('disabled', false);
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
            $(document).on('keyup','input#street, input[id^="area_street_"]', function(e) {

                if(e.which <= 40 && e.which >= 37 || e.which === 13) {
                    return;
                }

                if(!$(this).hasClass('invalid')) {
                    $(this).addClass('invalid');
                }

                let element = $(this);

                clearTimeout(timeout);

                timeout = setTimeout(function () {
                    streetAutocomplete(element);
                }, 500);
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

            // Mobile menu initialization
            $(document).ready(function(){
                $('.sidenav').sidenav();
            });

            $(document).on('click','span[id^="delete_area_address_"]', function() {
                let $parentGroup = $(this).parents('.area-input-group');

                if($parentGroup.find('input[id^="area_street_"]').val().length > 0) {
                    if($parentGroup.is(':last-of-type')) {

                        $parentGroup.find('input').each(function () {
                            let idHelper = $(this).attr('id').split('_');
                            if(idHelper[1] === 'street' || idHelper[1] === 'from-house-number') {
                                $(this).val('');
                                $(this).attr('disabled', 'disabled');
                                $(this).removeClass('invalid');

                                if(idHelper[1] === 'street') {
                                    $(this).next('ul.autocomplete-content').hide();
                                }
                                $(this).attr('disabled', 'disabled');
                                $(this).removeClass('valid');
                            } else if(idHelper[1] === 'postcode') {
                                $(this).val('');
                                $(this).removeClass('valid');
                            } else {
                                $(this).attr('disabled', 'disabled');
                                $(this).removeClass('valid');
                                $(this).val('');
                            }
                        });

                    } else {
                        $parentGroup.remove();
                    }
                }
            });

        });
    </script>
@endsection