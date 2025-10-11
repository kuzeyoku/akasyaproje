@extends('layouts.main')
@section('content')
    <section class="mt-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-8">
                    <article class="blog-detail" data-aos="fade-up">
                        <div class="article-header mb-4">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Ana Sayfa</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('blogs.index') }}">Blog</a></li>
                                    <li class="breadcrumb-item active">{{ $blog->title }}</li>
                                </ol>
                            </nav>
                            <div class="article-meta mb-3">
                                <span class="badge bg-primary me-2">{{ $blog->category->title }}</span>
                                <span class="text-muted">{{ $blog->created_at->format('d M Y') }}</span>
                                <span class="mx-2">•</span>
                                <span class="text-muted">{{ $blog->user->name }}</span>
                                <span class="mx-2">•</span>
                                <span class="text-muted"><i class="fas fa-eye me-1"></i>{{ $blog->view_count }}
                                    görüntüleme</span>
                            </div>
                            <h1 class="article-title">{{ $blog->title }}</h1>
                        </div>
                        <div class="article-image mb-4">
                            <img src="{{ $blog->image }}" alt="{{ $blog->title }}" class="img-fluid rounded">
                        </div>
                        <div class="article-content">
                            {!! $blog->description !!}
                        </div>
                        <div class="article-footer mt-5 pt-4 border-top">
                            <div class="align-items-center">
                                <div class="article-tags">
                                    <span class="me-2">Etiketler:</span>
                                    @foreach ($blog->tags_to_array as $tag)
                                        <a href="javascript:void(0)"
                                            class="badge bg-light text-dark me-2">#{{ $tag }}</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </article>
                    <div class="related-articles mt-5" data-aos="fade-up">
                        <h4 class="mb-4">Benzer Yazılar</h4>
                        <div class="row g-4">
                            @foreach ($relatedPosts as $item)
                                <div class="col-md-6">
                                    <article class="blog-card h-100">
                                        <div class="blog-image">
                                            <img src="{{ $item->image }}" alt="{{ $item->title }}" class="img-fluid">
                                        </div>
                                        <div class="blog-content">
                                            <div class="blog-meta">
                                                <span class="text-primary">{{ $item->created_at->format('d M Y') }}</span>
                                                <span class="mx-2">•</span>
                                                <span class="text-muted">{{ $item->category->title }}</span>
                                            </div>
                                            <h5><a href="{{ $blog->url }}">{{ $item->title }}</a></h5>
                                            <p class="text-muted small">{{ $item->short_description }}</p>
                                            <a href="{{ $blog->url }}" class="btn btn-outline-primary btn-sm">Devamını Oku</a>
                                        </div>
                                    </article>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @include('blog.sidebar')
                </div>
            </div>
        </div>
    </section>
@endsection
