<tr>
        <td class="header">
                <a href="{{ $url }}" style="display: inline-block;">
                        @if (\TCG\Voyager\Facades\Voyager::setting('site.logo'))
                                <img src="{{ url('storage/'.\TCG\Voyager\Facades\Voyager::setting('site.logo')) }}" class="logo" alt="{{ \TCG\Voyager\Facades\Voyager::setting('site.title') }}" />
                        @else
                                <img src="{{ asset('img/logo.png') }}" class="logo" alt="{{ \TCG\Voyager\Facades\Voyager::setting('site.title') ?? config('app.name') }}" style="width: 200px;height: auto;" />
                        @endif
                </a>
        </td>
</tr>
