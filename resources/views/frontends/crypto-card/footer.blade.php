@if ($sections[10]->status == 1)
<div class="footer" >
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-3 col-md-6 wow fadeInDown" data-wow-duration="0.3s" data-wow-delay="0.3s">
                <div class="footer-box">
                    <div class="logo"><img src="{{getImage(imagePath()['logoIcon']['path'] .'/logo.png')}}"></div>
                    <p class="text">{{ $sections[10]->content->text1 }}</p>
                </div>
            </div>
            <div class="col-xl-8">
                <div class="row">
                    <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInDown" data-wow-duration="0.4s"
                        data-wow-delay="0.3s">
                        <div class="footer-box">
                            <h3 class="subtitle">Company</h3>
                            <ul class="footer-link">
                                <li><a href="{{ $sections[10]->content->aboutUslink }}">About Us</a></li>
                                <li><a href="{{ $sections[10]->content->contactUslink }}">Contact Us</a></li>
                                <li><a href="/blog">Blog</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInDown" data-wow-duration="0.5s"
                        data-wow-delay="0.3s">
                        <div class="footer-box">
                            <h3 class="subtitle">Support</h3>
                            <ul class="footer-link">
                                <li><a href="#faq">FAQ</a></li>
                                <li><a href="#contact">Contact</a></li>
                                <li><a href="{{ $sections[10]->content->knowledgeBaselink }}">Knowledge Base</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInDown" data-wow-duration="0.6s"
                        data-wow-delay="0.3s">
                        <div class="footer-box">
                            <h3 class="subtitle">Policy</h3>
                            <ul class="footer-link">
                                <li><a href="{{ $sections[10]->content->termslink }}">Terms of use</a></li>
                                <li><a href="{{ $sections[10]->content->privacylink }}">Privacy Policy</a></li>
                                <li><a href="{{ $sections[10]->content->refundlink }}">Refund Policy</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInDown" data-wow-duration="0.7s"
                        data-wow-delay="0.7s">
                        <div class="footer-box">
                            <h3 class="subtitle">Contacts</h3>
                            <ul class="footer-link">
                                <li> {{ $sections[10]->content->email }} </li>
                                <li> {{ $sections[10]->content->phone1 }} </li>
                                <li> {{ $sections[10]->content->phone2 }} </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-center">
                <div class="footer-bottom">
                    <div class="content wow fadeInDown" data-wow-duration="0.4s" data-wow-delay="0.5s">
                        <p class="text">Copyright &copy; <script>document.write(new Date().getFullYear())</script><a class="ms-25" target="_blank">All Rights Reserved By {{ siteName() }}</a>.</p>
                    </div>
                    <div class="social-style wow fadeInDown" data-wow-duration="0.4s" data-wow-delay="0.5s">
                        <a href="{{ $sections[10]->content->facebook }}"><i class="fab fa-facebook-f"></i></a>
                        <a href="{{ $sections[10]->content->twitter }}"><i class="fab fa-twitter"></i></a>
                        <a href="{{ $sections[10]->content->pinterest }}"><i class="fab fa-pinterest-p"></i></a>
                        <a href="{{ $sections[10]->content->instagram }}"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
