@isset($pageConfigs)
    {!! updatePageConfig($pageConfigs) !!}
@endisset

<!DOCTYPE html>
@php
$configData = applClasses();
@endphp

<html
    class="loading
@if (Request::is('admin**')) {{ $configData['theme'] === 'light' ? '' : $configData['layoutTheme'] }}"
    @if ($configData['theme'] === 'dark') data-layout="dark-layout" @endif
@else
{{ $configData['themeuser'] === 'light' ? '' : $configData['layoutThemeUser'] }}"
    @if ($configData['themeuser'] === 'light') data-layout="light" @endif @endif
lang="@if (session()->has('locale')) {{ session()->get('locale') }}@else{{ $configData['defaultLanguage'] }} @endif"
data-textdirection="{{ env('MIX_CONTENT_DIRECTION') === 'rtl' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $general->sitename($page_title ?? '') }}</title>
    @if (Request::is('user**'))
        @include('partials.seo')
    @endif
    <link rel="shortcut icon" type="image/png" href="{{ getImage(imagePath()['logoIcon']['path'] . '/favicon.png') }}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap">
    @include('panels/styles')
</head>
</body>
@yield('app')
@if (getPlatform('system')->sw == 1)
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/service-worker.js');
            });
        }
    </script>
@endif
</body>

</html>
