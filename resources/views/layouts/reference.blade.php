<section class="py-5 bg-light" id="references">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center mb-5">
                <h2 class="display-5 fw-bold mb-3" data-aos="fade-up">@lang('front/reference.txt1')</h2>
                <p class="lead text-muted" data-aos="fade-up" data-aos-delay="200">
                    @lang('front/reference.txt2')
                </p>
            </div>
        </div>
        <div class="row align-items-center g-4">
            @foreach ($references as $reference)
                <div class="col-lg-2 col-md-4 col-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="reference-logo">
                        <img src="{{ $reference->image }}" alt="{{ $reference->title }}" class="img-fluid">
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</section>
