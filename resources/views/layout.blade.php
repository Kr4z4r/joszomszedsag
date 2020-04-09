<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta name="env" content="{{ App::environment() }}">
    <meta name="token" content="{{ Session::token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Kezdőlap') - {{ \TCG\Voyager\Facades\Voyager::setting('site.title') }}</title>
    @include('helpers.css')
</head>
<body>
<div class="preloader">
    <svg xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.0" width="200px" height="200px" viewBox="0 0 128 128" xml:space="preserve"><script type="text/ecmascript" xlink:href="//faviconer.net/jscripts/smil.user.js"/><g><circle cx="16" cy="64" r="16" fill="#8b0000" fill-opacity="1"/><circle cx="16" cy="64" r="14.344" fill="#8b0000" fill-opacity="1" transform="rotate(45 64 64)"/><circle cx="16" cy="64" r="12.531" fill="#8b0000" fill-opacity="1" transform="rotate(90 64 64)"/><circle cx="16" cy="64" r="10.75" fill="#8b0000" fill-opacity="1" transform="rotate(135 64 64)"/><circle cx="16" cy="64" r="10.063" fill="#8b0000" fill-opacity="1" transform="rotate(180 64 64)"/><circle cx="16" cy="64" r="8.063" fill="#8b0000" fill-opacity="1" transform="rotate(225 64 64)"/><circle cx="16" cy="64" r="6.438" fill="#8b0000" fill-opacity="1" transform="rotate(270 64 64)"/><circle cx="16" cy="64" r="5.375" fill="#8b0000" fill-opacity="1" transform="rotate(315 64 64)"/><animateTransform attributeName="transform" type="rotate" values="0 64 64;315 64 64;270 64 64;225 64 64;180 64 64;135 64 64;90 64 64;45 64 64" calcMode="discrete" dur="800ms" repeatCount="indefinite"></animateTransform></g></svg>
</div>
@include('partials.header')
<div class="wrapper">
    @yield('content')
    <div class="push"></div>
</div>
@include('partials.footer')
@include('cookieConsent::index')
<div id="toTop"><i class="material-icons">arrow_drop_up</i></div>
</body>
@include('helpers.js')
@yield('extra_js', '')
</html>
