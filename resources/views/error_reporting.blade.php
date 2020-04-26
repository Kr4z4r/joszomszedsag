@extends('layout')
@section('title', 'Hibabejelentés')

@section('content')
<div class="container">
    <div class="row">
        <div class="col s12">
            <form method="post" action="{{route('error_sending')}}" class="card-panel hoverable" autocomplete="{{ Str::random(16) }}">
                <div class="row">
                    <h4 class="center-align">{{ __('front.error_reporting_title') }}</h4>
                </div>
                @if(session('error_status'))
                    <div class="row">
                        @if(session('error_status') == 1)
                            <div class="alert alert-success teal lighten-2 white-text" role="alert" style="padding: 15px">
                                {{ session('message') }}
                            </div>
                        @else
                            <div class="alert alert-error red-text" role="alert" style="padding: 15px">
                                {{ session('message') }}
                            </div>
                        @endif
                    </div>
                @endif
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
                <div class="row">
                    <div class="input-field col s12 m12">
                        <input required name="email" id="email" type="email" class="validate" value="{{ old('email') }}">
                        <label for="email">{{ __('Email') }}</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <textarea required id="desc" name="desc" class="materialize-textarea validate">{{ old('desc') }}</textarea>
                        <label for="desc">{{ __('Szituáció rövid leírása') }}</label>
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
                        <button class="waves-effect waves-light btn-large red" type="submit" name="action">{{ __('front.send_error_report_button') }}
                            <i class="material-icons right">send</i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection