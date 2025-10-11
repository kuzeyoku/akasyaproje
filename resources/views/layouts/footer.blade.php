<footer class="footer-design-1">
    <div class="container footer-content">
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="footer-logo">
                    <img width="250" src="{{ asset('assets/img/logo_white.png') }}"
                        alt="{{ setting('general', 'title') }}">
                </div>
                <p class="footer-description">
                    {{ setting('general', 'description') }}
                </p>
                {{-- <div class="social-icons">
                    <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
                </div> --}}
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="footer-section">
                    <h5>@lang('front/footer.txt1')</h5>
                    <ul class="list-unstyled footer-links">
                        @foreach ($services as $service)
                            <li>
                                <a href="{{ $service->url }}">
                                    <i class="fas fa-chevron-right me-2"></i>{{ $service->title }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

            </div>
            <div class="col-lg-4 col-md-12 mb-4">
                <div class="footer-section">
                    <h5>@lang('front/footer.txt2')</h5>
                    <div class="contact-info">
                        <div class="contact-item">
                            <i class="fas fa-map-marker-alt"></i>
                            {{ setting('contact', 'address') }}
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-phone"></i>
                            {{ setting('contact', 'phone') }}
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-envelope"></i>
                            {{ setting('contact', 'email') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p>@lang('front/footer.copyright', ['title' => setting('general', 'title'), 'year' => date('Y')]) | Gizlilik Politikası | Kullanım Şartları |
                <a class="text-white" href="{{ route('sitemap.index') }}"
                    onclick="return!window.open(this.href)">@lang('front/footer.sitemap')</a>
            </p>
        </div>
    </div>
</footer>
