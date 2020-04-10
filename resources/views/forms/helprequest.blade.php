@extends('layout')

@section('title', 'Segítség kérés')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col s12">
                <form method="post" action="{{url('form-submit')}}"  id="helprequest_reg_form" class="card-panel hoverable" autocomplete="{{ Str::random(16) }}">
                    <div class="row">
                        <h4>{{ __('Segítség kérése') }}</h4>
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
                    <input type="hidden" name="user_role" value="7">
                    <div class="row">
                        <div class="input-field col s12 m3">
                            <input required name="first_name" id="first_name" type="text" class="validate" value="{{ old('first_name') }}">
                            <label for="first_name">{{ __('Családnév') }}</label>
                        </div>
                        <div class="input-field col s12 m3">
                            <input required name="last_name" id="last_name" type="text" class="validate" value="{{ old('last_name') }}">
                            <label for="last_name">{{ __('Keresztnév') }}</label>
                        </div>
                        <div class="input-field col s12 m3">
                            <input required name="display_name" id="display_name" type="text" class="validate" value="{{ old('display_name') }}">
                            <label for="display_name">{{ __('Becenév/Megszólítás') }}</label>
                            <span class="helper-text">{{ __('Ezt minden más felhasználó látja, ez alapján "azonosítják" Önt!') }}</span>
                        </div>
                        <div class="input-field col s12 m3">
                            <select id="birth_year" name="birth_year" class="validate">
                                <option value="" @if(old('birth_year') == null) selected @endif disabled>Év</option>
                                @for ($i = 2020; $i >= 1900; $i--)
                                    <option @if(old('birth_year') == $i) selected @endif value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>
                            <label for="birth_year">{{ __('Születési Év') }}</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m4">
                            <input required name="email" id="email" type="email" class="validate" value="{{ old('email') }}">
                            <label for="email">{{ __('E-mail') }}</label>
                        </div>
                        <div class="input-field col s12 m4">
                            <input required name="phone" id="phone" type="text" class="validate" value="{{ old('phone') }}">
                            <label for="phone">{{ __('Telefon') }}</label>
                            <span class="helper-text" data-error="{{ __('Hibás vagy üres telefonszám') }}"></span>
                        </div>
                        @if (setting('site.facebook_profile') == 1)
                        <div class="input-field col s12 m4">
                            <input name="facebook_profile" id="facebook_profile" type="text" value="{{ old('facebook_profile') }}">
                            <label for="facebook_profile">{{ __('Facebook profil') }}</label>
                        </div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="input-field col s5 m2">
                            <input required type="text" id="postcode" name="postcode" class="autocomplete validate"
                                   autocomplete="{{ Str::random(16) }}" value="{{ old('postcode') }}">
                            <label for="postcode">{{ __('Irányítószám') }}</label>
                        </div>
                        <div class="input-field col s7 m3">
                            <input required type="text" id="city" name="city" @if(old('street') == null) disabled @endif autocomplete="{{ Str::random(16) }}" value="{{ old('city') }}">
                            <label for="city">{{ __('Város') }}</label>
                        </div>
                        <div class="input-field col s9 m5">
                            <input required type="text" @if(old('street') == null) disabled @endif id="street" name="street" class="autocomplete validate"
                                   autocomplete="{{ Str::random(16) }}" value="{{ old('street') }}">
                            <label for="street">{{ __('Utca') }}</label>
                        </div>
                        <div class="input-field col s3 m2">
                            <input required type="text" @if(old('street') == null) disabled @endif id="house_number" name="house_number" class="validate validate" value="{{ old('house_number') }}">
                            <label for="house_number">{{ __('Házszám') }}</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 m4 l4">
                            <div class="row">
                                <div class="input-field col s12 m7 l7">
                                    {{ __('Koronavírussal fertőzött vagyok') }}:
                                </div>
                                <div class="input-field col s12 m5 l5">
                                    <div class="switch">
                                        <label>
                                            {{ __('Nem') }}
                                            <input type="checkbox" name="has_corona" @if(old('has_corona') == 'on') checked @endif>
                                            <span class="lever"></span>
                                            {{ __('Igen') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col s12 m4 l4">
                            <div class="row">
                                <div class="input-field col s12 m7 l7">
                                    {{ __('Karanténban vagyok') }}:
                                </div>
                                <div class="input-field col s12 m5 l5">
                                    <div class="switch">
                                        <label>
                                            {{ __('Nem') }}
                                            <input type="checkbox" name="in_quarantine" @if(old('in_quarantine') == 'on') checked @endif>
                                            <span class="lever"></span>
                                            {{ __('Igen') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col s12 m4 l4">
                            <div class="row">
                                <div class="input-field col s12 m7 l7">
                                    {{ __('Egyéb krónikus megbetegedésem van') }}:
                                </div>
                                <div class="input-field col s12 m5 l5">
                                    <div class="switch">
                                        <label>
                                            {{ __('Nem') }}
                                            <input type="checkbox" name="has_chronic" @if(old('has_chronic') == 'on') checked @endif>
                                            <span class="lever"></span>
                                            {{ __('Igen') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 m6 l6">
                            <div class="row">
                                <div class="input-field col s12 m6 l5">
                                    {{ __('Egyik sem (Egészséges vagyok)') }}:
                                </div>
                                <div class="input-field col s12 m6 l7">
                                    <div class="switch">
                                        <label>
                                            {{ __('Nem') }}
                                            <input type="checkbox" name="is_healthy" @if(old('is_healthy') == 'on') checked @endif>
                                            <span class="lever"></span>
                                            {{ __('Igen') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m6 l6">
                            <select id="help_types" name="help_types">
                                <option value="" disabled @if(old('help_types') == null) selected @endif>{{ __('Kérem válasszon') }}</option>
                                @foreach($help_types as $help)
                                    <option @if(old('help_types') == $help->id) selected @endif value="{{$help->id}}">{{$help->name}}</option>
                                @endforeach
                            </select>
                            <label for="help_types">{{ __('Segítségkérés oka') }}</label>
                        </div>
                        <div class="input-field col s12 m6 l6">
                            <textarea id="situation_desc" name="situation_desc" class="materialize-textarea" data-length="255">{{ old('situation_desc') }}</textarea>
                            <label for="situation_desc">{{ __('Szituáció rövid leírása') }}</label>
                        </div>
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
                            <button class="waves-effect waves-light btn-large" type="submit" name="action">{{ __('Regisztráció') }}
                                <i class="material-icons right">send</i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop