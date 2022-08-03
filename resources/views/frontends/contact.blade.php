@extends('frontend.layouts.pages')

@section('title', __('Contact Us'))

@section('content')
    <x-frontend.header
        title="Contact Us"
        subtitle="Get in touch and let us know how we can help. Fill out the form and we’ll be in touch as soon as possible."
        container-class="pb-9" />

    <x-utils.divider color="contrast" />

    @include("frontend.pages.contact.form")
    @include("frontend.pages.contact.other-channels")

@endsection

@section('footer')
    @include("frontend.blocks.footers.simple-3cols", [ "class" => "block bg-contrast", "containerClass" => "py-4" ])
@endsection
