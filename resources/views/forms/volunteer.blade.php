@extends('layout')

@section('title', 'Önkéntes jelentkezés')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col s12">
                <form method="post" action="{{url('form-submit')}}" id="volunteer_reg_form" class="card-panel hoverable" autocomplete="{{ Str::random(16) }}">
                    <div class="row">
                        <h4 class="center-align">{{ __('forms.volunteer_form_title') }}</h4>
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
                    <input type="hidden" name="user_role" value="6">
                    <div class="row">
                        <div class="input-field col s12 m3">
                            <input required name="first_name" id="first_name" type="text" class="validate" value="{{ old('first_name') }}">
                            <label for="first_name">{{ __('forms.family_name') }}</label>
                        </div>
                        <div class="input-field col s12 m3">
                            <input required name="last_name" id="last_name" type="text" class="validate" value="{{ old('last_name') }}">
                            <label for="last_name">{{ __('forms.surname') }}</label>
                        </div>
                        <div class="input-field col s12 m3">
                            <input required name="display_name" id="display_name" type="text" class="validate" value="{{ old('display_name') }}">
                            <label for="display_name">{{ __('forms.nickname') }}</label>
                            <span class="helper-text">{{ __('forms.nickname_helper_text') }}</span>
                        </div>
                        <div class="input-field col s12 m3">
                            <select id="birth_year" name="birth_year" class="validate">
                                <option value="" @if(old('birth_year') == null) selected @endif disabled>Év</option>
                                @for ($i = 2003; $i >= 1961; $i--)
                                    <option @if(old('birth_year') == $i) selected @endif value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>
                            <label for="birth_year">{{ __('forms.birth_year') }}</label>
                            <span class="helper-text">{{ __('forms.birthday_age_limit_helper_text') }}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m4">
                            <input required name="email" id="email" type="email" class="validate" value="{{ old('email') }}">
                            <label for="email">{{ __('forms.email') }}</label>
                        </div>
                        <div class="input-field col s12 m4">
                            <input required name="phone" id="phone" type="text" class="validate" value="{{ old('phone') }}">
                            <label for="phone">{{ __('forms.mobile') }}</label>
                        </div>
                        @if (setting('site.facebook_profile') == 1)
                            <div class="input-field col s12 m4">
                                <input name="facebook_profile" id="facebook_profile" type="text" value="{{ old('facebook_profile') }}">
                                <label for="facebook_profile">{{ __('forms.facebook_profile') }}</label>
                            </div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="input-field col s5 m2">
                            <input required type="text" id="postcode" name="postcode" class="autocomplete validate" autocomplete="{{ Str::random(16) }}" value="{{ old('postcode') }}">
                            <label for="postcode">{{ __('forms.post_code') }}</label>
                        </div>
                        <div class="input-field col s7 m3">
                            <input required type="text" id="city" name="city" @if(old('street') == null) disabled @endif autocomplete="{{ Str::random(16) }}" value="{{ old('city') }}">
                            <label for="city">{{ __('forms.city') }}</label>
                        </div>
                        <div class="input-field col s9 m5">
                            <input required type="text" @if(old('street') == null) disabled @endif id="street" name="street" class="autocomplete validate" autocomplete="{{ Str::random(16) }}" value="{{ old('street') }}">
                            <label for="street">{{ __('forms.street') }}</label>
                        </div>
                        <div class="input-field col s3 m2">
                            <input required type="text" @if(old('street') == null) disabled @endif id="house_number" name="house_number" class="validate validate" autocomplete="{{ Str::random(16) }}" value="{{ old('house_number') }}">
                            <label for="house_number">{{ __('forms.house_number') }}</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 m4">
                            <div class="input-field col s12 m7 l7">
                                {{ __('forms.has_car') }}
                            </div>
                            <div class="input-field col s12 m5 l5">
                                <div class="switch">
                                    <label>
                                        {{ __('forms.no') }}
                                        <input type="checkbox" name="has_car" @if(old('has_car') == 'on') checked @endif >
                                        <span class="lever"></span>
                                        {{ __('forms.yes') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col s12 m4">
                            <div class="input-field col s12">
                                <select required class="validate" id="availability" name="availability" data-old_value="{{ old('availability') }}">
                                    <option value="" disabled @if(old('availability') == null) selected @endif>{{ __('Kérem válasszon') }}</option>
                                    <option @if(old('availability') == 'Délelőtt') selected @endif value="Délelőtt">{{ __('Délelőtt') }}</option>
                                    <option @if(old('availability') == 'Délután') selected @endif value="Délután">{{ __('Délután') }}</option>
                                    <option @if(old('availability') == 'Reggeltől-Estig') selected @endif value="Reggeltől-Estig">{{ __('Reggeltől-Estig') }}</option>
                                    <option @if(old('availability') == '0-24 órában') selected @endif value="0-24 órában">{{ __('0-24 órában') }}</option>
                                </select>
                                <label for="availability">{{ __('forms.availability') }}</label>
                            </div>
                        </div>
                        <div class="col s12 m4">
                            <div class="input-field col s12">
                                <select multiple id="help_types" name="help_types[]" data-old_value="{{ old('help_types.0') }}">
                                    <option value="0" disabled selected>{{ __('forms.please_choose') }}</option>
                                    @foreach($help_types as $help)
                                        <option @if(old('help_types') && in_array($help->id, old('help_types'))) selected @endif value="{{$help->id}}">{{$help->name}}</option>
                                    @endforeach
                                </select>
                                <label for="help_types">{{ __('forms.help_types') }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            {{ __('forms.volunteer_area') }}
                        </div>
                        <div class="area-input-group row">
                            <div class="input-field col s5 m1">
                                <input type="text" id="area_postcode_1" name="area_postcode[]" class="autocomplete"
                                       autocomplete="{{ Str::random(16) }}" value="{{ old('area_postcode.0') }}">
                                <label for="area_postcode_1">{{ __('forms.post_code') }}</label>
                            </div>
                            <div class="input-field col s7 m2">
                                <input type="text" id="area_city_1" name="area_city[]" @if(old('area_street.0') == null) disabled @endif value="{{ old('area_city.0') }}">
                                <label for="area_city_1">{{ __('forms.city') }}</label>
                            </div>
                            <div class="input-field col s12 m4">
                                <input type="text" @if(old('area_street.0') == null) disabled @endif id="area_street_1" name="area_street[]" class="autocomplete"
                                       autocomplete="{{ Str::random(16) }}" value="{{ old('area_street.0') }}">
                                <label for="area_street_1">{{ __('forms.street') }}</label>
                            </div>
                            <div class="input-field col s5 m2">
                                <input type="text" @if(old('area_street.0') == null) disabled @endif id="area_from-house-number_1" name="area_from-house-number[]"
                                       class="validate" value="{{ old('area_from-house-number.0') }}">
                                <label for="area_from-house-number_1">{{ __('forms.from_house_number') }}</label>
                                <span class="helper-text">{{ __('forms.leave_empty_for_whole_street') }}</span>
                            </div>
                            <div class="input-field col s5 m2">
                                <input type="text" @if(old('area_street.0') == null) disabled @endif id="area_to-house-number_1" name="area_to-house-number[]"
                                       class="validate" value="{{ old('area_to-house-number.0') }}">
                                <label for="area_to-house-number_1">{{ __('forms.to_house_number') }}</label>
                                <span class="helper-text">{{ __('forms.leave_empty_for_whole_street') }}</span>
                            </div>
                            <div class="input-field col s2 m1">
                        <span class="waves-effect red btn-small font-size-xlg" id="delete_area_address_1" style="display: none">
                            <i class="material-icons font-weight-bolder black-text">delete_forever</i>
                        </span>
                            </div>
                        </div>
                        @if(old('area_street.0'))
                            @for($i=1; $i<=count(old('area_street')); $i++)
                                <div class="area-input-group row">
                                    <div class="input-field col s5 m1">
                                        <input type="text" id="area_postcode_{{$i}}" name="area_postcode[]" class="autocomplete"
                                               autocomplete="{{ Str::random(16) }}" value="{{ old('area_postcode.'.$i) }}">
                                        <label for="area_postcode_{{$i}}">{{ __('forms.post_code') }}</label>
                                    </div>
                                    <div class="input-field col s7 m2">
                                        <input type="text" id="area_city_{{$i}}" name="area_city[]" @if(old('area_street.'.$i) == null) disabled @endif value="{{ old('area_city.'.$i) }}">
                                        <label for="area_city_{{$i}}">{{ __('forms.city') }}</label>
                                    </div>
                                    <div class="input-field col s12 m4">
                                        <input type="text" @if(old('area_street.'.$i) == null) disabled @endif id="area_street_{{$i}}" name="area_street[]" class="autocomplete"
                                               autocomplete="{{ Str::random(16) }}" value="{{ old('area_street.'.$i) }}">
                                        <label for="area_street_1">{{ __('forms.street') }}</label>
                                    </div>
                                    <div class="input-field col s6 m2">
                                        <input type="text" @if(old('area_street.'.$i) == null) disabled @endif id="area_from-house-number_{{$i}}" name="area_from-house-number[]"
                                               class="validate" value="{{ old('area_from-house-number.'.$i) }}">
                                        <label for="area_from-house-number_{{$i}}">{{ __('forms.from_house_number') }}</label>
                                        <span class="helper-text">{{ __('forms.leave_empty_for_whole_street') }}</span>
                                    </div>
                                    <div class="input-field col s6 m2">
                                        <input type="text" @if(old('area_street.'.$i) == null) disabled @endif id="area_to-house-number_{{$i}}" name="area_to-house-number[]"
                                               class="validate" value="{{ old('area_to-house-number.'.$i) }}">
                                        <label for="area_to-house-number_{{$i}}">{{ __('forms.to_house_number') }}</label>
                                        <span class="helper-text">{{ __('forms.leave_empty_for_whole_street') }}</span>
                                    </div>
                                    <div class="input-field col s3 m1">
                                <span class="waves-effect red btn-small font-size-xlg" id="delete_area_address_{{$i}}">
                                    <i class="material-icons font-weight-bolder black-text">delete_forever</i>
                                </span>
                                    </div>
                                </div>
                            @endfor
                        @endif
                    </div>
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
                                <span>{{ __('Kijelentem hogy a jelentkezés pillanatában egészséges vagyok és a mindenkori járványügyi szabályokat szigorúan betartom.
                        Amennyiben bármilyen fertőzés esélye áll fent, nem veszek részt további önkéntességben.') }}
                    </span>
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 center-align">
                            <button class="waves-effect waves-light btn-large" type="submit" name="action">{{ __('forms.register_button') }}
                                <i class="material-icons right">send</i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop