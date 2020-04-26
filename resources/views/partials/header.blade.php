<nav>
    <div class="nav-wrapper container">
        <a href="/" class="brand-logo">
            @if (\TCG\Voyager\Facades\Voyager::setting('site.logo'))
                <img src="{{ url('storage/'.\TCG\Voyager\Facades\Voyager::setting('site.logo')) }}" />
            @else
                @include('helpers.header_logo')
            @endif
        </a>
        <ul>
            <li><a href="#"><a class="waves-effect red btn-large login-button" href="{{ route('login') }}">{{ __('front.login') }}</a></a></li>
        </ul>
    </div>
</nav>