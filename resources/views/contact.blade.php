@extends('layouts.main')
@section('title', __('front/contact.page_title'))
@section('description', __('front/contact.page_description'))
@section('content')
    @include('layouts.breadcrumb')
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="contact-info-card text-center">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h5>Adresimiz</h5>
                        <p class="text-muted">
                            {{ setting('contact', 'address') }}
                        </p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="contact-info-card text-center">
                        <div class="contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <h5>Telefon</h5>
                        <p class="text-muted">
                            {{ setting('contact', 'phone') }}
                        </p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="contact-info-card text-center">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h5>E-posta</h5>
                        <p class="text-muted">
                            {{ setting('contact', 'email') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="contact-form-card">
                        <h3 class="mb-4">Bize Mesaj Gönderin</h3>
                        {{ html()->form()->route('contact.send')->open() }}
                        <div class="row g-3">
                            <div class="col-12">
                                {{ html()->label('Ad *')->class('form-label') }}
                                {{ html()->text('name')->placeholder('Adınızı ve Soyadınızı Giriniz')->class('form-control')->required() }}
                            </div>
                            <div class="col-md-6">
                                {{ html()->label('E-Posta *')->class('form-label') }}
                                {{ html()->input('email', 'email')->placeholder('E-Posta Adresinizi Giriniz')->class('form-control')->required() }}
                            </div>
                            <div class="col-md-6">
                                {{ html()->label('Telefon *')->class('form-label') }}
                                {{ html()->input('tel', 'phone')->placeholder('05** *** ** **')->class('form-control')->required() }}
                            </div>
                            <div class="col-12">
                                {{ html()->label('Konu *')->class('form-label') }}
                                {{ html()->select('subject', $subjects)->placeholder('Konu Seçiniz...')->class('form-control')->required() }}
                            </div>
                            <div class="col-12">
                                {{ html()->label('Mesajınız *')->class('form-label') }}
                                {{ html()->textarea('message')->rows(5)->placeholder('Mesajınız..')->class('form-control')->required() }}
                            </div>
                            @if ($privacy_page)
                                <div class="col-12">
                                    <div class="form-check">
                                        {{ html()->input('checkbox', 'privacy')->value(true)->class('form-check-input')->required() }}
                                        <label class="form-check-label" for="privacy">
                                            <a href="{{ $privacy_page->url }}" class="text-primary text-decoration-none"
                                                onclick="return!window.open(this.href)">Gizlilik
                                                Politikası</a>'nı
                                            okudum ve kabul ediyorum. *
                                        </label>
                                    </div>
                                </div>
                            @endif
                            <div class="col-12">
                                {{ html()->submit('<i class="fas fa-paper-plane me-2"></i>Mesaj Gönder')->class('btn btn-primary btn-lg w-100') }}
                            </div>
                        </div>
                        {{ html()->form()->close() }}
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="map-card">
                        <h3 class="mb-4">Ofis Lokasyonumuz</h3>
                        <div id="map" style="height: 250px; border-radius: 12px; overflow: hidden;"></div>
                        <div class="working-hours mt-4">
                            <h5><i class="fas fa-clock me-2 text-primary"></i>Çalışma Saatleri</h5>
                            <div class="row g-3 mt-2">
                                <div class="col-6">
                                    <strong>Pazartesi - Cuma:</strong><br>
                                    <span class="text-muted">08:30 - 18:00</span>
                                </div>
                                <div class="col-6">
                                    <strong>Cumartesi:</strong><br>
                                    <span class="text-muted">09:00 - 13:00</span>
                                </div>
                                <div class="col-6">
                                    <strong>Pazar:</strong><br>
                                    <span class="text-muted">Kapalı</span>
                                </div>
                                <div class="col-6">
                                    <strong>Acil Durum:</strong><br>
                                    <span class="text-muted">7/24 Ulaşılabilir</span>
                                </div>
                            </div>
                        </div>

                        <div class="quick-contact mt-4">
                            <h5><i class="fas fa-tachometer-alt me-2 text-primary"></i>Hızlı İletişim</h5>
                            <div class="d-flex gap-3 mt-3">
                                <a href="tel:{{ setting('contact', 'phone') }}" class="btn btn-outline-primary flex-fill">
                                    <i class="fas fa-phone me-2"></i>Ara
                                </a>
                                <a href="mailto:{{ setting('contact', 'email') }}"
                                    class="btn btn-outline-primary flex-fill">
                                    <i class="fas fa-envelope me-2"></i>E-posta
                                </a>
                                <a href="https://wa.me/{{ setting('contact', 'phone') }}"
                                    class="btn btn-outline-primary flex-fill" onclick="return!window.open(this.href)">
                                    <i class="fab fa-whatsapp me-2"></i>WhatsApp
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@include('common.alert')
@push('script')
    <script type="text/javascript">
        // Initialize Leaflet map
        document.addEventListener('DOMContentLoaded', function() {
            // Ankara coordinates (approximately)
            const map = L.map('map').setView([39.9269398, 32.8412001], 15);

            // Add OpenStreetMap tiles
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

            // Add custom marker
            const customIcon = L.divIcon({
                html: '<i class="fas fa-map-marker-alt" style="color: #00B7C2; font-size: 2rem;"></i>',
                iconSize: [30, 30],
                className: 'custom-div-icon'
            });

            // Add marker for office location
            L.marker([39.9269398, 32.8412001], {
                    icon: customIcon
                })
                .addTo(map)
                .bindPopup(
                    '<strong>{{ setting('general', 'title') }}</strong><br>{{ setting('contact', 'address') }}')
                .openPopup();
        });
    </script>
@endpush
