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
                        <div class="row">
                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf
                                <div class="input-field col s12 m12">
                                    <input id="email" type="email" class="validate form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail cím') }}</label>
                                    @error('email')
                                    <span class="invalid-feedback red-text" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                                <div class="input-field col s12 center-align">
                                    <button type="submit" id="password_btn" class="btn btn-large red"><i class="material-icons right">send</i>{{ __('Email küldése') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
