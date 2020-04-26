@extends('layout')
@section('title', 'Kezdőlap')
@section('content')
    <div class="row main-row">
        <div class="col s12">
            <div class="card">
                <div class="card-panel">
                    <div class="row">
                        <div class="col s12 l9">
                            <h1>{{ __('front.introduction_greeting') }}</h1>
                            <p>{{ __('front.introduction_block_1') }}</p>
                            <p>{{ __('front.introduction_block_2') }}</p>
                            <p class="font-weight-bold">{{ __('front.introduction_block_3') }}</p>
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
                    <span class="card-title">{{ __('front.ask_for_help') }}</span>
                    <p class="left-align">{{ __('front.ask_for_help_description') }}</p>
                    <p></p>
                    <a class="waves-effect waves-light btn-large" href="{{ route('segitseg-keres') }}"><span>{{ __('front.request_help_button') }}</span></a>
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
                    <span class="card-title">{{ __('front.volunteer') }}</span>
                    <p class="left-align">{{ __('front.volunteer_desc') }}</p>
                    <a class="waves-effect waves-light btn-large" href="{{ route('onkentes-regisztracio') }}"><span>{{ __('front.volunteer_button') }}</span></a>
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