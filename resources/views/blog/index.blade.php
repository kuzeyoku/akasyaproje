@extends('layouts.main')
@section('title', __('front/blog.page_title'))
@section('description', __('front/blog.page_description'))
@section('content')
    @php
        $firstBlog = $blogs->first();
    @endphp
    <div class="container py-5">
        <div class="row g-5">
            <div class="col-lg-8">
                <article class="featured-article mb-5" data-aos="fade-up">
                    <div class="featured-image">
                        <img src="{{ $firstBlog->image }}" alt="Drone Teknolojisi" class="img-fluid">
                        <div class="featured-badge">Öne Çıkan</div>
                    </div>
                    <div class="featured-content">
                        <div class="article-meta">
                            <span class="badge bg-primary me-2">{{ $firstBlog->category->title }}</span>
                            <span class="text-muted">{{ $firstBlog->created_at->diffForHumans() }}</span>
                        </div>
                        <h2><a href="{{ $firstBlog->url }}" class="text-decoration-none">{{ $firstBlog->title }}</a></h2>
                        <p class="lead text-muted">{{ $firstBlog->short_description }}</p>
                        <a href="{{ $firstBlog->url }}" class="btn btn-outline-primary">Devamını Oku</a>
                    </div>
                </article>
                <div class="row">
                    @foreach ($blogs as $blog)
                        <div class="col-lg-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                            <article class="blog-card h-100">
                                <div class="blog-image">
                                    <img src="{{ $blog->image }}" alt="{{ $blog->title }}" class="img-fluid">
                                </div>
                                <div class="blog-content">
                                    <div class="blog-meta">
                                        <span class="text-primary">{{ $blog->created_at->format('d M Y') }}</span>
                                        <span class="mx-2">•</span>
                                        <span class="text-muted">{{ $blog->category->title }}</span>
                                    </div>
                                    <h5><a href="{{ $blog->url }}">{{ $blog->title }}</a></h5>
                                    <p class="text-muted">{{ $blog->short_description }}</p>
                                    <a href="{{ $blog->url }}" class="btn btn-outline-primary btn-sm">Devamını
                                        Oku</a>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>
                <div class="row mt-5">
                    <div class="col-12">
                        {{ $blogs->links('pagination::default') }}
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                @include('blog.sidebar')
            </div>
        </div>
    </div>
@endsection
