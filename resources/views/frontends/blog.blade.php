@extends('frontends.index')

@section('title', __('Blog'))
@section('content')
@php
    $page_title = "Blog";
@endphp
    <x-frontend.header
        title="Blog"
        subtitle="What our awesome community is talking about." />

    <x-utils.divider color="contrast" />

    <x-utils.container>
    <div class="row">
        <div class="col-lg-9 col-md-9">
            @yield('blogfront')
        </div>
        <div class="col-lg-3 col-md-3">
            @include('frontends.blog-sidebar')
        </div>
    </div>
</x-utils.container>
@endsection
