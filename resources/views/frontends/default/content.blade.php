@extends('frontends.index')

@section('content')
@if ($sections[0]->status == 1)
<!-- Banners Start -->
<header class="header section" id="home">
    <div class="shapes-container">
        <div class="static-shape shape-main cutout x2 bottom-right" data-aos="fade-down" data-aos-delay="300"></div>
    </div>

    <div class="container pb-5">
        <div class="row justify-content-between align-items-center mt-5">
            <div class="col-md-6 text-center @rtl text-md-end @else text-md-start @endrtl">
                <h1 class="bold font-md display-lg-2 mt-3" data-aos="@rtl fade-left" @else fade-right @endrtl
                    data-aos-delay="100">{{$sections[0]->content->text1 }} <span
                        class="d-block">{{$sections[0]->content->text2 }}</span></h1>

                <p class="lead" data-aos="@rtl fade-left" @else fade-right @endrtl data-aos-delay="200">
                    {{$sections[0]->content->text4 }}</p>

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
<!-- Credit Cards Management -->
<section class="section anime-background">
    <div class="shapes-container">
        <div class="static-shape shape-main left"></div>
    </div>

    <div class="container">
        <div class="row gap-y align-items-center">
            <div class="col-md-6">
                <div class="card shadow bg-dark no-action mx-auto wallet">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <img src="{{ asset($images[3]->image)}}" class="icon-md rounded-circle" alt="">
                        <span class="text-uppercase small bold">checkout</span>
                        <i data-feather="bell"></i>
                    </div>

                    <div class="card-body">
                        @php($cards = [
                            [ "style" => "1" ],
                        ])
                        <div class="swiper-container" data-sw-autoplay="2500">
                            <div class="swiper-wrapper">
                                @foreach ($cards as $card)
                                <div class="swiper-slide">
                                    <div class="card credit-card credit-card-st{{ $card['style'] }}">
                                        <div class="shapes-container">
                                            <div class="shape shape-1">
                                                <div></div>
                                            </div>
                                            <div class="shape shape-2">
                                                <div></div>
                                            </div>
                                        </div>

                                        <div class="card-body">
                                            <div class="row justify-content-between align-items-center">
                                                <div class="col d-flex">
                                                    <div class="icon-md rounded-circle bg-danger op-7"></div>
                                                    <div class="icon-md rounded-circle bg-warning op-7"
                                                        style="transform: translateX(-50%)"></div>
                                                </div>
                                                <div class="col-auto">
                                                    <span class="badge badge-success">Active</span>
                                                </div>
                                            </div>
                                            <div class="my-4">
                                                <div class="d-flex justify-content-around align-items-center">
                                                    <div class="d-flex">
                                                        <div class="safe-digit"></div>
                                                        <div class="safe-digit"></div>
                                                        <div class="safe-digit"></div>
                                                        <div class="safe-digit"></div>
                                                    </div>
                                                    <div class="d-flex">
                                                        <div class="safe-digit"></div>
                                                        <div class="safe-digit"></div>
                                                        <div class="safe-digit"></div>
                                                        <div class="safe-digit"></div>
                                                    </div>
                                                    <div class="d-flex">
                                                        <div class="safe-digit"></div>
                                                        <div class="safe-digit"></div>
                                                        <div class="safe-digit"></div>
                                                        <div class="safe-digit"></div>
                                                    </div>
                                                    <div class="text-dark bold">1234</div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="small text-muted">Card holder</div>
                                                    <div class="text-dark semi-bold h6">John Doe</div>
                                                </div>
                                                <div class="col text-end">
                                                    <div class="small text-muted">Expires</div>
                                                    <div class="text-dark semi-bold h6">08/24</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="card card-details bg-contrast" data-aos="fade-up">
                        <div class="card-body pb-0 d-flex align-items-center justify-content-between">
                            <h6 class="m-0 bold">Summary</h6>
                            <button class="btn btn-primary btn-sm"><i class="fas fa-arrow-left"></i></button>
                        </div>

                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                <?php
                                $transactions = [
                                [ "name" => "{$sections[1]->content->trx1name }", "description" => "{$sections[1]->content->trx1description }", "amount" => "{$sections[1]->content->trx1amount }"],
                                [ "name" => "{$sections[1]->content->trx2name }", "description" => "{$sections[1]->content->trx2description }", "amount" => "{$sections[1]->content->trx2amount }"],
                                [ "name" => "{$sections[1]->content->trx3name }", "description" => "{$sections[1]->content->trx3description }", "amount" => "{$sections[1]->content->trx3amount }"]]
                                ?>
                                @foreach ($transactions as $transaction)
                                <div class="list-group-item px-0">
                                    <div class="d-flex justify-content-between mb-0">
                                        <div class="text-start">
                                            <p class="my-0 semi-bold font-sm">{{ $transaction['name'] }}</p>
                                            @if ( isset($transaction['description']) )
                                            <p class="my-0 small text-muted">{{ $transaction['description'] }}</p>
                                            @endif
                                        </div>

                                        <div class="text-end">
                                            <p class="my-0 bold font-sm">${{ $transaction['amount'] }}</p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                                <div class="list-group-item px-0 pb-0">
                                    <div class="d-flex justify-content-between mb-0">
                                        <div class="text-start">Total</div>
                                        <div class="text-end"><span class="bold">${{ $sections[1]->content->trx1amount + $sections[1]->content->trx2amount + $sections[1]->content->trx3amount }}</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <a href="{{$sections[1]->content->btn1link }}" class="btn btn-primary btn-block btn-place-order">
                            {{$sections[1]->content->btn1 }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="section-heading" data-aos="fade-up">
                    <h2 class="heading-line bold"><span class="light">{{$sections[1]->content->text1 }}</span>
                        <br>{{$sections[1]->content->text2 }}</h2>
                    <p class="lead">{{$sections[1]->content->text3 }}</p>
                </div>

                <p class="mb-5">{{$sections[1]->content->text4 }}</p>

                <a href="{{$sections[1]->content->btn2link }}" class="btn btn-rounded btn-outline-darker">{{$sections[1]->content->btn2 }}</a>
            </div>
        </div>
    </div>
</section>

@endif

@if ($sections[2]->status == 1)
<!-- Gifts -->
<x-utils.container class="with-promo" id="gifts">
    <div class="row gap-y align-items-center">
        <div class="col-md-6">
            <div class="section-heading">
                <h2 class="heading-line bold"><span class="light">{{$sections[2]->content->text1 }}</span>
                    <br>{{$sections[2]->content->text2 }}</h2>
                <p class="lead">{{$sections[2]->content->text3 }}</p>
            </div>

            <p class="mb-5">{{$sections[2]->content->text4 }}</p>

            <a href="{{$sections[2]->content->btn1link }}" class="btn btn-rounded btn-outline-darker">{{$sections[2]->content->btn1 }}</a>
        </div>

        <div class="col-md-6">
            <figure class="figure-box mockup @rtl ms-md-0 @else me-md-0 @endrtl">
                <div class="screens cutout-md bottom-right" data-aos="fade-up">
                    <img src="{{ asset($images[4]->image)}}" alt="">
                </div>

                <div class="promo-box card shadow bottom-left">
                    <div class="circle-icon icon-lg bg-success p-2 rounded-circle center-flex shadow">
                        <i data-feather="gift" class="stroke-contrast"></i>
                    </div>

                    <div class="card-body">
                        <p class="small text-primary mb-3">{{$sections[2]->content->text5 }}</p>
                        <p class="text-dark h4">${{$sections[2]->content->text6 }}</p>
                        <p class="small">{{$sections[2]->content->text7 }}</p>
                    </div>
                </div>

                <div class="shapes-container d-none d-lg-block">
                    <div class="shape pattern pattern-dots"></div>
                </div>
            </figure>
        </div>
    </div>
</x-utils.container>

@endif

@if ($sections[3]->status == 1)
<!-- Security -->
<section class="section with-promo anime-background" id="security">
    <div class="shapes-container">
        <div class="static-shape shape-main right"></div>
    </div>

    <div class="container">
        <div class="row gap-y align-items-center">
            <div class="col-md-6 order-md-last">
                <div class="section-heading">
                    <h2 class="heading-line bold"><span class="light">{{$sections[3]->content->text1 }}</span>
                        <br>{{$sections[3]->content->text2 }}</h2>
                    <p class="lead">{{$sections[3]->content->text3 }}</p>
                </div>

                <p class="mb-5">{{$sections[3]->content->text4 }}</p>

                <a href="{{$sections[3]->content->btn1link }}" class="btn btn-rounded btn-outline-darker">{{$sections[3]->content->btn1 }}</a>
            </div>

            <div class="col-md-6">
                <figure class="figure-box mockup @rtl me-md-0 @else ms-md-0 @endrtl">
                    <div class="screens cutout-md bottom-left" data-aos="fade-up">
                        <img src="{{ asset($images[5]->image)}}" alt="">
                    </div>

                    <div class="promo-box card shadow top-right">
                        <div class="circle-icon icon-lg bg-success p-2 rounded-circle center-flex shadow">
                            <i data-feather="shield" class="stroke-contrast"></i>
                        </div>

                        <div class="card-body">
                            <p class="small text-primary mb-3">{{$sections[3]->content->text5 }}</p>
                            <p class="text-dark bold">{{$sections[3]->content->text6 }}</p>
                            <p class="small">{{$sections[3]->content->text7 }}</p>
                        </div>
                    </div>

                    <div class="shapes-container d-none d-lg-block">
                        <div class="shape pattern pattern-dots"></div>
                    </div>
                </figure>
            </div>
        </div>
    </div>
</section>
@endif

@if ($sections[4]->status == 1)
<!-- Smart Wallet -->
<section class="section smart-wallet" id="wallet">
    <div class="shapes-container d-none d-lg-block">
        <div class="shape pattern pattern-dots"></div>
    </div>

    <div class="container">
        <div class="row gap-y align-items-center">
            <div class="col-md-6">
                <div class="section-heading">
                    <h2 class="heading-line bold"><span class="light">{{$sections[4]->content->text1 }}</span>
                        <br>{{$sections[4]->content->text2 }}</h2>
                    <p class="lead">{{$sections[4]->content->text3 }}</p>
                </div>

                <p class="mb-5">{{$sections[4]->content->text4 }}</p>

                <a href="{{$sections[4]->content->btn1link }}" class="btn btn-rounded btn-outline-darker">{{$sections[4]->content->btn1 }}</a>
            </div>

            <div class="col-md-6">
                <div class="card shadow bg-dark no-action mx-auto wallet">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <img src="{{ asset($images[6]->image)}}" class="icon-md rounded-circle" alt="">
                        <span class="text-uppercase small bold">{{$sections[4]->content->text5 }}</span>
                        <i data-feather="bell"></i>
                    </div>

                    <div class="card-body">
                        <span class="small">{{$sections[4]->content->balanceText }}</span>
                        <p class="h2 mt-0 text-contrast">$ <span class="counter">{{$sections[4]->content->balance }}</span></p>
                    </div>

                    <div class="card-body">
                        <a href="{{$sections[4]->content->btn2link }}" class="btn btn-primary">{{$sections[4]->content->btn2 }}</a>
                        <a href="{{$sections[4]->content->btn3link }}" class="btn btn-contrast">{{$sections[4]->content->btn3 }}</a>
                    </div>

                    <div class="card card-details bg-contrast" data-aos="fade-up">
                        <div class="card-body pb-0 d-flex align-items-center justify-content-between">
                            <h6 class="m-0 bold">My Transactions</h6>
                            <button class="btn btn-primary btn-sm"><i class="fas fa-sliders-h"></i></button>
                        </div>

                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                <?php $transactions = [
                                    ["name" => "{$sections[4]->content->trx1name }", "date" => "{$sections[4]->content->trx1date }", "amount" => "{$sections[4]->content->trx1amount }", "sign" => "{$sections[4]->content->trx1sign }", "icon" => "{$sections[4]->content->trx1icon }"],
                                    ["name" => "{$sections[4]->content->trx2name }", "date" => "{$sections[4]->content->trx2date }", "amount" => "{$sections[4]->content->trx2amount }", "sign" => "{$sections[4]->content->trx2sign }", "icon" => "{$sections[4]->content->trx2icon }"],
                                    ["name" => "{$sections[4]->content->trx3name }", "date" => "{$sections[4]->content->trx3date }", "amount" => "{$sections[4]->content->trx3amount }", "sign" => "{$sections[4]->content->trx3sign }","icon" => "{$sections[4]->content->trx3icon }"],
                                    ["name" => "{$sections[4]->content->trx4name }", "date" => "{$sections[4]->content->trx4date }", "amount" => "{$sections[4]->content->trx4amount }", "sign" => "{$sections[4]->content->trx4sign }","icon" => "{$sections[4]->content->trx4icon }"]
                                ]
                                ?>
                                @foreach ($transactions as $transaction)
                                <div class="list-group-item px-0">
                                    <div class="d-flex justify-content-between mb-0">
                                        <div class="d-flex">
                                            <div
                                                class="icon-md bg-primary p-2 rounded-circle center-flex @rtl ms-3 @else me-3 @endrtl">
                                                @if (isset($transaction['icon']))
                                                <i data-feather="{{ $transaction['icon'] }}"
                                                    class="stroke-contrast"></i>
                                                @else
                                                <img src="{{ asset("img/avatar/{$transaction['picture']}.jpg") }}"
                                                    class="icon-md rounded-circle" alt="">
                                                @endif
                                            </div>

                                            <div class="flex-fill">
                                                <p class="my-0 bold font-sm">{{ $transaction['name'] }}</p>
                                                <p class="my-0 small text-muted">{{ $transaction['date'] }}</p>
                                            </div>
                                        </div>

                                        <div class="text-end">
                                            <p class="my-0 bold font-sm">
                                                {{ $transaction['sign'] }}${{ $transaction['amount'] }}</p>
                                            <p class="my-0 small @if($transaction['sign'] == " -") text-danger @else
                                                text-success @endif">
                                                @if($transaction['sign'] == "-") {{$sections[4]->content->trxLoseText }} @else
                                                {{$sections[4]->content->trxWinText }} @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

@if ($sections[5]->status == 1)
<!-- Features -->
<section class="section anime-background">
    <div class="shapes-container">
        <div class="static-shape shape-main left"></div>
    </div>

    <div class="container">
        <div class="section-heading" id="features">
            <h2 class="heading-line">{{$sections[5]->content->text1 }}</h2>
        </div>

        <div class="row gap-y text-center @rtl text-md-end @else text-md-start @endrtl">
            <?php
            $features = [
            [ "icon" => "{$sections[5]->content->feature1icon }", "title" => "{$sections[5]->content->feature1title }", "content" => "{$sections[5]->content->feature1content }" ],
            [ "icon" => "{$sections[5]->content->feature2icon }", "title" => "{$sections[5]->content->feature2title }", "content" => "{$sections[5]->content->feature2content }" ],
            [ "icon" => "{$sections[5]->content->feature3icon }", "title" => "{$sections[5]->content->feature3title }", "content" => "{$sections[5]->content->feature3content }" ],
            [ "icon" => "{$sections[5]->content->feature4icon }", "title" => "{$sections[5]->content->feature4title }", "content" => "{$sections[5]->content->feature4content }" ],
            [ "icon" => "{$sections[5]->content->feature5icon }", "title" => "{$sections[5]->content->feature5title }", "content" => "{$sections[5]->content->feature5content }" ],
            [ "icon" => "{$sections[5]->content->feature6icon }", "title" => "{$sections[5]->content->feature6title }", "content" => "{$sections[5]->content->feature6content }" ]
            ]
            ?>
            @foreach ($features as $f)
            <div class="col-md-4">
                <div class="icon-anime mb-3">
                    <i data-feather="{{ $f['icon'] }}" width="36" height="36" class="icon stroke-darker"></i>
                    <div class="shape bg-alternate-gradient circle" data-aos="fade-up" data-aos-delay="100"
                        data-aos-offset="0"></div>
                </div>

                <p class="my-0 bold lead text-dark">{{ $f['title'] }}</p>
                <p>{{ $f['content'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@if ($sections[6]->status == 1)
<!-- Partners -->
<x-utils.container class="partners">
    <div class="mb-5">
        <h2 class="heading-line">{{$sections[6]->content->text1 }} <br>{{$sections[6]->content->text2 }}</h2>
    </div>

    <div class="row">
        @for ($i = 1; $i < 12; $i++) <div class="col-4 col-md-2">
            <figure class="mockup" data-aos="fade-right" data-aos-delay="{{ $i * 100 }}">
                <img src="{{ asset("img/logos/{$i}.png") }}"
                    class="img-responsive mx-auto @if($i <= 9) mb-5 @endif @if($i > 6 and $i <= 9) mb-md-0 @endif"
                    alt="" style="max-height: 40px">
            </figure>
    </div>
    @endfor
    </div>
</x-utils.container>
@endif

@if ($sections[7]->status == 1)
<!-- Testimonials -->
<?php
$testimonials = [
[ "logo" => 1, "customer" => [ "name" => "{$sections[7]->content->reviewer1name }", "picture" => 3 ], "testimonial" => "{$sections[7]->content->reviewer1text }"
],
[ "logo" => 2, "customer" => [ "name" => "{$sections[7]->content->reviewer2name }", "picture" => 2 ], "testimonial" => "{$sections[7]->content->reviewer2text }"
],
[ "logo" => 1, "customer" => [ "name" => "{$sections[7]->content->reviewer3name }", "picture" => 5 ], "testimonial" => "{$sections[7]->content->reviewer3text }"
],
[ "logo" => 2, "customer" => [ "name" => "{$sections[7]->content->reviewer4name }}", "picture" => 6 ], "testimonial" => "{$sections[7]->content->reviewer4text }" ]
]
?>
<x-utils.container section="false" id="testimonials" class="slider-testimonials {{ $class ?? '' }}"
    container-class="swiper-center-nav {{ $containerClass ?? '' }}">
    <div class="section-heading text-center">
        <h2 class="bold">{{$sections[7]->content->text1 }}</h2>
        <p class="lead text-muted">{{$sections[7]->content->text2 }}</p>
    </div>

    <div class="card strong-top-bordered-card">
        <div class="row g-0">
            <div class="col-md-6">
                <!-- Images slider, will fade -->
                <div class="swiper-container h-100" data-sw-effect="fade" data-sw-space-between="0"
                    data-sw-pagination="false" data-sw-nav-arrows=".nav-testimonial">
                    <div class="swiper-wrapper">
                        @foreach ($testimonials as $testimonial)
                        <div class="swiper-slide">
                            <figure class="m-0 image-background cover"
                                style="background-image: url({{ asset("img/testimonials/{$testimonial['customer']['picture']}.jpg") }})">
                                <img src="{{ asset("img/testimonials/{$testimonial['customer']['picture']}.jpg") }}"
                                    alt="..." class="invisible">
                            </figure>
                        </div>
                        @endforeach
                    </div>

                    <div class="divider"></div>
                </div>

                <!-- Prev button -->
                <div class="swiper-button swiper-button-prev nav-testimonial-prev rounded-circle shadow">
                    <i data-feather="arrow-left"></i>
                </div>
            </div>

            <div class="col-md-6">
                <!-- Testimonials slider, will slide -->
                <div class="swiper-container h-100">
                    <div class="swiper-wrapper" data-sw-pagination="false" data-sw-nav-arrows=".nav-testimonial">
                        @foreach ($testimonials as $testimonial)
                        <div class="swiper-slide">
                            <div class="card-body h-100 d-flex flex-column justify-content-center">
                                <blockquote class="blockquote text-center mb-0">
                                    <figure class="mockup mb-5">
                                        <img src="{{ asset("img/logos/companies/{$testimonial['logo']}.svg") }}"
                                            alt="..." class="img-responsive">
                                    </figure>

                                    <i class="fas fa-quote-left fa-2x op-4 absolute-md left top"></i>
                                    <p class="mb-5 mb-md-6">{{ $testimonial['testimonial'] }}</p>
                                    <footer class="blockquote-footer">
                                        <span class="h6 text-uppercase">{{ $testimonial['customer']['name'] }}</span>
                                    </footer>
                                </blockquote>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Next button -->
                <div class="swiper-button swiper-button-next nav-testimonial-next rounded-circle shadow">
                    <i data-feather="arrow-right"></i>
                </div>
            </div>
        </div>
    </div>
</x-utils.container>
@endif

@if ($sections[8]->status == 1)
<!-- ./FAQs -->
<x-utils.container class="{{ $class ?? '' }}" container-class="{{ $containerClass ?? '' }} pt-0" id="faqs">
            <div class="row gap-y">
                <div class="col-lg-4 col-md-5">
                    <div class="card shadow">
                        <div class="card-body">
                            <div class="light text-center display-6 mt-auto">
                                <p class="my-0">Frequently <span class="d-block text-secondary">asked</span></p>
                                <p class="my-0 text-uppercase text-info mt-1">questions</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8 col-md-7">
                    <div class="accordion accordion-clean accordion-collapsed" id="faqs-accordion-2">
                        <?php $i=0 ?>
                        @php($faqs = [
                            [
                                "question" => $sections[8]->content->question1,
                                "answer" => $sections[8]->content->answer1
                            ],[
                                "question" => $sections[8]->content->question2,
                                "answer" => $sections[8]->content->answer2
                            ],[
                                "question" => $sections[8]->content->question3,
                                "answer" => $sections[8]->content->answer3
                            ],[
                                "question" => $sections[8]->content->question4,
                                "answer" => $sections[8]->content->answer4
                            ]
                        ])
                        @foreach ($faqs as $faq)
                        <div class="card">
                            <div class="card-header">
                                <a href="#" class="card-title btn" data-bs-toggle="collapse" data-bs-target="#v2-q{{ $i }}">
                                    <i class="fas fa-angle-down angle"></i>
                                    {{ $faq['question'] }}
                                </a>
                            </div>

                            <div id="v2-q{{ $i }}" class="collapse" data-bs-parent="#faqs-accordion-2">
                                <div class="card-body">{{ $faq['answer'] }}</div>
                            </div>
                        </div>
                        <?php $i++ ?>
                        @endforeach
                    </div>
                </div>
            </div>
</x-utils.container>
@endif

@if ($sections[9]->status == 1)
<!-- Try it -->
<section class="section anime-background">
    <div class="shapes-container">
        <div class="static-shape shape-main left"></div>
    </div>

    <div class="container text-center @rtl text-md-end @else text-md-start @endrtl">
        <div class="row">
            <div class="col-md-8 section-heading">
                <p class="bold mb-0 text-primary">{{$sections[9]->content->text1 }}</p>
                <h2 class="mt-0">{{$sections[9]->content->text2 }}</h2>

                <p class="text-muted">
                    {{$sections[9]->content->text3 }}
                </p>
            </div>
        </div>

        <a href="{{$sections[9]->content->btn1link }}" class="btn btn-rounded btn-primary btn-lg mt-2 mt-md-0 mx-auto">
            {{$sections[9]->content->btn1 }}
        </a>
    </div>
</section>
@endif
@endsection
