@extends('layout')

@section('title', 'Önkéntes jelentkezés')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col s12">
                <form method="post" action="{{url('form-submit')}}" id="volunteer_reg_form" class="card-panel hoverable" autocomplete="{{ Str::random(16) }}">
                    <div class="row">
                        <h4 class="center-align">Önkéntes jelentkezés Vigyázónak</h4>
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
                            <label for="first_name">Családnév</label>
                        </div>
                        <div class="input-field col s12 m3">
                            <input required name="last_name" id="last_name" type="text" class="validate" value="{{ old('last_name') }}">
                            <label for="last_name">Keresztnév</label>
                        </div>
                        <div class="input-field col s12 m3">
                            <input required name="display_name" id="display_name" type="text" class="validate" value="{{ old('display_name') }}">
                            <label for="display_name">Becenév/Megszólítás</label>
                            <span class="helper-text">Ezt minden más felhasználó látja, ez alapján "azonosítják" Önt!</span>
                        </div>
                        <div class="input-field col s12 m3">
                            <select id="birth_year" name="birth_year" class="validate">
                                <option value="" @if(old('birth_year') == null) selected @endif disabled>Év</option>
                                @for ($i = 2003; $i >= 1961; $i--)
                                    <option @if(old('birth_year') == $i) selected @endif value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>
                            <label for="birth_year">Születési Év</label>
                            <span class="helper-text">Életkor min. 17 év, max. 59 év</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m4">
                            <input required name="email" id="email" type="email" class="validate" value="{{ old('email') }}">
                            <label for="email">Email</label>
                        </div>
                        <div class="input-field col s12 m4">
                            <input required name="phone" id="phone" type="text" class="validate" value="{{ old('phone') }}">
                            <label for="phone">Mobil</label>
                        </div>
                        @if (setting('site.facebook_profile') == 1)
                            <div class="input-field col s12 m4">
                                <input name="facebook_profile" id="facebook_profile" type="text" value="{{ old('facebook_profile') }}">
                                <label for="facebook_profile">Facebook profil</label>
                            </div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="input-field col s5 m2">
                            <input required type="text" id="postcode" name="postcode" class="autocomplete validate" autocomplete="{{ Str::random(16) }}" value="{{ old('postcode') }}">
                            <label for="postcode">Irányítószám</label>
                        </div>
                        <div class="input-field col s7 m3">
                            <input required type="text" id="city" name="city" @if(old('street') == null) disabled @endif autocomplete="{{ Str::random(16) }}" value="{{ old('city') }}">
                            <label for="city">Város</label>
                        </div>
                        <div class="input-field col s9 m5">
                            <input required type="text" @if(old('street') == null) disabled @endif id="street" name="street" class="autocomplete validate" autocomplete="{{ Str::random(16) }}" value="{{ old('street') }}">
                            <label for="street">Utca</label>
                        </div>
                        <div class="input-field col s3 m2">
                            <input required type="text" @if(old('street') == null) disabled @endif id="house_number" name="house_number" class="validate validate" autocomplete="{{ Str::random(16) }}" value="{{ old('house_number') }}">
                            <label for="house_number">Házszám</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 m4">
                            <div class="input-field col s12 m7 l7">
                                Autóval rendelkezem:
                            </div>
                            <div class="input-field col s12 m5 l5">
                                <div class="switch">
                                    <label>
                                        Nem
                                        <input type="checkbox" name="has_car" @if(old('has_car') == 'on') checked @endif >
                                        <span class="lever"></span>
                                        Igen
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col s12 m4">
                            <div class="input-field col s12">
                                <select required class="validate" id="availability" name="availability" data-old_value="{{ old('availability') }}">
                                    <option value="" disabled @if(old('availability') == null) selected @endif>Kérem válasszon</option>
                                    <option @if(old('availability') == 'Délelőtt') selected @endif value="Délelőtt">Délelőtt</option>
                                    <option @if(old('availability') == 'Délután') selected @endif value="Délután">Délután</option>
                                    <option @if(old('availability') == 'Reggeltől-Estig') selected @endif value="Reggeltől-Estig">Reggeltől-Estig</option>
                                    <option @if(old('availability') == '0-24 órában') selected @endif value="0-24 órában">0-24 órában</option>
                                </select>
                                <label for="availability">Rendelkezésre állás:</label>
                            </div>
                        </div>
                        <div class="col s12 m4">
                            <div class="input-field col s12">
                                <select multiple id="help_types" name="help_types[]" data-old_value="{{ old('help_types.0') }}">
                                    <option value="0" disabled selected>Kérem válasszon</option>
                                    @foreach($help_types as $help)
                                        <option @if(old('help_types') && in_array($help->id, old('help_types'))) selected @endif value="{{$help->id}}">{{$help->name}}</option>
                                    @endforeach
                                </select>
                                <label for="help_types">Vállalt segítségnyújtás</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            Vállalt körzet(Kérem saját lakóhelyéről gyalogosan elérhető körzetet válasszon, max. 5 utca):
                        </div>
                        <div class="area-input-group row">
                            <div class="input-field col s5 m1">
                                <input type="text" id="area_postcode_1" name="area_postcode[]" class="autocomplete"
                                       autocomplete="{{ Str::random(16) }}" value="{{ old('area_postcode.0') }}">
                                <label for="area_postcode_1">Irányítószám</label>
                            </div>
                            <div class="input-field col s7 m2">
                                <input type="text" id="area_city_1" name="area_city[]" @if(old('area_street.0') == null) disabled @endif value="{{ old('area_city.0') }}">
                                <label for="area_city_1">Város</label>
                            </div>
                            <div class="input-field col s12 m4">
                                <input type="text" @if(old('area_street.0') == null) disabled @endif id="area_street_1" name="area_street[]" class="autocomplete"
                                       autocomplete="{{ Str::random(16) }}" value="{{ old('area_street.0') }}">
                                <label for="area_street_1">Utca</label>
                            </div>
                            <div class="input-field col s5 m2">
                                <input type="text" @if(old('area_street.0') == null) disabled @endif id="area_from-house-number_1" name="area_from-house-number[]"
                                       class="validate" value="{{ old('area_from-house-number.0') }}">
                                <label for="area_from-house-number_1">Házszám(-tól)</label>
                                <span class="helper-text">Hagyja üresen, ha az egész utcát vállalja.</span>
                            </div>
                            <div class="input-field col s5 m2">
                                <input type="text" @if(old('area_street.0') == null) disabled @endif id="area_to-house-number_1" name="area_to-house-number[]"
                                       class="validate" value="{{ old('area_to-house-number.0') }}">
                                <label for="area_to-house-number_1">Házszám(-ig)</label>
                                <span class="helper-text">Hagyja üresen, ha az egész utcát vállalja.</span>
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
                                        <label for="area_postcode_{{$i}}">Irányítószám</label>
                                    </div>
                                    <div class="input-field col s7 m2">
                                        <input type="text" id="area_city_{{$i}}" name="area_city[]" @if(old('area_street.'.$i) == null) disabled @endif value="{{ old('area_city.'.$i) }}">
                                        <label for="area_city_{{$i}}">Város</label>
                                    </div>
                                    <div class="input-field col s12 m4">
                                        <input type="text" @if(old('area_street.'.$i) == null) disabled @endif id="area_street_{{$i}}" name="area_street[]" class="autocomplete"
                                               autocomplete="{{ Str::random(16) }}" value="{{ old('area_street.'.$i) }}">
                                        <label for="area_street_1">Utca</label>
                                    </div>
                                    <div class="input-field col s6 m2">
                                        <input type="text" @if(old('area_street.'.$i) == null) disabled @endif id="area_from-house-number_{{$i}}" name="area_from-house-number[]"
                                               class="validate" value="{{ old('area_from-house-number.'.$i) }}">
                                        <label for="area_from-house-number_{{$i}}">Házszám(-tól)</label>
                                        <span class="helper-text">Hagyja üresen, ha az egész utcát vállalja.</span>
                                    </div>
                                    <div class="input-field col s6 m2">
                                        <input type="text" @if(old('area_street.'.$i) == null) disabled @endif id="area_to-house-number_{{$i}}" name="area_to-house-number[]"
                                               class="validate" value="{{ old('area_to-house-number.'.$i) }}">
                                        <label for="area_to-house-number_{{$i}}">Házszám(-ig)</label>
                                        <span class="helper-text">Hagyja üresen, ha az egész utcát vállalja.</span>
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
                                <span>Elolvastam és elfogadom az Adatvédelmi Szabályzatot és elolvastam a Jószomszédság Vigyázó
                        Hálózat szabályait. Kijelentem, hogy a vállalt feladataimat legjobb tudásom szerint elvégzem,
                        ha akadály adódik, azonnal jelzem.</span>
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label>
                                <input required type="checkbox" name="health_checkbox" id="health_checkbox">
                                <span>Kijelentem hogy a jelentkezés pillanatában egészséges vagyok és a mindenkori járványügyi szabályokat szigorúan betartom.
                        Amennyiben bármilyen fertőzés esélye áll fent, nem veszek részt további önkéntességben.
                    </span>
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 center-align">
                            <button class="waves-effect waves-light btn-large" type="submit" name="action">Regisztráció
                                <i class="material-icons right">send</i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection