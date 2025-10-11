@extends('layouts.main')
@section('content')
    <section class="breadcrum-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 text-white">
                    <nav aria-label="breadcrumb" data-aos="fade-right">
                        <ol class="breadcrumb text-white-50">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50">Ana Sayfa</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('projects.index') }}"
                                    class="text-white-50">Projeler</a></li>
                            <li class="breadcrumb-item active text-white">{{ $project->title }}</li>
                        </ol>
                    </nav>
                    <h1 class="display-4 fw-bold mb-3" data-aos="fade-right" data-aos-delay="200">{{ $project->title }}</h1>
                    <p class="lead mb-4" data-aos="fade-right" data-aos-delay="400">
                        {{ $project->short_description }}
                    </p>
                </div>
                <div class="col-lg-4" data-aos="fade-left">
                    <div class="project-status-card">
                        @if ($project->model3D)
                            <a href="{{ $project->model3D }}" class="btn btn-light w-100 mb-2"
                                onclick="return!window.open(this.href)">
                                <i class="fas fa-cube me-2"></i>3B Modeli Görüntüle
                            </a>
                        @endif
                        @if ($project->video)
                            <a href="{{ $project->video }}" class="btn btn-warning w-100 mb-2">
                                <i class="fas fa-play me-2"></i> Proje Tanıtım Videosu izle
                            </a>
                        @endif
                        <a href="{{ route('contact.index') }}" class="btn btn-outline-light border w-100">
                            <i class="fas fa-envelope me-2"></i>Proje Hakkında Bilgi Al
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @if ($project->getMedia('gallery')->isNotEmpty())
        <section class="py-5 bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-12" data-aos="fade-up">
                        <div id="projectCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach ($project->getMedia('gallery') as $image)
                                    <div class="carousel-item @if ($loop->first) active @endif">
                                        <img src="{{ $image->getUrl() }}" class="d-block w-100 project-carousel-image"
                                            alt="Ankara Kent Merkezi Genel Görünüm">
                                        <div class="carousel-caption">
                                            <p class="m-0">{{ $project->title }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#projectCarousel"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#projectCarousel"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <section class="py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-8">
                    <div class="project-content" data-aos="fade-up">
                        {!! $project->description !!}
                    </div>
                </div>
                <div class="col-lg-4">
                    @if ($project->feature)
                        <div class="project-info-card" data-aos="fade-left">
                            <h5 class="mb-4">Proje Bilgileri</h5>

                            @foreach ($project->feature as $key => $value)
                                <div class="info-row">
                                    <strong>{{ $key }} :</strong>
                                    <span>{{ $value }}</span>
                                </div>
                            @endforeach

                            <div class="info-row">
                                <strong>Durum :</strong>
                                {!! $project->process_status_badge !!}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="text-center mb-5" data-aos="fade-up">Benzer Projeler</h2>
                </div>
            </div>
            <div class="row g-4">
                @foreach ($otherProjects as $item)
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="project-card">
                            <div class="project-image">
                                <img src="{{ $item->image }}" alt="İstanbul Boğazı" class="img-fluid">
                                <div class="project-overlay">
                                    <div class="project-status">{{ $item->category->title }}</div>
                                </div>
                            </div>
                            <div class="project-content">
                                <h5>{{ $item->title }}</h5>
                                <p class="text-muted">{{ $item->short_description }}</p>
                                <a href="{{ $item->url }}" class="btn btn-outline-primary btn-sm">Proje Detayları</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
