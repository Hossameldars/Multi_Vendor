<footer class="footer">

    {{-- Footer Top --}}
    <div class="footer-top">
        <div class="container">
            <div class="inner-content">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="footer-logo">
                            <a href="index.html">
                                <img src="{{ asset('assets/images/logo/white-logo.svg') }}" alt="#">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-8 col-12">
                        <div class="footer-newsletter">
                            <h4 class="title">
                                {{ __('Subscribe to our Newsletter') }}
                                <span>{{ __('Get all the latest information, Sales and Offers.') }}</span>
                            </h4>
                            <div class="newsletter-form-head">
                                <form action="#" method="get" class="newsletter-form">
                                    <input name="EMAIL"
                                           placeholder="{{ __('Email address here...') }}"
                                           type="email">
                                    <div class="button">
                                        <button class="btn">{{ __('Subscribe') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Footer Middle --}}
    <div class="footer-middle">
        <div class="container">
            <div class="bottom-inner">
                <div class="row">

                    {{-- Contact --}}
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="single-footer f-contact">
                            <h3>{{ __('Get In Touch With Us') }}</h3>
                            <p class="phone">{{ __('Phone: +1 (900) 33 169 7720') }}</p>
                            <ul>
                                <li>
                                    <span>{{ __('Monday-Friday:') }}</span>
                                    {{ __('9.00 am - 8.00 pm') }}
                                </li>
                                <li>
                                    <span>{{ __('Saturday:') }}</span>
                                    {{ __('10.00 am - 6.00 pm') }}
                                </li>
                            </ul>
                            <p class="mail">
                                <a href="mailto:support@shopgrids.com">support@shopgrids.com</a>
                            </p>
                        </div>
                    </div>

                    {{-- Mobile App --}}
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="single-footer our-app">
                            <h3>{{ __('Our Mobile App') }}</h3>
                            <ul class="app-btn">
                                <li>
                                    <a href="javascript:void(0)">
                                        <i class="lni lni-apple"></i>
                                        <span class="small-title">{{ __('Download on the') }}</span>
                                        <span class="big-title">{{ __('App Store') }}</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)">
                                        <i class="lni lni-play-store"></i>
                                        <span class="small-title">{{ __('Download on the') }}</span>
                                        <span class="big-title">{{ __('Google Play') }}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- Information --}}
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="single-footer f-link">
                            <h3>{{ __('Information') }}</h3>
                            <ul>
                                <li><a href="javascript:void(0)">{{ trans('footer.about') }}</a></li>
                                <li><a href="javascript:void(0)">{{ trans('footer.contact') }}</a></li>
                                <li><a href="javascript:void(0)">{{ __('Downloads') }}</a></li>
                                <li><a href="javascript:void(0)">{{ __('Sitemap') }}</a></li>
                                <li><a href="javascript:void(0)">{{ __('FAQs Page') }}</a></li>
                            </ul>
                        </div>
                    </div>

                    {{-- Shop Departments --}}
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="single-footer f-link">
                            <h3>{{ __('Shop Departments') }}</h3>
                            <ul>
                                <li><a href="javascript:void(0)">{{ __('Computers & Accessories') }}</a></li>
                                <li><a href="javascript:void(0)">{{ __('Smartphones & Tablets') }}</a></li>
                                <li><a href="javascript:void(0)">{{ __('TV, Video & Audio') }}</a></li>
                                <li><a href="javascript:void(0)">{{ __('Cameras, Photo & Video') }}</a></li>
                                <li><a href="javascript:void(0)">{{ __('Headphones') }}</a></li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- Footer Bottom --}}
    <div class="footer-bottom">
        <div class="container">
            <div class="inner-content">
                <div class="row align-items-center">
                    <div class="col-lg-4 col-12">
                        <div class="payment-gateway">
                            <span>{{ __('We Accept:') }}</span>
                            <img src="{{ asset('assets/images/footer/credit-cards-footer.png') }}" alt="#">
                        </div>
                    </div>
                    <div class="col-lg-4 col-12">
                        <div class="copyright">
                            <p>
                                {{ __('Designed and Developed by') }}
                                <a href="https://graygrids.com/" target="_blank">GrayGrids</a>
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-12">
                        <ul class="socila">
                            <li><span>{{ __('Follow Us On:') }}</span></li>
                            <li><a href="javascript:void(0)"><i class="lni lni-facebook-filled"></i></a></li>
                            <li><a href="javascript:void(0)"><i class="lni lni-twitter-original"></i></a></li>
                            <li><a href="javascript:void(0)"><i class="lni lni-instagram"></i></a></li>
                            <li><a href="javascript:void(0)"><i class="lni lni-google"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

</footer>