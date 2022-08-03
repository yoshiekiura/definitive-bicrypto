@stack('before-styles')
<link href="{{ mix('css/frontend/app.css') }}" rel="stylesheet">
@stack('after-styles')
<link rel="stylesheet" href="{{ asset('assets/frontends/default/css/style.css')}}">
<link rel="stylesheet" href="{{ asset(mix('assets/frontends/default/css/responsive.css'))}}">
