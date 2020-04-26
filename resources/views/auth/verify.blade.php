@extends('layout')
@section('title', 'E-mail cím megerősítés - '.config('app.name'))
@section('content')
    <div class="card-panel hoverable">
        <div class="card-content">
            <div class="row">
                <h4 class="card-title center-align">{{ __('auth.confirm_email') }}</h4>
            </div>
            <div class="row">
                <div class="col s12 m12">
                    @if (session('resent'))
                        <div class="alert alert-success teal lighten-2 white-text" role="alert" style="padding: 15px">
                            {{ __('auth.confirm_email_sent') }}
                        </div>
                    @endif
                </div>
            </div>
            <div class="row">
                <h6>{{ __('auth.confirm_email_before_continue') }}</h6>
                <h6>{{ __('auth.check_confirm_email') }}:</h6>
                <form method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <div class="input-field col s12 m12 center-align">
                        <button type="submit" class="btn btn-large btn-primary z-depth-1"><i class="material-icons right">send</i>{{ __('auth.resend_confirm_email') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
