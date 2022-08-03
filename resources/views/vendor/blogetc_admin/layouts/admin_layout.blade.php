@extends('layouts.app')
<?php $page_title = "" ?>
@section('page-style')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
<div id="app">
    {{-- {{route("blogetc.index")}} --}}
            <div class="row" style="margin-top:-30px;">
                <div class="col-lg-3 col-md-4 col-sm-6">
                    @include("blogetc_admin::layouts.sidebar")
                </div>
                <div class="col-lg-9 col-md-8 col-sm-6">
                    @if (isset($errors) && count($errors))
                        <div class="alert alert-danger">
                            <b>Sorry, but there was an error:</b>
                            <ul class="m-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    {{--REPLACING THIS FILE WITH YOUR OWN LAYOUT FILE? Don't forget to include the following section!--}}
                    @if(\WebDevEtc\BlogEtc\Helpers::hasFlashedMessage())
                        <div class="alert alert-info">
                            <h3>{{\WebDevEtc\BlogEtc\Helpers::pullFlashedMessage() }}</h3>
                        </div>
                    @endif

                    @yield('blog')
                </div>
            </div>
</div>

@endsection

@section('page-script')
@if( config("blogetc.use_wysiwyg") && config("blogetc.echo_html") && (in_array( Request::route()->getName() ,[ 'admin.blogetc.admin.create_post' , 'admin.blogetc.admin.edit_post'  ])))
<script src="https://cdn.ckeditor.com/4.17.1/standard/ckeditor.js"></script>

<script>
  if (typeof (CKEDITOR) !== 'undefined') {
    CKEDITOR.replace('post_body');
  }
</script>
@endif
@endsection
