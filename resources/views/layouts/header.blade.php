    <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold fs-3" href="{{ route('home') }}">
                <img width="150" src="{{ asset('assets/img/logo.png') }}" alt="">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @foreach ($menus as $menu)
                        @if ($menu->parent_id == 0)
                            @if ($menu->subMenu->isNotEmpty())
                                @include('layouts.menu', ['menu' => $menu])
                            @else
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ $menu->url }}">{{ $menu->title }}</a>
                                </li>
                            @endif
                        @endif
                    @endforeach
                    <li class="nav-item">
                        <a class="btn btn-primary ms-2" href="{{ route('contact.index') }}">@lang('front/header.txt1')</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
