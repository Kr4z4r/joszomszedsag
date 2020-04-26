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
                    <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                        <span class="btn-icon-wrapper">
                            <i class="fa fa-ellipsis-v fa-w-6"></i>
                        </span>
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
                            <a href="{{ route('logout') }}" class="btn red" onclick="event.preventDefault();document.getElementById('logout-form').submit()">{{ __('dashboard.logout') }}</a>
                            <form id="logout-form" method="post" action="{{route('logout')}}" style="display: none"> @csrf </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>