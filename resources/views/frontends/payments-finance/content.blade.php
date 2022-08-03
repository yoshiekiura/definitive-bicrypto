@extends('frontends.index')

@section('content')
@if ($sections[0]->status == 1)
<!-- Banners Start -->
<div class="banner" id="home" style="background-image: url('{{ asset($images[0]->image)}}">
    <img class="bg-sape" src="{{ asset($images[1]->image)}}" alt="">
    <div class="tree-1"> <img src="{{ asset($images[2]->image)}}" alt=""> </div>
    <div class="tree-2"> <img src="{{ asset($images[3]->image)}}" alt=""> </div>
    <div class="hero-area">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-xxl-6 col-xl-7 col-lg-10">
                    <div class="banner-content">
                        <h1 class="head wow fadeInDown" data-wow-duration="0.3s" data-wow-delay="0.3s">
                            {{$sections[0]->content->text1}}</h1>
                        <p class="text wow fadeInDown" data-wow-duration="0.3s" data-wow-delay="0.3s">
                            {{ siteName() }} {{$sections[0]->content->text2}}
                        </p>
                        <a href="{{$sections[0]->content->btn1link}}" class="button button-1 wow fadeInDown"
                            data-wow-duration="0.3s" data-wow-delay="0.3s">{{$sections[0]->content->btn1}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if ($sections[1]->status == 1)
<!-- partner Start -->
<div class="partner">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="content wow fadeInDown" data-wow-duration="0.3s" data-wow-delay="0.3s">
                    <h3 class="subtitle">{{ $sections[1]->content->text1 }}</h3>
                </div>
            </div>
            <div class="col-12">
                <div class="partner-box owl-carousel owl-theme">
                    <div class="single-partner item wow fadeInDown" data-wow-duration="0.2s" data-wow-delay="0.3s">
                        <a href="#" class="partner-thumb">
                            <img src="{{ asset($images[4]->image)}}" alt="">
                        </a>
                    </div>
                    <div class="single-partner item wow fadeInDown" data-wow-duration="0.3s" data-wow-delay="0.3s">
                        <a href="#" class="partner-thumb">
                            <img src="{{ asset($images[5]->image)}}" alt="">
                        </a>
                    </div>
                    <div class="single-partner item wow fadeInDown" data-wow-duration="0.4s" data-wow-delay="0.3s">
                        <a href="#" class="partner-thumb">
                            <img src="{{ asset($images[6]->image)}}" alt="">
                        </a>
                    </div>
                    <div class="single-partner item wow fadeInDown" data-wow-duration="0.5s" data-wow-delay="0.3s">
                        <a href="#" class="partner-thumb">
                            <img src="{{ asset($images[7]->image)}}" alt="">
                        </a>
                    </div>
                    <div class="single-partner item wow fadeInDown" data-wow-duration="0.6s" data-wow-delay="0.3s">
                        <a href="#" class="partner-thumb">
                            <img src="{{ asset($images[8]->image)}}" alt="">
                        </a>
                    </div>
                    <div class="single-partner item wow fadeInDown" data-wow-duration="0.7s" data-wow-delay="0.3s">
                        <a href="#" class="partner-thumb">
                            <img src="{{ asset($images[9]->image)}}" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if ($sections[2]->status == 1)
<!-- Control Start -->
<div class="control">
    <div class="bg">
        <img src="{{ asset($images[10]->image)}}" alt="" class="control-bg">
        <img src="{{ asset($images[11]->image)}}" alt="" class="sape-1">
        <img src="{{ asset($images[12]->image)}}" alt="" class="sape-2">
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12 text-center wow fadeInDown" data-wow-duration="0.3s" data-wow-delay="0.3s">
                <div class="section-head">
                    <h2 class="title">{{ $sections[2]->content->text1 }}</h2>
                    <p class="text">
                        {{ $sections[2]->content->text2 }}
                    </p>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 text-center wow fadeInDown" data-wow-duration="0.3s" data-wow-delay="0.3s">
                <div class="control-box">
                    <div class="tumb">
                        <img src="{{ asset($images[13]->image)}}" alt="">
                    </div>
                    <h3 class="subtitle">{{ $sections[2]->content->text3 }}</h3>
                    <p class="text">
                        {{ $sections[2]->content->text4 }}
                    </p>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 text-center wow fadeInDown" data-wow-duration="0.4s" data-wow-delay="0.3s">
                <div class="control-box">
                    <div class="tumb">
                        <img src="{{ asset($images[14]->image)}}" alt="">
                    </div>
                    <h3 class="subtitle">{{ $sections[2]->content->text5 }}</h3>
                    <p class="text">
                        {{ $sections[2]->content->text6 }}
                    </p>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 text-center wow fadeInDown" data-wow-duration="0.5s" data-wow-delay="0.3s">
                <div class="control-box">
                    <div class="tumb">
                        <img src="{{ asset($images[15]->image)}}" alt="">
                    </div>
                    <h3 class="subtitle">{{ $sections[2]->content->text7 }}</h3>
                    <p class="text">
                        {{ $sections[2]->content->text8 }}
                    </p>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 text-center wow fadeInDown" data-wow-duration="0.6s" data-wow-delay="0.3s">
                <div class="control-box">
                    <div class="tumb">
                        <img src="{{ asset($images[16]->image)}}" alt="">
                    </div>
                    <h3 class="subtitle">{{ $sections[2]->content->text9 }}</h3>
                    <p class="text">
                        {{ $sections[2]->content->text10 }}
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="videoo">
                    <img src="{{ asset($images[17]->image)}}" alt="" class="video-ilstation">
                    <img src="{{ asset($images[18]->image)}}" alt="" class="video-bg">
                    <div class="video-box">
                        <div class="video-img wow fadeInDown" data-wow-duration="0.3s" data-wow-delay="0.3s">
                            <a class="youtube-video mfp-iframe video-play-btn video-icon"
                                href="{{ $sections[2]->content->youtubelink }}">
                                <i class="fas fa-play"></i>
                            </a>
                        </div>
                        <div class="video-text wow fadeInDown" data-wow-duration="0.3s" data-wow-delay="0.3s">
                            <p class="text">{{ $sections[2]->content->videotext }}</p>
                            <span><i class="far fa-clock"></i> {{ $sections[2]->content->videolength }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if ($sections[3]->status == 1)
<!-- feature Start -->
<div class="feature one" id="features">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-xxl-7 col-lg-6 d-none d-lg-block">
                <div class="pic wow fadeInLeft" data-wow-duration="0.3s" data-wow-delay="0.3s">
                    <img src="{{ asset($images[19]->image)}}" alt="" class="feature-img">
                </div>
            </div>
            <div class="col-xxl-5 col-lg-6">
                <div class="section-head">
                    <h2 class="title wow fadeInDown" data-wow-duration="0.3s" data-wow-delay="0.3s">
                        {{ $sections[3]->content->text1 }}</h2>
                    <p class="text wow fadeInDown" data-wow-duration="0.3s" data-wow-delay="0.3s">
                        {{ $sections[3]->content->text2 }}
                    </p>
                    <ul class="list">
                        <li class="list-item wow fadeInDown" data-wow-duration="0.3s" data-wow-delay="0.3s">
                            <span class="icon"><img src="{{ asset($images[20]->image)}}" alt=""></span>
                            <div class="content">
                                <h3 class="subtitle">{{ $sections[3]->content->text3 }}</h3>
                                <p class="text">{{ $sections[3]->content->text4 }}</p>
                            </div>
                        </li>
                        <li class="list-item wow fadeInDown" data-wow-duration="0.3s" data-wow-delay="0.3s">
                            <span class="icon"><img src="{{ asset($images[21]->image)}}" alt=""></span>
                            <div class="content">
                                <h3 class="subtitle">{{ $sections[3]->content->text5 }}</h3>
                                <p class="text">{{ $sections[3]->content->text6 }}</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if ($sections[4]->status == 1)
<!-- feature Start -->
<div class="feature two">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-xxl-5 col-lg-6">
                <div class="section-head">
                    <h2 class="title wow fadeInDown" data-wow-duration="0.3s" data-wow-delay="0.3s">
                        {{ $sections[4]->content->text1 }}</h2>
                    <p class="text wow fadeInDown" data-wow-duration="0.3s" data-wow-delay="0.3s">
                        {{ $sections[4]->content->text2 }}
                    </p>

                    <ul class="list">
                        <li class="list-item wow fadeInDown" data-wow-duration="0.3s" data-wow-delay="0.3s">
                            <span class="icon"><img src="{{ asset($images[22]->image)}}" alt=""></span>
                            <div class="content">
                                <h3 class="subtitle">{{ $sections[4]->content->text3 }}</h3>
                                <p class="text">{{ $sections[4]->content->text4 }}</p>
                            </div>
                        </li>
                        <li class="list-item wow fadeInDown" data-wow-duration="0.3s" data-wow-delay="0.3s">
                            <span class="icon"><img src="{{ asset($images[23]->image)}}" alt=""></span>
                            <div class="content">
                                <h3 class="subtitle">{{ $sections[4]->content->text5 }}</h3>
                                <p class="text">{{ $sections[4]->content->text6 }}</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-xxl-7  col-lg-6 d-none d-lg-block">
                <div class="pic wow fadeInRight" data-wow-duration="0.3s" data-wow-delay="0.3s">
                    <img src="{{ asset($images[24]->image)}}" alt="" class="feature-img">
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if ($sections[5]->status == 1)
<!-- pricing Start -->
<div class="pricing" id="pricing">
    <img src="{{ asset($images[25]->image)}}" class="pricing-bg" alt="">
    <img src="{{ asset($images[26]->image)}}" class="shape-1" alt="">
    <img src="{{ asset($images[27]->image)}}" class="shape-2" alt="">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="section-head wow fadeInDown" data-wow-duration="0.3s" data-wow-delay="0.3s">
                    <h2 class="title">{{ $sections[5]->content->text1 }}</h2>
                    <p class="text">
                        {{ $sections[5]->content->text2 }}
                    </p>
                </div>
            </div>
        </div>
        <div class="row  justify-content-center">
            <div class="col-lg-4 col-md-6 col-sm-10 wow fadeInLeft" data-wow-duration="0.3s" data-wow-delay="0.3s">
                <div class="pricing-item" style="background: url('{{ asset($images[28]->image)}}')">
                    <div class="circle circle-1" data-paroller-factor="0.1" data-paroller-type="foreground"
                        data-paroller-direction="vertical"> <img src="{{ asset($images[29]->image)}}" alt=""> </div>
                    <div class="circle circle-2" data-paroller-factor="0.1" data-paroller-type="foreground"
                        data-paroller-direction="horizontal"> <img src="{{ asset($images[30]->image)}}" alt=""> </div>
                    <div class="circle circle-3" data-paroller-factor="-0.1" data-paroller-type="foreground"
                        data-paroller-direction="vertical"> <img src="{{ asset($images[31]->image)}}" alt=""> </div>
                    <div class="circle circle-4" data-paroller-factor="0.1" data-paroller-type="foreground"
                        data-paroller-direction="horizontal"> <img src="{{ asset($images[32]->image)}}" alt=""> </div>
                    <div class="circle circle-5" data-paroller-factor="0.1" data-paroller-type="foreground"
                        data-paroller-direction="vertical"> <img src="{{ asset($images[33]->image)}}" alt=""> </div>
                    <div class="pricing-header">
                        <span class="name">{{ $sections[5]->content->price1type }}</span>
                        <h2 class="title"><sup>$</sup>{{ $sections[5]->content->price1 }}</h2>
                        <span class="info">{{ $sections[5]->content->price1period }}</span>
                    </div>
                    <div class="pricing-body">
                        <ul>
                            <li>
                                {{ $sections[5]->content->text6 }}
                            </li>
                            <li>
                                {{ $sections[5]->content->text7 }}
                            </li>
                            <li>
                                {{ $sections[5]->content->text8 }}
                            </li>
                            <li>
                                {{ $sections[5]->content->text9 }}
                            </li>
                            <li>
                                {{ $sections[5]->content->text10 }}
                            </li>
                        </ul>
                    </div>
                    <div class="pricing-footer text-center">
                        <a href="{{ $sections[5]->content->btn1link }}"
                            class="button-1">{{ $sections[5]->content->btn1 }}</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-10 wow fadeIn" data-wow-duration="0.45s" data-wow-delay="0.4s">
                <div class="pricing-item two" style="background: url('{{ asset($images[34]->image)}}')">
                    <div class="circle circle-1" data-paroller-factor="0.1" data-paroller-type="foreground"
                        data-paroller-direction="vertical"> <img src="{{ asset($images[35]->image)}}" alt=""> </div>
                    <div class="circle circle-2" data-paroller-factor="0.1" data-paroller-type="foreground"
                        data-paroller-direction="horizontal"> <img src="{{ asset($images[36]->image)}}" alt=""> </div>
                    <div class="circle circle-3" data-paroller-factor="-0.1" data-paroller-type="foreground"
                        data-paroller-direction="vertical"> <img src="{{ asset($images[37]->image)}}" alt=""> </div>
                    <div class="circle circle-4" data-paroller-factor="0.1" data-paroller-type="foreground"
                        data-paroller-direction="horizontal"> <img src="{{ asset($images[38]->image)}}" alt=""> </div>
                    <div class="circle circle-5" data-paroller-factor="0.1" data-paroller-type="foreground"
                        data-paroller-direction="vertical"> <img src="{{ asset($images[39]->image)}}" alt=""> </div>
                    <div class="pricing-header">
                        <span class="name">{{ $sections[5]->content->price2type }}</span>
                        <h2 class="title"><sup>$</sup>{{ $sections[5]->content->price2 }}</h2>
                        <span class="info">{{ $sections[5]->content->price2period }}</span>
                    </div>
                    <div class="pricing-body">
                        <ul>
                            <li>
                                {{ $sections[5]->content->text14 }}
                            </li>
                            <li>
                                {{ $sections[5]->content->text15 }}
                            </li>
                            <li>
                                {{ $sections[5]->content->text16 }}
                            </li>
                            <li>
                                {{ $sections[5]->content->text17 }}
                            </li>
                            <li>
                                {{ $sections[5]->content->text18 }}
                            </li>
                        </ul>
                    </div>
                    <div class="pricing-footer text-center">
                        <a href="{{ $sections[5]->content->btn2link }}"
                            class="button-1">{{ $sections[5]->content->btn2 }}</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-10 wow fadeInRight" data-wow-duration="0.3s" data-wow-delay="0.3s">
                <div class="pricing-item" style="background: url('{{ asset($images[40]->image)}}')">
                    <div class="circle circle-1" data-paroller-factor="0.12" data-paroller-type="foreground"
                        data-paroller-direction="vertical"> <img src="{{ asset($images[41]->image)}}" alt=""> </div>
                    <div class="circle circle-2" data-paroller-factor="0.1" data-paroller-type="foreground"
                        data-paroller-direction="horizontal"> <img src="{{ asset($images[42]->image)}}" alt=""> </div>
                    <div class="circle circle-3" data-paroller-factor="-0.1" data-paroller-type="foreground"
                        data-paroller-direction="vertical"> <img src="{{ asset($images[43]->image)}}" alt=""> </div>
                    <div class="circle circle-4" data-paroller-factor="0.1" data-paroller-type="foreground"
                        data-paroller-direction="horizontal"> <img src="{{ asset($images[44]->image)}}" alt=""> </div>
                    <div class="circle circle-5" data-paroller-factor="0.1" data-paroller-type="foreground"
                        data-paroller-direction="vertical"> <img src="{{ asset($images[45]->image)}}" alt=""> </div>
                    <div class="pricing-header">
                        <span class="name">{{ $sections[5]->content->price3type }}</span>
                        <h2 class="title"><sup>$</sup>{{ $sections[5]->content->price3 }}</h2>
                        <span class="info">{{ $sections[5]->content->price3period }}</span>
                    </div>
                    <div class="pricing-body">
                        <ul>
                            <li>
                                {{ $sections[5]->content->text22 }}
                            </li>
                            <li>
                                {{ $sections[5]->content->text23 }}
                            </li>
                            <li>
                                {{ $sections[5]->content->text24 }}
                            </li>
                            <li>
                                {{ $sections[5]->content->text25 }}
                            </li>
                            <li>
                                {{ $sections[5]->content->text26 }}
                            </li>
                        </ul>
                    </div>
                    <div class="pricing-footer text-center">
                        <a href="{{ $sections[5]->content->btn3link }}"
                            class="button-1">{{ $sections[5]->content->btn3 }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if ($sections[6]->status == 1)
<!-- Testomonial Start -->
<div class="testomonial" id="testomonial">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="testobox owl-carousel owl-theme">
                    <div class="single item">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-md-5">
                                <div class="image wow fadeInLeft" data-wow-duration="0.3s" data-wow-delay="0.3s">
                                    <img src="{{ asset($images[46]->image)}}" alt="">
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="section-head">
                                    <h2 class="title wow fadeInDown" data-wow-duration="0.3s" data-wow-delay="0.3s">
                                        "{{ siteName() }} {{ $sections[6]->content->text1 }}"</h2>
                                    <p class="text wow fadeInDown" data-wow-duration="0.3s" data-wow-delay="0.3s">
                                        {{ $sections[6]->content->text2 }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="single item">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-md-5">
                                <div class="image wow fadeInLeft" data-wow-duration="0.3s" data-wow-delay="0.3s">
                                    <img src="{{ asset($images[47]->image)}}" alt="">
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="section-head">
                                    <h2 class="title wow fadeInDown" data-wow-duration="0.3s" data-wow-delay="0.3s">
                                        "{{ siteName() }} {{ $sections[6]->content->text3 }}"</h2>
                                    <p class="text wow fadeInDown" data-wow-duration="0.3s" data-wow-delay="0.3s">
                                        {{ $sections[6]->content->text4 }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="single item">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-md-5">
                                <div class="image wow fadeInLeft" data-wow-duration="0.3s" data-wow-delay="0.3s">
                                    <img src="{{ asset($images[48]->image)}}" alt="">
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="section-head">
                                    <h2 class="title wow fadeInDown" data-wow-duration="0.3s" data-wow-delay="0.3s">
                                        "{{ siteName() }} {{ $sections[6]->content->text5 }}"</h2>
                                    <p class="text wow fadeInDown" data-wow-duration="0.3s" data-wow-delay="0.3s">
                                        {{ $sections[6]->content->text6 }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="single item">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-md-5">
                                <div class="image wow fadeInLeft" data-wow-duration="0.3s" data-wow-delay="0.3s">
                                    <img src="{{ asset($images[49]->image)}}" alt="">
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="section-head">
                                    <h2 class="title wow fadeInDown" data-wow-duration="0.3s" data-wow-delay="0.3s">
                                        "{{ siteName() }} {{ $sections[6]->content->text7 }}"</h2>
                                    <p class="text wow fadeInDown" data-wow-duration="0.3s" data-wow-delay="0.3s">
                                        {{ $sections[6]->content->text8 }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 wow fadeInDown" data-wow-duration="0.3s" data-wow-delay="0.3s">
                <a href="{{ $sections[6]->content->btn1link }}"
                    class="button button-1">{{ $sections[6]->content->btn1 }}</a>
            </div>
        </div>
    </div>
</div>
@endif

@if ($sections[7]->status == 1)
<!-- FAQ Start -->
<div class="faq" id="faq">
    <img src="{{ asset($images[50]->image)}}" alt="" class="fdot-1">
    <img src="{{ asset($images[51]->image)}}" alt="" class="fdot-2">
    <img src="{{ asset($images[52]->image)}}" alt="" class="fdot-3">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="section-head wow fadeInDown" data-wow-duration="0.4s" data-wow-delay="0.5s">
                    <h2 class="title">{{ $sections[7]->content->text1 }}</h2>
                    <p class="text">
                        {{ $sections[7]->content->text2 }}, <a href="#" class="link">contact us</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="row align-items-center justify-content-between">
            <div class="col-xl-8">
                <div class="faq-box">
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item wow fadeInDown" data-wow-duration="0.4s" data-wow-delay="0.5s">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                    <img src="{{ asset($images[53]->image)}}" alt="" class="icon">
                                    {{ $sections[7]->content->text3 }}
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    {{ $sections[7]->content->text4 }}
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item wow fadeInDown" data-wow-duration="0.4s" data-wow-delay="0.5s">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    <img src="{{ asset($images[54]->image)}}" alt="" class="icon">
                                    {{ $sections[7]->content->text5 }}
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    {{ $sections[7]->content->text6 }}
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item wow fadeInDown" data-wow-duration="0.4s" data-wow-delay="0.5s">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    <img src="{{ asset($images[55]->image)}}" alt="" class="icon">
                                    {{ $sections[7]->content->text7 }}
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    {{ $sections[7]->content->text8 }}
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item wow fadeInDown" data-wow-duration="0.4s" data-wow-delay="0.5s">
                            <h2 class="accordion-header" id="headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    <img src="{{ asset($images[56]->image)}}" alt="" class="icon">
                                    {{ $sections[7]->content->text9 }}
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    {{ $sections[7]->content->text10 }}
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item wow fadeInDown" data-wow-duration="0.4s" data-wow-delay="0.5s">
                            <h2 class="accordion-header" id="headingFive">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                    <img src="{{ asset($images[57]->image)}}" alt="" class="icon">
                                    {{ $sections[7]->content->text11 }}
                                </button>
                            </h2>
                            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    {{ $sections[7]->content->text12 }}
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item wow fadeInDown" data-wow-duration="0.4s" data-wow-delay="0.5s">
                            <h2 class="accordion-header" id="headingSix">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                    <img src="{{ asset($images[58]->image)}}" alt="" class="icon">
                                    {{ $sections[7]->content->text13 }}
                                </button>
                            </h2>
                            <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    {{ $sections[7]->content->text14 }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 d-none d-xl-block">
                <div class="fpic wow fadeInRight" data-wow-duration="0.4s" data-wow-delay="0.5s">
                    <img src="{{ asset($images[59]->image)}}" alt="" class="faq-girl">
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if ($sections[8]->status == 1)
<!-- tril Start -->
<div class="tril" id="contact">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="content" style="background: url('{{ asset($images[60]->image)}}')">
                    <div class="row justify-content-center">
                        <div class="col-lg-8 text-center">
                            <div class="section-head">
                                <h2 class="title wow fadeInDown" data-wow-duration="0.4s" data-wow-delay="0.5s">
                                    {{ $sections[8]->content->text1 }}</h2>
                                <p class="text wow fadeInDown" data-wow-duration="0.4s" data-wow-delay="0.5s">
                                    {{ $sections[8]->content->text2 }}</p>
                                <a href="{{ $sections[8]->content->btn1link }}" class="button button-1 wow fadeInDown"
                                    data-wow-duration="0.4s" data-wow-delay="0.5s">
                                    {{ $sections[8]->content->btn1 }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
