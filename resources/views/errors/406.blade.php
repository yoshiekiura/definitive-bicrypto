<!-- meta tags and other links -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $general->sitename($page_title ?? '406 | license is invalid') }}</title>
  <link rel="shortcut icon" type="image/png" href="{{getImage(imagePath()['logoIcon']['path'] .'/favicon.png')}}">
  <!-- bootstrap 4  -->
  <link rel="stylesheet" href="{{ asset('assets/errors/css/bootstrap.min.css') }}">
  <!-- dashdoard main css -->
  <link rel="stylesheet" href="{{ asset('assets/errors/css/main.css') }}">
</head>
  <body>


  <!-- error-406 start -->
  <div class="error">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-7 text-center">
          <img class="w-50" src="{{ asset('assets/errors/images/error-406.png') }}" alt="{{ __('locale.image')}}">
          <h2 class="title"><b>406</b> {{ __('locale.license is invalid')}}</h2>
          <p>{{ __("locale.please contact support.")}} <br> Skype (live:mashafeeq), or on Envato</p>
          <a href="https://codecanyon.net/user/mashdiv" class="cmn-btn mt-4">{{ __('locale.Contact Us')}}</a>
        </div>
      </div>
    </div>
  </div>
  <!-- error-406 end -->


  </body>
</html>
