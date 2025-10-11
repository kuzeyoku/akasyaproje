@extends('layouts.main')
@section('content')
    <section class="breadcrumb-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 text-white">
                    <nav aria-label="breadcrumb" data-aos="fade-right">
                        <ol class="breadcrumb text-white-50">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50">Ana Sayfa</a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{ route('services.index') }}"
                                    class="text-white-50">Hizmetler</a></li>
                            <li class="breadcrumb-item active text-white">Halihazır Harita</li>
                        </ol>
                    </nav>
                    <h1 class="display-4 fw-bold mb-3" data-aos="fade-right" data-aos-delay="200">{{ $service->title }}</h1>
                    <p class="lead mb-4" data-aos="fade-right" data-aos-delay="400">
                        {{ $service->short_description }}
                    </p>
                    <div data-aos="fade-right" data-aos-delay="600">
                        <a href="{{ route('contact.index') }}" class="btn btn-light btn-lg me-3">Ücretsiz Teklif Al</a>
                        <a href="#service-details" class="btn btn-outline-light border btn-lg">Detayları İncele</a>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <img src="{{ $service->image }}" alt="{{ $service->title }}" class="img-fluid rounded shadow-lg">
                </div>
            </div>
        </div>
    </section>

    <section class="py-5" id="service-details">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-8">
                    <div class="service-content" data-aos="fade-up">
                        {!! $service->description !!}
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="sample-projects mt-4" data-aos="fade-left" data-aos-delay="200">
                        <h6 class="mb-4">Diğer Hizmetlerimizi İncelediniz mi ?</h6>
                        @foreach ($otherServices as $item)
                            <div class="project-sample">
                                <img src="{{ $item->image }}" alt="Örnek Proje 1" class="img-fluid rounded">
                                <div class="project-info mt-2">
                                    <h6>{{ $item->title }}</h6>
                                    <p class="small text-muted">{{ $item->short_description }}</p>
                                    <a href="{{ $item->url }}" class="btn btn-outline-primary btn-sm">Detaylar</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('layouts.reference')
@endsection
