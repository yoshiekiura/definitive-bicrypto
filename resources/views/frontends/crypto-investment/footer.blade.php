@if ($sections[9]->status == 1)
<div class="footer bg-dark">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-duration="0.2s" data-wow-delay="0.2s">
                <div class="footer-box">
                    <div class="logo"><img src="{{getImage(imagePath()['logoIcon']['path'] .'/logo.png')}}"></div>
                    <p class="text">{{ $sections[9]->content->text1 }}</p>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 wow fadeInUp" data-wow-duration="0.3s" data-wow-delay="0.3s">
                <div class="footer-box">
                    <h4 class="lasthead">Company</h4>
                    <ul class="footer-link">
                        <li><a href="{{ $sections[9]->content->aboutUslink }}">About Us</a></li>
                        <li><a href="{{ $sections[9]->content->contactUslink }}">Contact Us</a></li>
                        <li><a href="/blog">Blog</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 wow fadeInUp" data-wow-duration="0.4s" data-wow-delay="0.4s">
                <div class="footer-box">
                    <h4 class="lasthead">Support</h4>
                    <ul class="footer-link">
                        <li><a href="#faq">FAQ</a></li>
                        <li><a href="#contact">Contact</a></li>
                        <li><a href="{{ $sections[9]->content->knowledgeBaselink }}">Knowledge Base</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.5s">
                <div class="footer-box">
                    <h4 class="lasthead">Policy</h4>
                    <ul class="footer-link">
                        <li><a href="{{ $sections[9]->content->termslink }}">Terms of use</a></li>
                        <li><a href="{{ $sections[9]->content->privacylink }}">Privacy Policy</a></li>
                        <li><a href="{{ $sections[9]->content->refundlink }}">Refund Policy</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 wow fadeInUp" data-wow-duration="0.6s" data-wow-delay="0.6s">
                <div class="footer-box">
                    <h4 class="lasthead">Contacts</h4>
                    <ul class="footer-link">
                        <li> {{ $sections[9]->content->email }} </li>
                        <li> {{ $sections[9]->content->phone1 }} </li>
                        <li> {{ $sections[9]->content->phone2 }} </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 wow fadeInUp" data-wow-duration="0.2s" data-wow-delay="0.2s">
                <div class="raka"></div>
            </div>
            <div class="col-lg-6 wow fadeInUp" data-wow-duration="0.3s" data-wow-delay="0.3s">
                <div class="footer-bottom">
                    <p class="text">Copyright &copy; <script>document.write(new Date().getFullYear())</script><a class="ms-25" target="_blank">All Rights Reserved By {{ siteName() }}</a>.</p>
                </div>
            </div>
            <div class="col-lg-6 wow fadeInUp" data-wow-duration="0.4s" data-wow-delay="0.4s">
                <div class="footer-bottom">
                    <div class="social-style">
                        <a href="{{ $sections[9]->content->facebook }}"><i class="fab fa-facebook-f"></i></a>
                        <a href="{{ $sections[9]->content->twitter }}"><i class="fab fa-twitter"></i></a>
                        <a href="{{ $sections[9]->content->pinterest }}"><i class="fab fa-pinterest-p"></i></a>
                        <a href="{{ $sections[9]->content->instagram }}"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
