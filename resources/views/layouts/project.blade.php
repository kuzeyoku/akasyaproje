<section class="py-5" id="projects">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center mb-5">
                <h2 class="display-5 fw-bold mb-3" data-aos="fade-up">@lang('front/project.home_txt1')</h2>
                <p class="lead text-muted" data-aos="fade-up" data-aos-delay="200">@lang('front/project.home_txt2')</p>
            </div>
        </div>
        <div class="row g-4">
            @foreach ($projects as $project)
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="project-card">
                        <div class="project-image">
                            <img src="{{ $project->image }}" alt="{{ $project->title }}" class="img-fluid">
                            @if ($project->category_id)
                                <div class="project-overlay">
                                    <div class="project-status tamamlandi">{{ $project->category->title }}</div>
                                </div>
                            @endif
                        </div>
                        <div class="project-content">
                            <h5>{{ $project->title }}</h5>
                            <p class="text-muted">{{ $project->short_description }}</p>
                            <a href="{{ $project->url }}" class="btn btn-outline-primary btn-sm">@lang('front/project.home_txt3')</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="text-center mt-5" data-aos="fade-up">
            <a href="{{ route('projects.index') }}" class="btn btn-primary btn-lg">@lang('front/project.home_txt4')</a>
        </div>
    </div>
</section>
