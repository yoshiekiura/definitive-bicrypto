@extends('frontends.index')

@section('content')
@if ($sections[0]->status == 1)
<!-- Banners Start -->
<div class="banner" id="home" style="background-image: url('{{ asset($images[0]->image)}}')">
    <div class="hero-area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-6 col-lg-8">
                    <div class="banner-content">
                        <h3 class="subtitle wow fadeInUp" data-wow-duration="0.3s" data-wow-delay="0.3s">{{$sections[0]->content->text1 }}
                            {{ siteName() }}</h3>
                        <h1 class="head wow fadeInUp" data-wow-duration="0.3s" data-wow-delay="0.3s">{{$sections[0]->content->text2 }}</h1>
                        <p class="text wow fadeInUp" data-wow-duration="0.3s" data-wow-delay="0.3s">
                            {{$sections[0]->content->text3 }}
                        </p>
                        <a href="{{$sections[0]->content->btn1link }}" class="button button-1 wow fadeInUp" data-wow-duration="0.3s"
                            data-wow-delay="0.3s">{{$sections[0]->content->btn1 }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if ($sections[1]->status == 1)
<!-- Compare Start -->
<div class="compare" id="currency">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="coin-box owl-carousel owl-theme">
                    <div class="compare-box item wow fadeInUp" data-wow-duration="0.3s" data-wow-delay="0.3s">
                        <div class="single">
                            <div class="icon">
                                <div class="avatar avatar-xl">
                                    <img src="{{getImage('assets/images/cryptoCurrency/'. strtolower($sections[1]->content->coin1symbol).'.png')}}"
                                        alt="{{__($sections[1]->content->coin1name)}}">
                                </div>
                                <p class="text">{{$sections[1]->content->coin1name }} <span>{{$sections[1]->content->coin1symbol }}</span></p>
                            </div>
                            <h4 class="lasthead" id="ticker1">$10,260.74</h4>
                            <p class="text">Price</p>
                        </div>
                    </div>
                    <div class="compare-box item wow fadeInUp" data-wow-duration="0.4s" data-wow-delay="0.3s">
                        <div class="single">
                            <div class="icon">
                                <div class="avatar avatar-xl">
                                    <img src="{{getImage('assets/images/cryptoCurrency/'. strtolower($sections[1]->content->coin2symbol).'.png')}}"
                                        alt="{{__($sections[1]->content->coin2name)}}">
                                </div>
                                <p class="text">{{$sections[1]->content->coin2name }} <span>{{$sections[1]->content->coin2symbol }}</span></p>
                            </div>
                            <h4 class="lasthead" id="ticker2">$352.72</h4>
                            <p class="text">Price</p>
                        </div>
                    </div>
                    <div class="compare-box item wow fadeInUp" data-wow-duration="0.4s" data-wow-delay="0.3s">
                        <div class="single">
                            <div class="icon">
                                <div class="avatar avatar-xl">
                                    <img src="{{getImage('assets/images/cryptoCurrency/'. strtolower($sections[1]->content->coin3symbol).'.png')}}"
                                        alt="{{__($sections[1]->content->coin3name)}}">
                                </div>
                                <p class="text">{{$sections[1]->content->coin3name }} <span>{{$sections[1]->content->coin3symbol }}</span></p>
                            </div>
                            <h4 class="lasthead" id="ticker3">$48.24</h4>
                            <p class="text">Price</p>
                        </div>
                    </div>
                    <div class="compare-box item wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.3s">
                        <div class="single">
                            <div class="icon">
                                <div class="avatar avatar-xl">
                                    <img src="{{getImage('assets/images/cryptoCurrency/'. strtolower($sections[1]->content->coin4symbol).'.png')}}"
                                        alt="{{__($sections[1]->content->coin4name)}}">
                                </div>
                                <p class="text">{{$sections[1]->content->coin4name }} <span>{{$sections[1]->content->coin4symbol }}</span></p>
                            </div>
                            <h4 class="lasthead" id="ticker4">$68.64</h4>
                            <p class="text">Price</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if ($sections[2]->status == 1)
<!-- feature Start -->
<div class="feature" id="feature">
    <div class="shap">
        <img src="{{ asset($images[5]->image)}}" alt="" class="fshap">
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xl-6">
                <div class="upper-content">
                    <h4 class="lasthead wow fadeInUp" data-wow-duration="0.3s" data-wow-delay="0.3s">{{$sections[2]->content->text1 }} {{ siteName() }}
                        </h4>
                    <h2 class="title wow fadeInUp" data-wow-duration="0.3s" data-wow-delay="0.3s">{{$sections[2]->content->text2 }}</h2>
                    <p class="text wow fadeInUp" data-wow-duration="0.3s" data-wow-delay="0.3s">
                        {{$sections[2]->content->text3 }}
                    </p>
                    <a href="{{$sections[2]->content->btn1link }}" class="button button-1 wow fadeInUp" data-wow-duration="0.3s"
                        data-wow-delay="0.3s">{{$sections[2]->content->btn1 }}</a>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="row">
                    <div class="col-lg-6 wow fadeInUp" data-wow-duration="0.3s" data-wow-delay="0.3s">
                        <div class="feature-box one">
                            <div class="tumb">
                                <img src="{{ asset($images[6]->image)}}" alt="">
                            </div>
                            <p class="text">
                                {{$sections[2]->content->feature1 }}
                            </p>

                        </div>
                    </div>
                    <div class="col-lg-6 wow fadeInUp" data-wow-duration="0.4s" data-wow-delay="0.3s">
                        <div class="feature-box two">
                            <div class="tumb">
                                <img src="{{ asset($images[7]->image)}}" alt="">
                            </div>
                            <p class="text">
                                {{$sections[2]->content->feature2 }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6 wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.3s">
                        <div class="feature-box three">
                            <div class="tumb">
                                <img src="{{ asset($images[8]->image)}}" alt="">
                            </div>
                            <p class="text">
                                {{$sections[2]->content->feature3 }}
                            </p>

                        </div>
                    </div>
                    <div class="col-lg-6 wow fadeInUp" data-wow-duration="0.6s" data-wow-delay="0.3s">
                        <div class="feature-box four">
                            <div class="tumb">
                                <img src="{{ asset($images[9]->image)}}" alt="">
                            </div>
                            <p class="text">
                                {{$sections[2]->content->feature4 }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endif

@if ($sections[3]->status == 1)
<!-- Deposit Start -->
<div class="deposit" id="deposit" style="background-image: url('{{ asset($images[10]->image)}}')">
    <div class="sape">
        <img src="{{ asset($images[11]->image)}}" alt="" class="rdot-1">
        <img src="{{ asset($images[12]->image)}}" alt="" class="rdot-2">
        <img src="{{ asset($images[13]->image)}}" alt="" class="rdot-3">
    </div>

    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-lg-8 m-auto">
                <div class="upper-content text-center wow fadeInUp" data-wow-duration="0.3s" data-wow-delay="0.3s">
                    <h4 class="lasthead">{{$sections[3]->content->text1 }}</h4>
                    <h2 class="title">{{$sections[3]->content->text2 }}</h2>
                    <p class="text">
                        {{$sections[3]->content->text3 }}
                    </p>
                </div>
            </div>
            <div class="col-12">
                <div class="offer">
                    <h3 class="subtitle">{{$sections[3]->content->offerText }}</h3>
                    <div class="offer-box" style="background-image: url('{{ asset($images[14]->image)}}')">
                        <div class="offer-item wow fadeInUp" data-wow-duration="0.3s" data-wow-delay="0.3s">
                            <div class="icon">
                                <img src="{{ asset($images[15]->image)}}" alt="" class="offer-icon">
                            </div>
                            <div class="content">
                                <h2 class="pursent">{{$sections[3]->content->offer1profit }}</h2>
                                <p class="text">{{$sections[3]->content->offer1period }}</p>
                            </div>
                        </div>
                        <div class="arrow wow fadeInUp" data-wow-duration="0.3s" data-wow-delay="0.3s">
                            <img src="{{ asset($images[16]->image)}}" alt="" class="arrow-pic">
                        </div>
                        <div class="offer-item wow fadeInUp" data-wow-duration="0.3s" data-wow-delay="0.3s">
                            <div class="icon">
                                <img src="{{ asset($images[17]->image)}}" alt="" class="offer-icon">
                            </div>
                            <div class="content">
                                <h2 class="pursent">{{$sections[3]->content->offer2profit }}</h2>
                                <p class="text">{{$sections[3]->content->offer2period }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if ($sections[4]->status == 1)
<!-- Earning Start -->
<div class="earningpartners" id="earning">
    <div class="bg">
        <img src="{{ asset($images[18]->image)}}" alt="" class="dp-bg">
    </div>
    <div class="deposit-amounts">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3 class="subtitle wow fadeInUp" data-wow-duration="0.3s" data-wow-delay="0.3s">{{$sections[4]->content->text1 }}</h3>
                    <div class="coin-box">
                        <div class="item wow fadeInUp" data-wow-duration="0.3s" data-wow-delay="0.3s">
                            <div class="tumb">
                                <img src="{{getImage('assets/images/cryptoCurrency/'. strtolower($sections[4]->content->deposit1symbol).'.png')}}">
                            </div>
                            <p class="text">{{$sections[4]->content->deposit1amount }} {{$sections[4]->content->deposit1symbol }}</p>
                        </div>
                        <div class="item wow fadeInUp" data-wow-duration="0.3s" data-wow-delay="0.3s">
                            <div class="tumb">
                                <img src="{{getImage('assets/images/cryptoCurrency/'. strtolower($sections[4]->content->deposit2symbol).'.png')}}">
                            </div>
                            <p class="text">{{$sections[4]->content->deposit2amount }} {{$sections[4]->content->deposit2symbol }}</p>
                        </div>
                        <div class="item wow fadeInUp" data-wow-duration="0.3s" data-wow-delay="0.3s">
                            <div class="tumb">
                                <img src="{{getImage('assets/images/cryptoCurrency/'. strtolower($sections[4]->content->deposit3symbol).'.png')}}">
                            </div>
                            <p class="text">{{$sections[4]->content->deposit3amount }} {{$sections[4]->content->deposit3symbol }}</p>
                        </div>
                        <div class="item wow fadeInUp" data-wow-duration="0.3s" data-wow-delay="0.3s">
                            <div class="tumb">
                                <img src="{{getImage('assets/images/cryptoCurrency/'. strtolower($sections[4]->content->deposit4symbol).'.png')}}">
                            </div>
                            <p class="text">{{$sections[4]->content->deposit4amount }} {{$sections[4]->content->deposit4symbol }}</p>
                        </div>
                        <div class="item wow fadeInUp" data-wow-duration="0.3s" data-wow-delay="0.3s">
                            <div class="tumb">
                                <img src="{{getImage('assets/images/cryptoCurrency/'. strtolower($sections[4]->content->deposit5symbol).'.png')}}">
                            </div>
                            <p class="text">{{$sections[4]->content->deposit5amount }} {{$sections[4]->content->deposit5symbol }}</p>
                        </div>
                        <div class="item wow fadeInUp" data-wow-duration="0.3s" data-wow-delay="0.3s">
                            <div class="tumb">
                                <img src="{{getImage('assets/images/cryptoCurrency/'. strtolower($sections[4]->content->deposit6symbol).'.png')}}">
                            </div>
                            <p class="text">{{$sections[4]->content->deposit6amount }} {{$sections[4]->content->deposit6symbol }}</p>
                        </div>
                        <div class="item wow fadeInUp" data-wow-duration="0.3s" data-wow-delay="0.3s">
                            <div class="tumb">
                                <img src="{{getImage('assets/images/cryptoCurrency/'. strtolower($sections[4]->content->deposit7symbol).'.png')}}">
                            </div>
                            <p class="text">{{$sections[4]->content->deposit7amount }} {{$sections[4]->content->deposit7symbol }}</p>
                        </div>
                        <div class="item wow fadeInUp" data-wow-duration="0.3s" data-wow-delay="0.3s">
                            <div class="tumb">
                                <img src="{{getImage('assets/images/cryptoCurrency/'. strtolower($sections[4]->content->deposit8symbol).'.png')}}">
                            </div>
                            <p class="text">{{$sections[4]->content->deposit8amount }} {{$sections[4]->content->deposit8symbol }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="earning">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="content text-center">
                        <div class="content">
                            <h2 class="title wow fadeInUp" data-wow-duration="0.3s" data-wow-delay="0.3s">{{$sections[4]->content->text2 }}</h2>
                            <div class="compare-box">
                                <div class="item wow fadeInUp" data-wow-duration="0.3s" data-wow-delay="0.3s">
                                    <div class="country">
                                        <img src="{{getImage('assets/images/cryptoCurrency/'. strtolower($sections[4]->content->earning1symbol).'.png')}}">
                                        <div class="language-select">
                                            <select class="select-bar">
                                                <option value="">{{$sections[4]->content->earning1symbol }}</option>
                                                <option value="">{{$sections[4]->content->earning2symbol }}</option>
                                                <option value="">{{$sections[4]->content->earning3symbol }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="item wow fadeInUp" data-wow-duration="0.3s" data-wow-delay="0.3s">
                                    <form class="account-form">
                                        <div class="form-group">
                                            <input class="lasthead" type="text" placeholder="02 BTC" id="#"
                                                name="#">
                                        </div>
                                    </form>
                                </div>
                                <div class="item wow fadeInUp" data-wow-duration="0.3s" data-wow-delay="0.3s">
                                    <a href="{{$sections[4]->content->btn1link }}" class="button button-1">{{$sections[4]->content->btn1 }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-duration="0.3s" data-wow-delay="0.3s">
                    <div class="profit-box">
                        <p class="text">{{$sections[4]->content->period1 }}</p>
                        <h4 class="rate">{{$sections[4]->content->period1profit }} <span>{{$sections[4]->content->period1symbol }}</span></h4>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-duration="0.3s" data-wow-delay="0.3s">
                    <div class="profit-box">
                        <p class="text">{{$sections[4]->content->period2 }}</p>
                        <h4 class="rate">{{$sections[4]->content->period2profit }} <span>{{$sections[4]->content->period2symbol }}</span></h4>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-duration="0.3s" data-wow-delay="0.3s">
                    <div class="profit-box">
                        <p class="text">{{$sections[4]->content->period3 }}</p>
                        <h4 class="rate">{{$sections[4]->content->period3profit }} <span>{{$sections[4]->content->period3symbol }}</span></h4>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-duration="0.3s" data-wow-delay="0.3s">
                    <div class="profit-box">
                        <p class="text">{{$sections[4]->content->period4 }}</p>
                        <h4 class="rate">{{$sections[4]->content->period4profit }} <span>{{$sections[4]->content->period4symbol }}</span></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

{{-- @if ($sections[5]->status == 1)
<!-- Transaction Start -->
<div class="transaction" id="transaction">
    <div class="bg">
        <img src="{{ asset($images[28]->image)}}" alt="" class="secton-bg">
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 m-auto wow fadeInUp" data-wow-duration="0.3s" data-wow-delay="0.3s">
                <div class="upper-content text-center">
                    <h4 class="lasthead">{{$sections[5]->content->text1 }}</h4>
                    <h2 class="title">{{$sections[5]->content->text2 }}</h2>
                    <p class="text">
                        {{$sections[5]->content->text3 }}
                    </p>
                </div>
            </div>
            <div class="col-lg-12 wow fadeInUp" data-wow-duration="0.3s" data-wow-delay="0.3s">
                <div class="transaction-box">
                    <ul class="nav nav-pills" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                                aria-selected="true">
                                <img src="{{ asset($images[29]->image)}}" alt=""> {{$sections[5]->content->btn1a }} <br> {{$sections[5]->content->btn1b }}
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-profile" type="button" role="tab"
                                aria-controls="pills-profile" aria-selected="false">
                                <img src="{{ asset($images[30]->image)}}" alt=""> {{$sections[5]->content->btn2a }} <br> {{$sections[5]->content->btn2b }}
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-contact" type="button" role="tab"
                                aria-controls="pills-contact" aria-selected="false">
                                <img src="{{ asset($images[31]->image)}}" alt=""> {{$sections[5]->content->btn3a }} <br> {{$sections[5]->content->btn3b }}
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                            aria-labelledby="pills-home-tab">
                            <div class="responsive-table">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">NAME</th>
                                            <th scope="col">PRICE</th>
                                            <th scope="col">Daily Dividend</th>
                                            <th scope="col">AMOUNTS</th>
                                            <th scope="col">Deposit by</th>
                                            <th scope="col">Currency</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <img src="assets/img/man-1.png" alt="">
                                                <span> Jim Adams</span>
                                            </td>
                                            <td>
                                                $10.50
                                            </td>
                                            <td>
                                                $0.09
                                            </td>
                                            <td>
                                                $718
                                            </td>
                                            <td>21 DAYS</td>
                                            <td>
                                                <img src="assets/img/coin-icon-1.png" alt="">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                            aria-labelledby="pills-profile-tab">
                            <div class="responsive-table">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">NAME</th>
                                            <th scope="col">PRICE</th>
                                            <th scope="col">Daily Dividend</th>
                                            <th scope="col">AMOUNTS</th>
                                            <th scope="col">Deposit by</th>
                                            <th scope="col">Currency</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <img src="assets/img/man-1.png" alt="">
                                                <span> Jim Adams</span>
                                            </td>
                                            <td>
                                                $10.50
                                            </td>
                                            <td>
                                                $0.09
                                            </td>
                                            <td>
                                                $718
                                            </td>
                                            <td>21 DAYS</td>
                                            <td>
                                                <img src="assets/img/coin-icon-1.png" alt="">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                            aria-labelledby="pills-contact-tab">
                            <div class="responsive-table">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">NAME</th>
                                            <th scope="col">PRICE</th>
                                            <th scope="col">Daily Dividend</th>
                                            <th scope="col">AMOUNTS</th>
                                            <th scope="col">Deposit by</th>
                                            <th scope="col">Currency</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <img src="assets/img/man-1.png" alt="">
                                                <span> Jim Adams</span>
                                            </td>
                                            <td>
                                                $10.50
                                            </td>
                                            <td>
                                                $0.09
                                            </td>
                                            <td>
                                                $718
                                            </td>
                                            <td>21 DAYS</td>
                                            <td>
                                                <img src="assets/img/coin-icon-1.png" alt="">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 wow fadeInUp" data-wow-duration="0.3s" data-wow-delay="0.3s">
                <a href="{{$sections[5]->content->btn4link }}" class="button button-1">{{$sections[5]->content->btn4 }}</a>
            </div>
        </div>
    </div>
</div>
@endif --}}

@if ($sections[6]->status == 1)
<!-- Counter Start -->
<div class="counter" style="background-image: url('{{ asset($images[32]->image)}}')">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-duration="0.2s" data-wow-delay="0.2s">
                <div class="page-counter">
                    <div class="counter-item">
                        <h2 class="title"><span class="count-num">{{$sections[6]->content->registeredCount }}</span>{{$sections[6]->content->registeredUnit }}</h2>
                        <p class="text">{{$sections[6]->content->registered }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-duration="0.3s" data-wow-delay="0.3s">
                <div class="page-counter">
                    <div class="counter-item">
                        <h2 class="title"><span class="count-num">{{$sections[6]->content->countriesCount }}</span></h2>
                        <p class="text">{{$sections[6]->content->countries }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-duration="0.4s" data-wow-delay="0.4s">
                <div class="page-counter">
                    <div class="counter-item">
                        <h2 class="title">$<span class="count-num">{{$sections[6]->content->withdrawAmount }}</span>{{$sections[6]->content->withdrawUnit }}</h2>
                        <p class="text">{{$sections[6]->content->withdraw }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.5s">
                <div class="page-counter four">
                    <div class="counter-item">
                        <h2 class="title"><span class="count-num">{{$sections[6]->content->activeCount }}</span>{{$sections[6]->content->activeUnit }}</h2>
                        <p class="text">{{$sections[6]->content->active }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if ($sections[7]->status == 1)
<!-- Process Start -->
<div class="process">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 col-lg-10 m-auto wow fadeInUp" data-wow-duration="0.3s" data-wow-delay="0.3s">
                <div class="upper-content text-center">
                    <h4 class="lasthead">{{$sections[7]->content->text1 }}</h4>
                    <h2 class="title">{{$sections[7]->content->text2 }}</h2>
                    <p class="text">{{$sections[7]->content->text3 }} </p>
                </div>
            </div>
            <div class="col-12 wow fadeInUp" data-wow-duration="0.3s" data-wow-delay="0.3s">
                <div class="videoo">
                    <img src="{{ asset($images[33]->image)}}" alt="" class="video-bg">
                    <div class="video-box">
                        <div class="video-img">
                            <a class="youtube-video mfp-iframe video-play-btn video-icon"
                                href="{{$sections[7]->content->youtubeLink }}">
                                <i class="fas fa-play"></i>
                            </a>
                        </div>
                        <div class="video-text">
                            <p class="text">{{$sections[7]->content->youtubeText }}</p>
                            <span><i class="far fa-clock"></i> {{$sections[7]->content->youtubeDuration }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if ($sections[8]->status == 1)
<!-- Testimonial Start -->
<div class="testomonial wow fadeInUp" data-wow-duration="0.3s" data-wow-delay="0.3s"  id="testimonial" >
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="testo-box owl-carousel owl-theme">
                    <div class="single item">
                        <div class="person">
                            <div class="tumb">
                                <img src="{{ asset($images[34]->image)}}" alt="">
                            </div>
                            <h2 class="name">{{$sections[8]->content->reviewer1 }}</h2>
                            <h5>{{$sections[8]->content->reviewer1job }}</h5>
                        </div>
                        <div class="content">
                            <h4 class="lasthead">
                                “{{$sections[8]->content->reviewer1text }}”
                            </h4>
                        </div>
                    </div>
                    <div class="single item">
                        <div class="person">
                            <div class="tumb">
                                <img src="{{ asset($images[35]->image)}}" alt="">
                            </div>
                            <h2 class="name">{{$sections[8]->content->reviewer2 }}</h2>
                            <h5>{{$sections[8]->content->reviewer2job }}</h5>
                        </div>
                        <div class="content">
                            <h4 class="lasthead">
                                “{{$sections[8]->content->reviewer2text }}”
                            </h4>
                        </div>
                    </div>
                    <div class="single item">
                        <div class="person">
                            <div class="tumb">
                                <img src="{{ asset($images[36]->image)}}" alt="">
                            </div>
                            <h2 class="name">{{$sections[8]->content->reviewer3 }}</h2>
                            <h5>{{$sections[8]->content->reviewer3job }}</h5>
                        </div>
                        <div class="content">
                            <h4 class="lasthead">
                                “{{$sections[8]->content->reviewer3text }}”
                            </h4>
                        </div>
                    </div>
                    <div class="single item">
                        <div class="person">
                            <div class="tumb">
                                <img src="{{ asset($images[37]->image)}}" alt="">
                            </div>
                            <h2 class="name">{{$sections[8]->content->reviewer4 }}</h2>
                            <h5>{{$sections[8]->content->reviewer4job }}</h5>
                        </div>
                        <div class="content">
                            <h4 class="lasthead">
                                “{{$sections[8]->content->reviewer4text }}”
                            </h4>
                        </div>
                    </div>
                    <div class="single item">
                        <div class="person">
                            <div class="tumb">
                                <img src="{{ asset($images[38]->image)}}" alt="">
                            </div>
                            <h2 class="name">{{$sections[8]->content->reviewer5 }}</h2>
                            <h5>{{$sections[8]->content->reviewer5job }}</h5>
                        </div>
                        <div class="content">
                            <h4 class="lasthead">
                                “{{$sections[8]->content->reviewer5text }}”
                            </h4>
                        </div>
                    </div>
                    <div class="single item">
                        <div class="person">
                            <div class="tumb">
                                <img src="{{ asset($images[39]->image)}}" alt="">
                            </div>
                            <h2 class="name">{{$sections[8]->content->reviewer6 }}</h2>
                            <h5>{{$sections[8]->content->reviewer6job }}</h5>
                        </div>
                        <div class="content">
                            <h4 class="lasthead">
                                “{{$sections[8]->content->reviewer6text }}”
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
@section('page-script')

<script>
    const el1 = document.getElementById( 'ticker1' );const
    ws1 = new WebSocket( 'wss://stream.binance.com:9443/ws/{{ strtolower($sections[1]->content->coin1symbol) }}usdt@miniTicker' );
    ws1.addEventListener( 'message', e => {let data = JSON.parse( e.data ) || {};
    let { s, c } = data;el1.textContent = ' $'+ Number( c ).toFixed( 2 );});
    const el2 = document.getElementById( 'ticker2' );const
    ws2 = new WebSocket( 'wss://stream.binance.com:9443/ws/{{ strtolower($sections[1]->content->coin2symbol) }}usdt@miniTicker' );
    ws2.addEventListener( 'message', e => {let data = JSON.parse( e.data ) || {};let { s, c } = data;
    el2.textContent = ' $'+ Number( c ).toFixed( 2 );});
    const el3 = document.getElementById( 'ticker3' );const
    ws3 = new WebSocket( 'wss://stream.binance.com:9443/ws/{{ strtolower($sections[1]->content->coin3symbol) }}usdt@miniTicker' );
    ws3.addEventListener( 'message', e => {let data = JSON.parse( e.data ) || {};
    let { s, c } = data;el3.textContent = ' $'+ Number( c ).toFixed( 2 );});
    const el4 = document.getElementById( 'ticker4' );const
    ws4 = new WebSocket( 'wss://stream.binance.com:9443/ws/{{ strtolower($sections[1]->content->coin4symbol) }}usdt@miniTicker' );
    ws4.addEventListener( 'message', e => {let data = JSON.parse( e.data ) || {};
    let { s, c } = data;el4.textContent = ' $'+ Number( c ).toFixed( 2 );});
</script>
@endsection
