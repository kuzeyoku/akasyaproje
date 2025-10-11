@extends('layouts.main')
@section('title', __('front/project.page_title'))
@section('description', __('front/project.page_description'))
@section('content')
    @include('layouts.breadcrumb')
    <!-- Project Filters -->
    <section class="py-4 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="project-filters text-center">
                        <button class="btn btn-outline-primary active me-2 mb-2" data-filter="all">@lang('front/project.txt1')</button>
                        @foreach ($categories as $category)
                            <button class="btn btn-outline-primary me-2 mb-2"
                                data-filter="{{ $category->id }}">{{ $category->title }}</button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                @foreach ($projects as $project)
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="project-card">
                            <div class="project-image">
                                <img src="{{ $project->image }}" alt="{{ $project->title }}" class="img-fluid">
                                <div class="project-overlay">
                                    <div class="project-status" id="{{ $project->category->id }}">{{ $project->category->title }}</div>
                                </div>
                            </div>
                            <div class="project-content">
                                <div class="project-meta">
                                    <span class="badge bg-primary">{{ $project->created_at->format('Y') }}</span>
                                </div>
                                <h5>{{ $project->title }}</h5>
                                <p class="text-muted">{{ $project->short_description }}</p>
                                <a href="{{ $project->url }}" class="btn btn-outline-primary btn-sm">@lang('front/project.txt2')</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <section class="py-5 bg-primary text-white">
        <div class="container">
            <div class="row g-4 text-center">
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="stat-item">
                        <h2 class="display-4 fw-bold mb-2">@lang('front/project.txt3')</h2>
                        <p class="mb-0">@lang('front/project.txt4')</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="stat-item">
                        <h2 class="display-4 fw-bold mb-2">@lang('front/project.txt5')</h2>
                        <p class="mb-0">@lang('front/project.txt6')</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="stat-item">
                        <h2 class="display-4 fw-bold mb-2">@lang('front/project.txt7')</h2>
                        <p class="mb-0">@lang('front/project.txt8')</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="stat-item">
                        <h2 class="display-4 fw-bold mb-2">@lang('front/project.txt9')</h2>
                        <p class="mb-0">@lang('front/project.txt10')</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
