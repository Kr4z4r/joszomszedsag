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
            <li>
                <a class='dropdown-trigger waves-effect btn-small lang-button' data-target='lang_select_dropdown'>
                    <span class="lang_selector_long_name">{{ language()->getName() }}</span>
                    <span class="lang_selector_short_code">{{ language()->getCode() }}</span>
                </a>
                <ul id="lang_select_dropdown" class="dropdown-content">
                    @foreach (language()->allowed() as $code => $name)
                        <li><a href="{{ language()->back($code) }}">{{ language()->flag($code) }}</a></li>
                    @endforeach
                </ul>
            </li>
            <li><a href="#"><a class="waves-effect red btn-large login-button" href="{{ route('login') }}">{{ __('front.login') }}</a></a></li>
        </ul>
    </div>
</nav>