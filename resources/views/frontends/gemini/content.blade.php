@extends('frontends.index')

@section('content')
@if ($sections[0]->status == 1)
<header class="header section" id="home">
    <div class="shapes-container">
        <div class="static-shape shape-main cutout x2 bottom-right" data-aos="fade-down" data-aos-delay="300"></div>
    </div>

    <div class="container">
        <div class="row justify-content-between align-items-center my-4">
            <div class="col-md-6 text-center @rtl text-md-end @else text-md-start @endrtl">
                <h1 class="bold font-md display-lg-2 mt-3" data-aos="@rtl fade-left" @else fade-right @endrtl
                    data-aos-delay="100">{{$sections[0]->content->text1 }} <span
                        class="d-block">{{$sections[0]->content->text2 }}</span></h1>

                <p class="lead" data-aos="@rtl fade-left" @else fade-right @endrtl data-aos-delay="200">
                    {{$sections[0]->content->text3 }}</p>

                <div class="my-5" data-aos="@rtl fade-left" @else fade-right @endrtl data-aos-delay="400">
                    <a href="{{$sections[0]->content->btn1link }}"
                        class="btn btn-rounded btn-lg btn-black px-4 mx-auto @rtl ms-md-0 @else me-md-0 @endrtl">{{$sections[0]->content->btn1 }}
                        <i class="fas fa-long-arrow-alt-right ms-2"></i></a>
                </div>
            </div>

            <div class="col-md-6">
                <img src="{{ asset($images[1]->image)}}" style="max-width: 100%;" data-aos="fade-up" data-aos-delay="200"
                    alt="...">
            </div>
        </div>
    </div>
</header>
@endif

@if ($sections[1]->status == 1)
<x-utils.container style="margin: auto;background-color: rgb(247, 247, 247);">
    <div class="row gap-y align-items-center">
        <div class="col-md-6">
            <img src="{{ asset($images[2]->image)}}" style="max-width: 80%;" data-aos="fade-up" data-aos-delay="200"
                alt="...">
        </div>
        <div class="col-md-6">
            <div class="section-heading" data-aos="fade-up">
                <h2 class="heading-line bold"><span class="light">{{$sections[1]->content->text1 }}</span>
                    <br>{{$sections[1]->content->text2 }}</h2>
                <p class="lead">{{$sections[1]->content->text3 }}</p>
            </div>

            <a href="{{$sections[1]->content->btn1link }}"
                class="btn btn-rounded btn-outline-darker">{{$sections[1]->content->btn1 }}</a>
        </div>
    </div>
</x-utils.container>

@endif

@if ($sections[2]->status == 1)
<x-utils.container class="with-promo" id="gifts">
    <h2 class="heading-line bold"><span class="light">{{$sections[2]->content->text1 }}</span>
        <br>{{$sections[2]->content->text2 }}</h2>
    <div class="row gap-y align-items-center">
        <div class="col-md-6">
            <div>
                <h3 class="lead mb-1">{{$sections[2]->content->feature1title }}</h3>
                <p>{{$sections[2]->content->feature1text }}</p>
            </div>
            <div class="mt-5">
                <h3 class="lead mb-1">{{$sections[2]->content->feature2title }}</h3>
                <p>{{$sections[2]->content->feature2text }}</p>
            </div>
        </div>
        <div class="col-md-6">
            <div>
                <h3 class="lead mb-1">{{$sections[2]->content->feature3title }}</h3>
                <p>{{$sections[2]->content->feature3text }}</p>
            </div>
            <div class="mt-5">
                <h3 class="lead mb-1">{{$sections[2]->content->feature4title }}</h3>
                <p>{{$sections[2]->content->feature4text }}</p>
            </div>
        </div>
    </div>
</x-utils.container>

@endif

@if ($sections[3]->status == 1)
<x-utils.container style="margin: auto;background-color: rgb(247, 247, 247);">
    <div class="row gap-y align-items-center">
        <div class="col-md-6">
            <img src="{{ asset($images[3]->image)}}" style="max-width: 80%;" data-aos="fade-up" data-aos-delay="200"
                alt="...">
        </div>
        <div class="col-md-6">
            <div class="section-heading" data-aos="fade-up">
                <h2 class="heading-line bold"><span class="light">{{$sections[1]->content->text1 }}</span>
                    <br>{{$sections[1]->content->text2 }}</h2>
                <p class="lead">{{$sections[1]->content->text3 }}</p>
            </div>

            <a href="{{$sections[1]->content->btn1link }}"
                class="btn btn-rounded btn-outline-darker">{{$sections[1]->content->btn1 }}</a>
        </div>
    </div>
</x-utils.container>
@endif

@if ($sections[4]->status == 1)
<x-utils.container class="bg-black" style="margin: auto;">
    <div class="text-center">
        <h1 class="text-white bold mb-3"><br>{{$sections[1]->content->text1 }}</h1>
        <h3 class="text-white bold mb-3"><span class="light">{{$sections[1]->content->text2 }}</span></h3>
        <a href="{{$sections[1]->content->btn1link }}"
            class="btn btn-rounded btn-info">{{$sections[1]->content->btn1 }}</a>
    </div>
</x-utils.container>
@endif
@endsection
