@extends('dashboard.layout')
@section('site_title', __('Új segítségkérés'))
@section('page_title')
    <div class="page-title-icon"><i class="pe-7s-note icon-gradient bg-white"></i></div>
    <div>
        {{ __('Új segítség kérés létrehozása') }}
        <div class="page-title-subheading">{{ __('Hozzon létre új segítségkérést, hogy a Vigyázók a lehető leghamarabb segítséget tudjanak nyújtani') }}</div>
    </div>
@endsection
@section('content')
    <form method="post" action="{{route('admin_save_support_data')}}" id="helprequest_reg_form" class="card-panel hoverable" autocomplete="{{ Str::random(16) }}">
        @if($errors->any())
            <div class="row form-errors">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        {{ csrf_field() }}
        <input type="hidden" name="user_role" value="7">
        <div class="row">
            <span class="waves-effect waves-light btn-large beige" id="delete_prefilled">
                {{ __('Más címét adom meg') }}
                <i class="material-icons right">edit</i>
            </span>
        </div>
        <div class="row">
            <div class="input-field col s12 m3">
                <input required disabled name="first_name" id="first_name" type="text" class="validate" value="{{ $current_user->first_name }}">
                <label for="first_name">{{ __('Családnév') }}</label>
            </div>
            <div class="input-field col s12 m3">
                <input required disabled name="last_name" id="last_name" type="text" class="validate" value="{{ $current_user->last_name }}">
                <label for="last_name">{{ __('Keresztnév') }}</label>
            </div>
            <div class="input-field col s12 m3">
                <input required disabled name="display_name" id="display_name" type="text" class="validate" value="{{ $current_user->display_name }}">
                <label for="display_name">{{ __('Becenév/Megszólítás') }}</label>
                <span class="helper-text">{{ __('Ezt minden más felhasználó látja, ez alapján "azonosítják" Önt!') }}</span>
            </div>
            <div class="input-field col s12 m3">
                <select disabled class="validate" id="birth_year" name="birth_year">
                    <option value="" disabled @if($current_user->date_birth == null) selected @endif>Év</option>
                    @for ($i = 2020; $i >= 1900; $i--)
                        <option @if($current_user->date_birth == $i) selected @endif value="{{$i}}">{{$i}}</option>
                    @endfor
                </select>
                <label for="birth_year">{{ __('Születési Év') }}</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 @if (setting('site.facebook_profile') == 1) l4 @else l6 @endif">
                <input required disabled name="email" id="email" type="email" class="validate" value="{{ $current_user->email }}">
                <label for="email">{{ __('Email') }}</label>
            </div>
            <div class="input-field col s12 @if (setting('site.facebook_profile') == 1) l4 @else l6 @endif">
                <input required disabled name="phone" id="phone" type="text" class="validate" value="{{ $current_user->phone_number }}">
                <label for="phone">{{ __('Telefon') }}</label>
            </div>
            @if (setting('site.facebook_profile') == 1)
                <div class="input-field col s12 l4">
                    <input disabled name="facebook_profile" id="facebook_profile" type="text" value="{{ $current_user->facebook_profile }}">
                    <label for="facebook_profile">{{ __('Facebook profil') }}</label>
                </div>
            @endif
        </div>
        <div class="row">
            <div class="input-field col s5 m2">
                <input @if(isset($current_user->home_address)) disabled @endif type="text" required id="postcode" name="postcode" class="autocomplete"
                       autocomplete="{{ Str::random(16) }}" value="{{ isset($current_user->home_address)?$current_user->home_address->post_code:null }}">
                <label for="postcode">{{ __('Irányítószám') }}</label>
            </div>
            <div class="input-field col s7 m3">
                <input @if(isset($current_user->home_address)) disabled @endif type="text" required id="city" name="city" autocomplete="{{ Str::random(16) }}"
                       value="{{ isset($current_user->home_address)?$current_user->home_address->city:null }}">
                <label for="city">{{ __('Város') }}</label>
            </div>
            <div class="input-field col s9 m5">
                <input @if(isset($current_user->home_address)) disabled @endif type="text" required id="street" name="street" class="autocomplete"
                       autocomplete="{{ Str::random(16) }}" value="{{ isset($current_user->home_address)?$current_user->home_address->street:null }}">
                <label for="street">{{ __('Utca') }}</label>
            </div>
            <div class="input-field col s3 m2">
                <input @if(isset($current_user->home_address)) disabled @endif type="text" required id="house_number" name="house_number" class="validate"
                       value="{{ isset($current_user->home_address)?$current_user->home_address->house_number:null }}">
                <label for="house_number">{{ __('Házszám') }}</label>
            </div>
        </div>
        <div class="row">
            <div class="col s12 l4">
                <div class="col s12 m6 l5">
                    <div class="input-field">
                        {{ __('Koronavírussal fertőzött vagyok:') }}
                     </div>
                 </div>
                 <div class="col s12 m6 l7">
                     <div class="input-field">
                         <div class="switch">
                             <label>
                                 {{ __('Nem') }}
                                 <input type="checkbox" name="has_corona">
                                 <span class="lever"></span>
                                 {{ __('Igen') }}
                             </label>
                         </div>
                     </div>
                 </div>
             </div>
             <div class="col s12 l4">
                 <div class="col s12 m6 l5">
                     <div class="input-field">
                         {{ __('Karanténban vagyok:') }}
                     </div>
                 </div>
                 <div class="col s12 m6 l7">
                     <div class="input-field">
                         <div class="switch">
                             <label>
                                 {{ __('Nem') }}
                                 <input type="checkbox" name="in_quarantine">
                                 <span class="lever"></span>
                                 {{ __('Igen') }}
                             </label>
                         </div>
                     </div>
                 </div>
             </div>
             <div class="col s12 l4">
                 <div class="col s12 m6 l5">
                     <div class="input-field">
                         {{ __('Egyéb krónikus megbetegedésem van:') }}
                     </div>
                 </div>
                 <div class="col s12 m6 l7">
                     <div class="input-field">
                         <div class="switch">
                             <label>
                                 {{ __('Nem') }}
                                 <input type="checkbox" name="has_chronic">
                                 <span class="lever"></span>
                                 {{ __('Igen') }}
                             </label>
                         </div>
                     </div>
                 </div>
             </div>
             <div class="col s12 l4">
                 <div class="col s12 m6 l3">
                     <div class="input-field">
                         {{ __('Egyik sem (Egészséges vagyok):') }}
                     </div>
                 </div>
                 <div class="col s12 m6 l7">
                     <div class="input-field">
                         <div class="switch">
                             <label>
                                 {{ __('Nem') }}
                                 <input type="checkbox" name="is_healthy">
                                 <span class="lever"></span>
                                 {{ __('Igen') }}
                             </label>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
         <div class="row">
             <div class="input-field col s12 m6">
                 <select id="help_types" name="help_types">
                     <option value="" disabled selected>{{ __('Kérem válasszon') }}</option>
                     @foreach($help_types as $help)
                         <option value="{{$help->id}}">{{$help->name}}</option>
                    @endforeach
                </select>
                <label for="help_types">{{ __('Segítségkérés oka') }}</label>
            </div>
            <div class="input-field col s12 m6">
                <textarea id="situation_desc" name="situation_desc" class="materialize-textarea" data-length="255"></textarea>
                <label for="situation_desc">{{ __('Szituáció rövid leírása') }}</label>
            </div>
        </div>
        <div class="row">
        </div>
        <div class="row">
            <div class="col">
                <label>
                    <input required type="checkbox" name="privacy_policy" id="privacy_policy">
                    <span>{{ __('Elolvastam és elfogadom az Adatvédelmi Szabályzatot.') }}</span>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 center-align">
                <button class="waves-effect waves-light btn-large red" type="submit" name="action"
                @if($current_user->open_help_requests_count >= 3 && $current_user->role_id != 1) disabled @endif>{{ __('Rögzítés') }}
                    <i class="material-icons right">send</i>
                </button>
                @if($current_user->open_help_requests_count >= 3 && $current_user->role_id != 1) <span class="helper-text">{{ __('Egyszerre max. 3 teljesítetlen segítségkérése lehet!') }}</span> @endif
            </div>
        </div>
    </form>
@endsection

@section('dashboard_js')
    <script type="text/javascript" defer>
        $(document).ready(function(){
            $(document).on('click','#delete_prefilled', function() {
                $('input#postcode').val('').attr('disabled', false);
                $('input#city, input#street, input#house_number').val('').attr('disabled', true);
            });

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
                                        } else {
                                            $(this).attr('disabled', 'disabled');
                                            $(this).removeClass('valid');
                                        }
                                    });
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

            // Mobile menu initialization
            $(document).ready(function(){
                $('.sidenav').sidenav();
            });

        });
    </script>
@endsection