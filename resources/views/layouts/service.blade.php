<section class="py-5 bg-light" id="services">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center mb-5">
                <h2 class="display-5 fw-bold mb-3" data-aos="fade-up">@lang('front/service.home_txt1')</h2>
                <p class="lead text-muted" data-aos="fade-up" data-aos-delay="200">
                    @lang('front/service.home_txt2')
                </p>
            </div>
        </div>
        <div class="row g-4">
            @foreach ($services as $service)
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="service-card h-100">
                        <div class="service-image">
                            <img src="{{ $service->image }}" alt="" class="img-fluid">
                        </div>
                        <div class="service-content">
                            <h5>{{ $service->title }}</h5>
                            <p class="text-muted">{{ $service->short_description }}</p>
                            <a href="{{ $service->url }}" class="btn btn-outline-primary">@lang('front/service.home_txt3')</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="text-center mt-5" data-aos="fade-up">
            <a href="{{ route('services.index') }}" class="btn btn-primary btn-lg">@lang('front/service.home_txt4')</a>
        </div>
    </div>
</section>
