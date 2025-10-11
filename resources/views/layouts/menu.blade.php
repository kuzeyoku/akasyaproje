<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="javascript:void(0)" role="button" data-bs-toggle="dropdown">{{ $menu->title }}</a>
    <ul class="dropdown-menu">
        @foreach ($menu->subMenu as $subMenu)
            @if ($subMenu->subMenu->isNotEmpty())
                @include('layouts.menu', ['menu' => $subMenu])
            @else
                <li><a class="dropdown-item" href="{{ $subMenu->url }}">{{ $subMenu->title }}</a></li>
            @endif
        @endforeach
    </ul>
</li>
