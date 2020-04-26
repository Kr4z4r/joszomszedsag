@extends('layout')
@section('title', 'Bejelentkezés')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col s12">
                <div class="card-panel hoverable">
                    <div class="card-content">
                        <div class="row">
                            <h4 class="card-title center-align">{{ __('auth.login') }}</h4>
                        </div>
                        <div class="row">
                            <div class="col s12 m6">
                                @error('email')
                                <span class="invalid-feedback red-text" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                @error('password')
                                <span class="invalid-feedback red-text" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="input-field col s12 m6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('auth.email') }}</label>
                                </div>
                                <div class="input-field col s12 m6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('auth.password') }}</label>
                                    <span class="helper-text red-text">{{ __('auth.first_login_pswd_text') }}</span>
                                </div>
                                <div class="input-field col s12 m12">
                                    <div class="form-check">
                                        <label>
                                            <input id="indeterminate-checkbox" class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <span>{{ __('auth.remember_me') }}</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="input-field col s12 m12 center-align">
                                    <button type="submit" class="btn btn-large btn-primary red z-depth-1" id="login_btn"><i class="material-icons right">send</i>{{ __('auth.login') }}</button>
                                    @if (Route::has('password.request'))
                                        <a class="btn btn-large waves-effect btn-flat red-flat text-black" id="forgotpassword_btn" href="{{ route('password.request') }}">{{ __('auth.forgot_password_q') }}</a>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
