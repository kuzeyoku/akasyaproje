<section class="py-5" id="blog">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center mb-5">
                <h2 class="display-5 fw-bold mb-3" data-aos="fade-up">@lang('front/blog.home_txt1')</h2>
                <p class="lead text-muted" data-aos="fade-up" data-aos-delay="200">
                    @lang('front/blog.home_txt2')
                </p>
            </div>
        </div>
        <div class="row g-4">
            @foreach ($blogs as $blog)
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <article class="blog-card h-100">
                        <div class="blog-image">
                            <img src="{{ $blog->image }}" alt="{{ $blog->title }}" class="img-fluid">
                        </div>
                        <div class="blog-content">
                            <div class="blog-meta">
                                <span class="text-primary">{{ $blog->created_at->diffForHumans() }}</span>
                                <span class="mx-2">•</span>
                                <span class="text-muted">{{ $blog->category->title }}</span>
                            </div>
                            <h5><a href="{{ $blog->url }}">{{ $blog->title }}</a></h5>
                            <p class="text-muted">{{ $blog->short_description }}</p>
                            <a href="{{ $blog->url }}" class="btn btn-outline-primary btn-sm">@lang('front/blog.home_txt3')</a>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
        <div class="text-center mt-5" data-aos="fade-up">
            <a href="{{ route('blogs.index') }}" class="btn btn-primary btn-lg">@lang('front/blog.home_txt4')</a>
        </div>
    </div>
</section>
