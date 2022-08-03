@extends('frontends.index')

@section('title', __('Blog'))

@section('content')
@php
    $page_title = "Blog";
@endphp
    @include("frontends.blog.heading.fullscreen")
    @include("blogetc::partials.show_errors")
    @include("frontends.blog.post")
@endsection

