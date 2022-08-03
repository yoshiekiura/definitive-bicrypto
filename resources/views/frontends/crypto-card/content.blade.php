@extends('frontends.index')

@section('content')
@if ($sections[0]->status == 1)
<!-- Banners Start -->
<div class="banner wow fadeInUp" data-wow-duration="0.3s" data-wow-delay="0.3s" id="home" style="background-image: url('{{ asset($images[0]->image)}}')">
    <img class="bg-sape" src="{{ asset($images[1]->image)}}" alt="">
    <div class="hero-area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-6 col-lg-10 text-center text-xl-start">
                    <div class="banner-content">
                        <h3 class="subtitle wow fadeInDown" data-wow-duration="0.3s" data-wow-delay="0.3s">{{$sections[0]->content->text1}}</h3>
                        <h1 class="head wow fadeInDown" data-wow-duration="0.3s" data-wow-delay="0.3s">{{$sections[0]->content->text2}}</h1>
                        <p class="text wow fadeInDown" data-wow-duration="0.3s" data-wow-delay="0.3s">
                            {{$sections[0]->content->text3}}
                        </p>
                        <div class="link-box wow fadeInUp" data-wow-duration="0.3s" data-wow-delay="0.3s">
                            <a href="{{$sections[0]->content->btn1link}}" class="button-1 one"> <i class="fas fa-cart-plus m-1"></i> {{$sections[0]->content->btn1}}</a>
                            <a href="{{$sections[0]->content->btn2link}}" class="button-1 two"> <i class="fas fa-exchange-alt m-1"></i> {{$sections[0]->content->btn2}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if ($sections[1]->status == 1)
<!-- Steps Start -->
<div class="steps" id="about">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-xl-8 col-lg-10 text-center">
                <div class="section-head">
                    <h3 class="subtitle wow fadeInDown" data-wow-duration="0.5s" data-wow-delay="0.4s">{{$sections[1]->content->text1 }}</h3>
                    <h2 class="title wow fadeInDown" data-wow-duration="0.5s" data-wow-delay="0.4s">{{$sections[1]->content->text2 }}</h2>
                    <p class="text wow fadeInDown" data-wow-duration="0.5s" data-wow-delay="0.4s">{{$sections[1]->content->text3 }}</p>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInDown" data-wow-duration="0.3s" data-wow-delay="0.4s">
                <div class="steps-box">
                    <div class="thumb-box one d-flex align-items-center justify-content-center">
                        <img src="{{ asset($images[2]->image)}}" alt="" class="arrow">
                        <div class="icon">
                            <img src="{{ asset($images[3]->image)}}" alt="">
                        </div>
                    </div>
                    <h4 class="lasthead">{{$sections[1]->content->text4 }}</h4>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInDown" data-wow-duration="0.4s" data-wow-delay="0.4s">
                <div class="steps-box">
                    <div class="thumb-box two d-flex align-items-center justify-content-center">
                        <img src="{{ asset($images[4]->image)}}" alt="" class="arrow">
                        <div class="icon">
                            <img src="{{ asset($images[5]->image)}}" alt="">
                        </div>
                    </div>
                    <h4 class="lasthead">{{$sections[1]->content->text5 }}</h4>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInDown" data-wow-duration="0.5s" data-wow-delay="0.4s">
                <div class="steps-box">
                    <div class="thumb-box three d-flex align-items-center justify-content-center">
                        <img src="{{ asset($images[6]->image)}}" alt="" class="arrow">
                        <div class="icon">
                            <img src="{{ asset($images[7]->image)}}" alt="">
                        </div>
                    </div>
                    <h4 class="lasthead">{{$sections[1]->content->text6 }}</h4>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInDown" data-wow-duration="0.6s" data-wow-delay="0.4s">
                <div class="steps-box">
                    <div class="thumb-box four d-flex align-items-center justify-content-center">
                        <div class="icon">
                            <img src="{{ asset($images[8]->image)}}" alt="">
                        </div>
                    </div>
                    <h4 class="lasthead">{{$sections[1]->content->text7 }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if ($sections[2]->status == 1)
<!-- feature1 Start -->
<div class="feature"  id="features">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-xl-6 d-none d-xl-block">
                <div class="pic wow fadeInLeft" data-wow-duration="0.5s" data-wow-delay="0.4s">
                    <img src="{{ asset($images[9]->image)}}" alt="" class="fimg-1">
                </div>
            </div>
            <div class="col-xl-6 text-xl-start text-center">
                <div class="section-head">
                    <div class="icon d-flex align-items-center justify-content-center wow fadeInDown" data-wow-duration="0.5s" data-wow-delay="0.4s">
                        <img src="{{ asset($images[10]->image)}}" alt="">
                    </div>
                    <h2 class="title wow fadeInDown" data-wow-duration="0.5s" data-wow-delay="0.4s">{{$sections[2]->content->text1 }}</h2>
                    <p class="text wow fadeInDown" data-wow-duration="0.5s" data-wow-delay="0.4s">{{$sections[2]->content->text2 }}</p>
                    <a href="{{$sections[2]->content->btn1link }}" class="button-1 button wow fadeInDown" data-wow-duration="0.5s" data-wow-delay="0.4s"> <i class="fas fa-cart-plus m-1"></i>{{$sections[2]->content->btn1 }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if ($sections[3]->status == 1)
<!-- feature2 Start -->
<div class="feature two">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-xl-6 text-xl-start text-center">
                <div class="section-head">
                    <div class="icon d-flex align-items-center justify-content-center wow fadeInDown" data-wow-duration="0.5s" data-wow-delay="0.4s">
                        <img src="{{ asset($images[11]->image)}}" alt="">
                    </div>
                    <h2 class="title wow fadeInDown" data-wow-duration="0.5s" data-wow-delay="0.4s">{{$sections[3]->content->text1 }}</h2>
                    <p class="text wow fadeInDown" data-wow-duration="0.5s" data-wow-delay="0.4s">
                        {{$sections[3]->content->text2 }}
                    </p>
                    <a href="{{$sections[3]->content->btn1link }}" class="button-1 button wow fadeInDown" data-wow-duration="0.5s" data-wow-delay="0.4s">
                        <i class="fas fa-cart-plus m-1"></i>
                        {{$sections[3]->content->btn1 }}</a>
                </div>
            </div>
            <div class="col-xl-6 d-none d-xl-block">
                <div class="pic wow fadeInRight" data-wow-duration="0.5s" data-wow-delay="0.4s">
                    <img src="{{ asset($images[12]->image)}}" alt="" class="fimg-2">
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if ($sections[4]->status == 1)
<!-- feature3 Start -->
<div class="feature three">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-xl-6 d-none d-xl-block">
                <div class="pic wow fadeInLeft" data-wow-duration="0.5s" data-wow-delay="0.4s">
                    <img src="{{ asset($images[13]->image)}}" alt="" class="fimg-3">
                </div>
            </div>
            <div class="col-xl-6 text-xl-start text-center">
                <div class="section-head">
                    <div class="icon d-flex align-items-center justify-content-center wow fadeInDown" data-wow-duration="0.5s" data-wow-delay="0.4s">
                        <img src="{{ asset($images[14]->image)}}" alt="">
                    </div>
                    <h2 class="title wow fadeInDown" data-wow-duration="0.5s" data-wow-delay="0.4s">{{$sections[4]->content->text1 }}</h2>
                    <p class="text wow fadeInDown" data-wow-duration="0.5s" data-wow-delay="0.4s">{{$sections[4]->content->text2 }}
                    </p>
                    <a href="{{ $sections[4]->content->btn1link }}" class="button-1 button wow fadeInDown" data-wow-duration="0.5s" data-wow-delay="0.4s">
                        <i class="fas fa-cart-plus m-1"></i>
                        {{$sections[4]->content->btn1 }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if ($sections[5]->status == 1)
<!-- feature4 Start -->
<div class="feature four">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-xl-6 text-xl-start text-center">
                <div class="section-head">
                    <div class="icon d-flex align-items-center justify-content-center wow fadeInDown" data-wow-duration="0.5s" data-wow-delay="0.4s">
                        <img src="{{ asset($images[15]->image)}}" alt="">
                    </div>
                    <h2 class="title wow fadeInDown" data-wow-duration="0.5s" data-wow-delay="0.4s">{{$sections[5]->content->text1 }}</h2>
                    <p class="text">{{$sections[5]->content->text2 }}
                    </p>
                    <a href="{{$sections[5]->content->btn1link }}" class="button-1 button wow fadeInDown" data-wow-duration="0.5s" data-wow-delay="0.4s">
                        <i class="fas fa-cart-plus m-1"></i>
                        {{$sections[5]->content->btn1 }}</a>
                </div>
            </div>
            <div class="col-xl-6 d-none d-xl-block">
                <div class="pic wow fadeInRight" data-wow-duration="0.5s" data-wow-delay="0.4s">
                    <img src="{{ asset($images[16]->image)}}" alt="" class="fimg-4">
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if ($sections[6]->status == 1)
<!-- Our Card Start -->
<div class="card-type" id="order" >
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-xxl-10 col-lg-12 text-center">
                <div class="section-head">
                    <h3 class="subtitle wow fadeInDown" data-wow-duration="0.5s" data-wow-delay="0.4s">{{$sections[6]->content->text1 }}</h3>
                    <h2 class="title wow fadeInDown" data-wow-duration="0.5s" data-wow-delay="0.4s">{{$sections[6]->content->text2 }}</h2>
                    <p class="text wow fadeInUP" data-wow-duration="0.5s" data-wow-delay="0.4s">{{$sections[6]->content->text3 }}
                    </p>
                </div>
            </div>
        </div>
        <div class="row justify-content-xl-between justify-content-center">
            <div class="col-xxl-3 col-xl-4 col-lg-6 wow fadeInUp" data-wow-duration="0.3s" data-wow-delay="0.4s">
                <div class="card-box">
                    <img src="{{ asset($images[17]->image)}}" class="thumb" alt="">
                    <div class="last-content">
                        <h5>{{$sections[6]->content->card1 }}</h5>
                        <a href="{{$sections[6]->content->btn1link }}" class="button-1 button"><i class="fas fa-cart-plus m-1"></i> {{$sections[6]->content->btn1 }}</a>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-xl-4 col-lg-6 wow fadeInUp" data-wow-duration="0.4s" data-wow-delay="0.4s">
                <div class="card-box three">
                    <img src="{{ asset($images[18]->image)}}" class="thumb" alt="">
                    <div class="last-content">
                        <h5>{{$sections[6]->content->card2 }}</h5>
                        <a href="{{$sections[6]->content->btn2link }}" class="button-1 button"><i class="fas fa-cart-plus m-1"></i> {{$sections[6]->content->btn1 }}</a>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-xl-4  col-lg-6 wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.4s">
                <div class="card-box three">
                    <img src="{{ asset($images[19]->image)}}" class="thumb" alt="">
                    <div class="last-content">
                        <h5>{{$sections[6]->content->card3 }}</h5>
                        <a href="{{$sections[6]->content->btn3link }}" class="button-1 button"><i class="fas fa-cart-plus m-1"></i> {{$sections[6]->content->btn3 }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if ($sections[7]->status == 1)
<!-- pricing Start -->
<div class="pricing" id="pricing">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-xl-6 col-lg-8 text-center">
                <div class="section-head">
                    <h3 class="subtitle wow fadeInDown" data-wow-duration="0.5s" data-wow-delay="0.4s">{{$sections[7]->content->text1 }}</h3>
                    <h2 class="title wow fadeInDown" data-wow-duration="0.5s" data-wow-delay="0.4s">{{$sections[7]->content->text2 }}</h2>
                    <p class="text wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.4s">
                        {{$sections[7]->content->text3 }}
                    </p>
                </div>
            </div>
        </div>
        <div class="row gx-0 justify-content-center">
            <div class="col-xl-4 col-lg-6 wow fadeInLeft" data-wow-duration="0.4s" data-wow-delay="0.4s">
                <div class="pricing-box">
                    <div class="top-content">
                        <h4 class="lasthead">{{$sections[7]->content->card1 }}</h4>
                        <div class="thumb">
                            <img src="{{ asset($images[20]->image)}}" alt="">
                        </div>
                    </div>
                    <ul class="list">
                        <li class="list-item">
                            <span class="one">{{$sections[7]->content->card1item1a }}</span>
                            <span class="two">{{$sections[7]->content->card1item1b }}</span>
                        </li>
                        <li class="list-item">
                            <span class="one">{{$sections[7]->content->card1item2a }}</span>
                            <span class="two">{{$sections[7]->content->card1item2b }}</span>
                        </li>
                        <li class="list-item">
                            <span class="one">{{$sections[7]->content->card1item3a }}</span>
                            <span class="two">{{$sections[7]->content->card1item3b }}</span>
                        </li>
                        <li class="list-item">
                            <span class="one">{{$sections[7]->content->card1item4a }}</span>
                            <span class="two">{{$sections[7]->content->card1item4b }}</span>
                        </li>
                        <li class="list-item">
                            <span class="one">{{$sections[7]->content->card1item5a }}</span>
                            <span class="two">{{$sections[7]->content->card1item5b }}</span>
                        </li>

                    </ul>
                    <a href="{{$sections[7]->content->btn1link }}" class="button-1 button ">
                        <i class="fas fa-cart-plus m-1"></i>
                        {{$sections[7]->content->btn1 }}</a>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6 wow fadeInDown" data-wow-duration="0.4s" data-wow-delay="0.4s">
                <div class="pricing-box active">
                    <div class="top-content">
                        <h4 class="lasthead">{{$sections[7]->content->card2 }}
                        </h4>
                        <div class="thumb">
                            <img src="{{ asset($images[21]->image)}}" alt="">
                        </div>
                    </div>
                    <ul class="list">
                        <li class="list-item">
                            <span class="one">{{$sections[7]->content->card2item1a }}</span>
                            <span class="two">{{$sections[7]->content->card2item1b }}</span>
                        </li>
                        <li class="list-item">
                            <span class="one">{{$sections[7]->content->card2item2a }}</span>
                            <span class="two">{{$sections[7]->content->card2item2b }}</span>
                        </li>
                        <li class="list-item">
                            <span class="one">{{$sections[7]->content->card2item3a }}</span>
                            <span class="two">{{$sections[7]->content->card2item3b }}</span>
                        </li>
                        <li class="list-item">
                            <span class="one">{{$sections[7]->content->card2item4a }}</span>
                            <span class="two">{{$sections[7]->content->card2item4b }}</span>
                        </li>
                        <li class="list-item">
                            <span class="one">{{$sections[7]->content->card2item5a }}</span>
                            <span class="two">{{$sections[7]->content->card2item5b }}</span>
                        </li>

                    </ul>
                    <a href="{{$sections[7]->content->btn2link }}" class="button-1 button ">
                        <i class="fas fa-cart-plus m-1"></i>
                        {{$sections[7]->content->btn2 }}</a>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6 wow fadeInRight" data-wow-duration="0.4s" data-wow-delay="0.4s">
                <div class="pricing-box three">
                    <div class="top-content">
                        <h4 class="lasthead">{{$sections[7]->content->card3 }}</h4>
                        <div class="thumb">
                            <img src="{{ asset($images[22]->image)}}" alt="">
                        </div>
                    </div>
                    <ul class="list">
                        <li class="list-item">
                            <span class="one">{{$sections[7]->content->card3item1a }}</span>
                            <span class="two">{{$sections[7]->content->card3item1b }}</span>
                        </li>
                        <li class="list-item">
                            <span class="one">{{$sections[7]->content->card3item2a }}</span>
                            <span class="two">{{$sections[7]->content->card3item2b }}</span>
                        </li>
                        <li class="list-item">
                            <span class="one">{{$sections[7]->content->card3item3a }}</span>
                            <span class="two">{{$sections[7]->content->card3item3b }}</span>
                        </li>
                        <li class="list-item">
                            <span class="one">{{$sections[7]->content->card3item4a }}</span>
                            <span class="two">{{$sections[7]->content->card3item4b }}</span>
                        </li>
                        <li class="list-item">
                            <span class="one">{{$sections[7]->content->card3item5a }}</span>
                            <span class="two">{{$sections[7]->content->card3item5b }}</span>
                        </li>

                    </ul>
                    <a href="{{$sections[7]->content->btn3link }}" class="button-1 button ">
                        <i class="fas fa-cart-plus m-1"></i>
                        {{$sections[7]->content->btn3 }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if ($sections[8]->status == 1)
<!-- faq Start -->
<div class="faq" id="faq">
    <img src="{{ asset($images[23]->image)}}" alt="" class="fdot-1">
    <img src="{{ asset($images[24]->image)}}" alt="" class="fdot-2">
    <img src="{{ asset($images[25]->image)}}" alt="" class="fdot-3">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="section-head">
                    <h3 class="subtitle wow fadeInDown" data-wow-duration="0.5s" data-wow-delay="0.4s">{{$sections[8]->content->text1 }}</h3>
                    <h2 class="title wow fadeInDown" data-wow-duration="0.5s" data-wow-delay="0.4s">{{$sections[8]->content->text2 }}</h2>
                    <p class="text wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.4s">
                        {{$sections[8]->content->text3 }}
                    </p>
                    <a href="{{$sections[8]->content->btn1link }}" class="button button-1 wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.4s">{{$sections[8]->content->btn1 }}</a>
                </div>
            </div>
        </div>
        <div class="row align-items-center justify-content-between">
            <div class="col-xl-8">
                <div class="faq-box">
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item wow fadeInDown" data-wow-duration="0.5s" data-wow-delay="0.4s">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                    <img src="{{ asset($images[26]->image)}}" alt="" class="icon">
                                    {{$sections[8]->content->faq1 }}
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    {{$sections[8]->content->faq1a }}
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item wow fadeInDown" data-wow-duration="0.5s" data-wow-delay="0.4s">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    <img src="{{ asset($images[27]->image)}}" alt="" class="icon">
                                    {{$sections[8]->content->faq2 }}
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    {{$sections[8]->content->faq2a }}
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item wow fadeInDown" data-wow-duration="0.5s" data-wow-delay="0.4s">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseThree" aria-expanded="false"
                                    aria-controls="collapseThree">
                                    <img src="{{ asset($images[28]->image)}}" alt="" class="icon">
                                    {{$sections[8]->content->faq3 }}
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse"
                                aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    {{$sections[8]->content->faq3a }}
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item wow fadeInDown" data-wow-duration="0.5s" data-wow-delay="0.4s">
                            <h2 class="accordion-header" id="headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseFour" aria-expanded="false"
                                    aria-controls="collapseFour">
                                    <img src="{{ asset($images[29]->image)}}" alt="" class="icon">
                                    {{$sections[8]->content->faq4 }}
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    {{$sections[8]->content->faq4a }}
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item wow fadeInDown" data-wow-duration="0.5s" data-wow-delay="0.4s">
                            <h2 class="accordion-header" id="headingFive">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseFive" aria-expanded="false"
                                    aria-controls="collapseFive">
                                    <img src="{{ asset($images[30]->image)}}" alt="" class="icon">
                                    {{$sections[8]->content->faq5 }}
                                </button>
                            </h2>
                            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    {{$sections[8]->content->faq5a }}
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item wow fadeInDown" data-wow-duration="0.5s" data-wow-delay="0.4s">
                            <h2 class="accordion-header" id="headingSix">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                    <img src="{{ asset($images[31]->image)}}" alt="" class="icon">
                                    {{$sections[8]->content->faq6 }}
                                </button>
                            </h2>
                            <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    {{$sections[8]->content->faq6a }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 d-none d-xl-block">
                <div class="fpic wow fadeInRight" data-wow-duration="0.5s" data-wow-delay="0.4s">
                    <img src="{{ asset($images[32]->image)}}" alt="" class="faq-img">
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if ($sections[9]->status == 1)
<!-- subscribe Start -->
<div class="subscribe">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="content-box" style="background-image: url('{{ asset($images[33]->image)}}')">
                    <div class="content wow fadeInDown" data-wow-duration="0.5s" data-wow-delay="0.4s">
                        <h3 class="title">{{$sections[9]->content->text1 }}</h3>
                        <p class="text">{{$sections[9]->content->text2 }}</p>
                    </div>
                    <div class="input-box wow fadeInDown" data-wow-duration="0.5s" data-wow-delay="0.4s">
                        <form action="#">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <input type="text" placeholder="Enter Your Email" class="form-control">
                                        <button class="button-1">Subscribe</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
