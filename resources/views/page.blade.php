@extends('layouts.main')
@section('content')
    <section class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center text-white">
                    <h1 class="display-4 fw-bold mb-3" data-aos="fade-up">{{ $page->title }}</h1>
                    <p class="lead" data-aos="fade-up" data-aos-delay="200">
                        @yield('description')
                    </p>
                </div>
            </div>
        </div>
    </section>
    <section class="py-5">
        <div class="container">
            <div class="page-content">
                {!! $page->description !!}
            </div>
        </div>
    </section>
@endsection
