@if ($categories)
    <div class="sidebar-widget" data-aos="fade-left" data-aos-delay="400">
        <h5 class="widget-title">Kategoriler</h5>
        <ul class="category-list">
            @foreach ($categories as $category)
                <li><a href="{{ $category->url }}">{{ $category->title }} <span
                            class="post-count">{{ $category->blogs->count() }}</span></a></li>
            @endforeach
        </ul>
    </div>
@endif
<div class="sidebar-widget">
    <h5 class="widget-title">Popüler Konular</h5>
    <ul class="topics-list p-0">
        @foreach ($popularPosts as $item)
            <li class="topic-item">
                <a href={{ $item->url }}" class="topic-link">
                    <div class="topic-content">
                        <img src="{{ $item->image }}" alt="Kadastral Haritalama" class="article-image">
                        <div class="topic-text-content">
                            <h6 class="topic-title">{{ $item->title }}</h6>
                            <span class="topic-date">{{ $item->created_at->format('d M Y') }}</span>
                        </div>
                    </div>
                </a>
            </li>
        @endforeach
    </ul>
</div>
