@foreach($items as $menu_item)
    @if($menu_item->link() == route('admin_new_help_request', [], false))
        <li class="app-sidebar__heading">{{ __('Segítségkérések') }}</li>
    @elseif($menu_item->link() == route('admin_volunteers_list', [], false))
        <li class="app-sidebar__heading">{{ __('Képviselők') }}</li>
    @endif
    <li>
        <a href="{{ $menu_item->link() }}" @if( \Illuminate\Support\Facades\Request::path() == trim($menu_item->link(),'/'))class="mm-active"@endif>
            @if($menu_item->icon_class != '') <i class="{{ $menu_item->icon_class }}"></i> @endif
            {{ $menu_item->title }}
        </a>
    </li>
@endforeach