<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $general->sitename($page_title ?? '') }}</title>
    <link rel="shortcut icon" type="image/png" href="{{getImage(imagePath()['logoIcon']['path'] .'/favicon.png')}}">
    @include('frontends.'.$template->title.'.styles')

</head>
<body>
    <!-- ==========Preloader========== -->
    @if ($platform->frontend->preloader == 1)
    <div class="preloader">
        <div class="preloader-inner">
            <div class="preloader-icon">
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
    @endif
    <!-- ==========Preloader========== -->

    @include('frontends.'.$template->title.'.header')
    @yield('content')
    @include('frontends.'.$template->title.'.footer')

    <!--====== Scroll To Top Start ======-->
    <div id="scrollUp" title="Scroll To Top">
        <i class="fas fa-arrow-up"></i>
    </div>
    <!--====== Scroll To Top End ======-->

    @include('frontends.'.$template->title.'.scripts')
    @yield('page-script')
</body>
</html>
