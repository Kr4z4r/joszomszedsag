@extends('layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col s12">
            <div class="card-panel hoverable">
                <div class="card-content">
                    <div class="row">
                        <h4 class="card-title center-align">{{ __('Jelszó visszaállítás') }}</h4>
                    </div>
                    <div class="row">
                        @if (session('status'))
                            <div class="alert alert-success teal lighten-2 white-text" role="alert" style="padding: 15px">
                                {{ session('status') }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="input-field col s12">
                            <input id="email" type="email" class="validate form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-mail cím') }}</label>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="input-field col s12 l6">
                            <input id="password" type="password" class="validate form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Jelszó') }}</label>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="input-field col s12 l6">
                            <input id="password-confirm" type="password" class="validate form-control" name="password_confirmation" required autocomplete="new-password">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Jelszó újra') }}</label>
                        </div>
                        <div class="input-field col s12 m12 center-align">
                            <button type="submit" class="btn btn-large btn-primary red z-depth-1" id="reset_btn"><i class="material-icons right">send</i>{{ __('Mentés') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
