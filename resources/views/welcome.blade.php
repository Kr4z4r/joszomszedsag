@extends('layout')
@section('title', 'Kezdőlap')
@section('content')
    <div class="row main-row">
        <div class="col s12">
            <div class="card">
                <div class="card-panel">
                    <div class="row">
                        <div class="col s12 l9">
                            <h1>{{ __('Drága Magyar Embertársak!') }}</h1>
                            <p>{{ __('Sokunkban felmerül a kérdés, hogyha a jövőben unokáink megkérdeznek minket: nagypapa-nagymama Te mit tettél a koronavírus járvány idején? Akkor mit fogunk felelni? Én azt akarom majd mondani, hogy segítettem, amennyi az erőmből tellett. Se nem többet, se nem kevesebbet.') }}</p>
                            <p>{{ __('Érezzük, hogy nehéz időket élünk, valamit tennünk kell. Itt az idő, a lehetőség és egyben kötelesség, hogy megszervezzük a Jószomszédságok Vigyázó Hálózatát. Tegyünk a közelünkben lakó rászorulókért!!!') }}</p>
                            <p class="font-weight-bold">{{ __('Mert senki sem maradhat egyedül.') }}</p>
                        </div>
                        <div class="col s12 l3">
                            <div class="logo center-align">
                                @include('helpers.logo')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="parallax-container">
        <div class="parallax"><img class="responsive-img" src="{{ asset('img/help.jpg') }}"></div>
    </div>
    <div class="row home-row">
        <div class="col s12 l6">
            <div class="card help_card hoverable">
                <div class="card-content center-align">
                    <span class="card-title">{{ __('Kérjen segítséget!') }}</span>
                    <p class="left-align">{{ __('Ha segítségre van szüksége, mert Ön idős, beteg, karanténban van vagy más problémája van, kérjen segítséget az Ön közelében élő Vigyázótól, aki felveszi Önnel a kapcsolatot.') }}</p>
                    <p></p>
                    <a class="waves-effect waves-light btn-large" href="{{ route('segitseg-keres') }}"><span>{{ __('Segítségkérés') }}</span></a>
                </div>
            </div>
        </div>
        <div class="col s12 show-on-medium-and-down hide-on-large-only">
            <div class="parallax-container ">
                <div class="parallax"><img class="responsive-img" src="{{ asset('img/help_2.jpg') }}"></div>
            </div>
        </div>

        <div class="col s12 l6">
            <div class="card volunteer_card hoverable">
                <div class="card-content center-align">
                    <span class="card-title">{{ __('Jelentkezzen Vigyázónak!') }}</span>
                    <p class="left-align">{{ __('Regisztráljon Ön is Vigyázónak, ha segítséget nyújtana rászoruló szomszédainak lakókörzetében!') }}</p>
                    <a class="waves-effect waves-light btn-large" href="{{ route('onkentes-regisztracio') }}"><span>{{ __('Jelentkezés Vigyázónak') }}</span></a>
                </div>
            </div>
        </div>
    </div>
    <div class="parallax-container hide-on-med-and-down">
        <div class="parallax"><img class="responsive-img" src="{{ asset('img/help_2.jpg') }}"></div>
    </div>
@stop

@section('extra_js')
<script type="text/javascript">
    $(document).ready(function () {
        $('.parallax').parallax();
    });
</script>
@endsection