<footer class="page-footer">
    @include('helpers.footer_logo')
    <div class="container">
        <div class="row">
            <div class="col l4 m4 s12">
                <h5>{{ \TCG\Voyager\Facades\Voyager::setting('site.organization_name') }}</h5>
                <p>{{ \TCG\Voyager\Facades\Voyager::setting('site.organization_slogan') }}</p>
                <ul>
                    <li>
                        <span class="d-inline-block">{!! \TCG\Voyager\Facades\Voyager::setting('site.organization_address') !!}</span>
                    </li>
                    <li>
                        <span class="d-inline-block"><i class="material-icons">phone</i></span>
                        <a href="tel:{{ \TCG\Voyager\Facades\Voyager::setting('site.organization_phone') }}">{{ \TCG\Voyager\Facades\Voyager::setting('site.organization_phone') }}</a>
                    </li>
                    <li>
                        <span class="d-inline-block"><i class="material-icons">chat</i></span>
                        <a href="mailto:{{ \TCG\Voyager\Facades\Voyager::setting('site.organization_email') }}">{{ \TCG\Voyager\Facades\Voyager::setting('site.organization_email') }}</a>
                    </li>
                </ul>
                
            </div>
            <div class="col l4 m4 s12">
                <ul>
                    <li class="svg-logo"><a href="#!">@include('helpers.footer_svg')</a></li>
                </ul>
            </div>
            <div class="col l4 m4 s12">
                <h5>{{ __('front.useful_links') }}</h5>
                <ul>
                    {{ menu('footer') }}
                </ul>
            </div>
        </div>
    </div>
    <div class="footer-copyright">
        <div class="container">
            <a class="left" href="{{route('error_reporting')}}">{{ __('front.error_reporting_title') }}</a>
            <div class="right">
                <span>&copy; {{ date('Y') }} - {{ __('front.jvh_name') }} </span>
                <a class="right" href="https://joszomszedsag.com" target="_blank">@include('helpers.logo')</a>
            </div>

        </div>
    </div>
</footer>