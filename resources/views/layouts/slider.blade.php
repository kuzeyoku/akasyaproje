<section id="heroCarousel" class="carousel slide hero-section pb-5" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
    </div>

    <div class="carousel-inner">
        @foreach ($sliders as $slider)
        <div class="carousel-item @if($loop->first) active @endif">
            <div class="hero-slide"
                style="background-image: linear-gradient(rgba(0, 95, 153, 0.7), rgba(0, 183, 194, 0.7)), url('{{ $slider->image }}');">
                <div class="container">
                    <div class="row align-items-center min-vh-100">
                        <div class="col-lg-8">
                            <h1 class="display-4 fw-bold text-white mb-4" data-aos="fade-up">
                                {{ $slider->title }}
                            </h1>
                            <p class="lead text-white mb-4" data-aos="fade-up" data-aos-delay="200">
                                {{ $slider->description }}
                            </p>
                            <div data-aos="fade-up" data-aos-delay="400">
                                <a href="{{ route("services.index") }}" class="btn btn-primary btn-lg me-3">Hizmetlerimizi
                                    Keşfedin</a>
                                <a href="{{ route("contact.index") }}" class="btn btn-outline-light border btn-lg">İletişime Geçin</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</section>
