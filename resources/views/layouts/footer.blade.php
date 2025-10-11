<footer class="footer-design-1">
    <div class="container footer-content">
        <div class="row">
            <!-- Sol Kolon: Logo + Açıklama + Sosyal Medya -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="footer-logo">
                    <img width="250" src="http://akasyaproje.test/public/assets/img/logo_white.png" alt="">
                </div>
                <p class="footer-description">
                    {{ setting('general', 'description') }}
                </p>
                <div class="social-icons">
                    <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
                </div>
            </div>

            <!-- Orta Kolon: Hizmetler ve Hızlı Linkler -->
            <div class="col-lg-4 col-md-6 mb-4">

                        <div class="footer-section">
                            <h5>Hizmetlerimiz</h5>
                            <ul class="list-unstyled footer-links">
                                @foreach ($services as $service)
                                    <li>
                                        <a href="{{ $service->url }}"><i
                                                class="fas fa-chevron-right me-2"></i>{{ $service->title }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

            </div>

            <!-- Sağ Kolon: İletişim Bilgileri -->
            <div class="col-lg-4 col-md-12 mb-4">
                <div class="footer-section">
                    <h5>İletişim Bilgileri</h5>
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
            <p>&copy; {{ date('Y') }} {{ setting('general', 'title') }}. Tüm hakları saklıdır. | Gizlilik Politikası
                |
                Kullanım Şartları</p>
        </div>
    </div>
</footer>
