@extends('frontend.layouts.pages')

@section('title', __('FAQs'))

@php ($team = [
    [ "name" => "Rafael Freeman", "position" => "Founder & CEO", "quote" => "Long time ago, this guy started it all.", "social" => ["facebook", "twitter", "dribbble"], "onStatic" => true ],
    [ "name" => "Aline De Souza", "position" => "Marketing Director", "quote" => "The girl that influences our products.", "social" => ["facebook", "twitter", "dribbble"], "onStatic" => true ],
    [ "name" => "Jayden Gardner", "position" => "Account Manager", "quote" => "The guy that keeps all the numbers in place.", "social" => ["facebook", "twitter", "dribbble"], "onStatic" => true ],
    [ "name" => "Jacobi Edwards", "position" => "VP of Sales", "quote" => "The man that leads the Global Sales team.", "social" => ["facebook", "twitter", "dribbble"], "onStatic" => true ],
    [ "name" => "Allison Fernandez", "position" => "Client Support", "quote" => "Need any assistance with the product?", "social" => ["facebook", "twitter", "dribbble"], "onStatic" => false ],
    [ "name" => "Richard Smith", "position" => "Lead Developer", "quote" => "Geek, manager, and manager of geeks.", "social" => ["facebook", "twitter", "dribbble"], "onStatic" => false ]
])

@section('content')
    <x-frontend.header
        title="About DashCore"
        subtitle="DashCore is an all purpose HTML template, it's packed with a multiple demos and tech stacks to help you get started with your project." />

    <x-utils.divider color="contrast" />

    @include ("frontend.pages.about.overview")
    @include ("frontend.pages.about.video")
    @include ("frontend.pages.about.solutions")

    @include ("frontend.blocks.counters.4", [ "class" => "bg-light"])

    <x-utils.divider color="darker" />

    @include ("frontend.pages.about.features-boxes")

    <x-utils.divider color="contrast" />

    @include ("frontend.pages.about.customers")

    @include ("frontend.blocks.team.1", [ "class" => "bg-light", "containerClass" => "bring-to-front", "heading" => true, "team" => $team ])

    @include ("frontend.pages.shared.brands-using", [ "class" => "bg-light", "title" => "They trust us" ])

    @include ("frontend.pages.shared.join-developer-designer")

    @include ("frontend.blocks.forms.register-input-group", [ "class" => "bg-contrast edge top-left border-bottom" ])
@endsection

@section('footer')
    @include("frontend.blocks.footers.4cols", [ "containerClass" => "pb-3" ])
@endsection
