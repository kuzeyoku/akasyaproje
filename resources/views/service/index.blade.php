@extends("layouts.main")
@section("title",__("front/service.page_title"))
@section("description", __("front/service.page_description"))
@section("content")
@include("layouts.breadcrumb")
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            @foreach ($services as $service)
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="service-detail-card h-100">
                    <div class="service-image">
                        <img src="{{ $service->image }}" alt="{{ $service->title }}" class="img-fluid">
                    </div>
                    <div class="service-content">
                        <h5>{{ $service->title }}</h5>
                        <p class="text-muted">{{ $service->short_description }}</p>
                        <a href="{{ $service->url }}" class="btn btn-outline-primary">@lang("front/service.txt11")</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center mb-5">
                <h2 class="display-5 fw-bold mb-3" data-aos="fade-up">@lang("front/service.txt1")</h2>
                <p class="lead text-muted" data-aos="fade-up" data-aos-delay="200">@lang("front/service.txt2")</p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-card text-center">
                    <div class="feature-icon">
                        <i class="fas fa-award"></i>
                    </div>
                    <h5>@lang("front/service.txt3")</h5>
                    <p class="text-muted">@lang("front/service.txt4")</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-card text-center">
                    <div class="feature-icon">
                        <i class="fas fa-microscope"></i>
                    </div>
                    <h5>@lang("front/service.txt5")</h5>
                    <p class="text-muted">@lang("front/service.txt6")</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-card text-center">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h5>@lang("front/service.txt7")</h5>
                    <p class="text-muted">@lang("front/service.txt8")</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                <div class="feature-card text-center">
                    <div class="feature-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h5>@lang("front/service.txt9")</h5>
                    <p class="text-muted">@lang("front/service.txt10")</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
