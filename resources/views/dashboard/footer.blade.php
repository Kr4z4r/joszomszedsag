<div class="app-wrapper-footer">
    <div class="app-footer">
        <div class="app-footer__inner">
            <div class="app-footer-left">
                <ul class="nav">
                    <li class="nav-item">
                        <a href="{{ route('legal') }}">{{ __('Jogi tájékoztató') }}</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('privacy') }}">{{ __('Adatvédelmi Nyilatkozat') }}</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('cookie') }}">{{ __('Cookie használati szabályzat') }}</a>
                    </li>
                </ul>
            </div>
            <div class="app-footer-right">
                <ul class="nav">
                    <li class="nav-item">
                        <span>&copy; {{ date('Y') }} - {{ __('Jószomszédság Vigyázó Hálózata') }} </span>
                        <a class="right" href="https://joszomszedsag.com" target="_blank">@include('helpers.logo')</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>