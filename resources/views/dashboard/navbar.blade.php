<div class="app-header header-shadow">
    <div class="app-header__logo">
        <div class="logo-src">
            <a href="{{ route('admin_home') }}">
                @if (\TCG\Voyager\Facades\Voyager::setting('site.logo'))
                    <img src="{{ url('storage/'.\TCG\Voyager\Facades\Voyager::setting('site.logo')) }}" />
                @else
                    @include('helpers.header_logo')
                @endif
            </a>
        </div>
        <div class="header__pane ml-auto">
            <div>
                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <div class="app-header__mobile-menu">
        <div>
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
            </button>
        </div>
    </div>
    <div class="app-header__menu">
                <span>
                    <button type="button" class="waves-effect btn-small mobile-toggle-header-nav">
                        Settings
                    </button>
                </span>
    </div>
    <div class="app-header__content">
        <div class="app-header-right">
            <div class="header-btn-lg pr-0">
                <div class="widget-content p-0">
                    <div class="widget-content-wrapper">
                        <div class="widget-content-left text-center">
                            <a href="{{ route('admin_profile') }}">
                                <div class="d-inline-block widget-heading">
                                    {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                                    <div class="widget-subheading">{{ $current_user->user_role }}</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="app-header-right">
            <div class="header-btn-lg pr-0">
                <div class="widget-content p-0">
                    <div class="widget-content-wrapper">
                        <div class="widget-content-left text-center">
                            <a class='dropdown-trigger waves-effect btn-small lang-button' data-target='lang_select_dropdown_admin'>
                                <span class="lang_selector_short_code">{{ language()->getCode() }}</span>
                            </a>
                            <ul id="lang_select_dropdown_admin" class="dropdown-content">
                                @foreach (language()->allowed() as $code => $name)
                                    <li><a href="{{ language()->back($code) }}">{{ language()->flag($code) }}</a></li>
                                @endforeach
                            </ul>
                            <a href="{{ route('logout') }}" class="btn red" onclick="event.preventDefault();document.getElementById('logout-form').submit()"><i class="material-icons">power_settings_new</i></a>
                            <form id="logout-form" method="post" action="{{route('logout')}}" style="display: none"> @csrf </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>