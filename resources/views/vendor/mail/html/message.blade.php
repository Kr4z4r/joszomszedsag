@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])
@if (\TCG\Voyager\Facades\Voyager::setting('site.title'))
    {{ \TCG\Voyager\Facades\Voyager::setting('site.title') }}
@else
    {{ config('app.name') }}
@endif
@endcomponent
@endslot

{{-- Body --}}
{{ $slot }}

{{-- Subcopy --}}
@isset($subcopy)
@slot('subcopy')
@component('mail::subcopy')
{{ $subcopy }}
@endcomponent
@endslot
@endisset

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
© {{ date('Y') }} - {{__('Jószomszédság Vigyázó Hálózata')}}
@endcomponent
@endslot
@endcomponent
