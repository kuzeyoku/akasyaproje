<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="submenu-open">
                    <ul>
                        <li class="{{ App\Services\Admin\LayoutService::isActive("index") ? "active" : "" }}">
                            <a href="{{ route('admin.index') }}">
                                <i data-feather="grid"></i><span>@lang('admin/home.title')</span>
                            </a>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);"
                                class="{{ App\Services\Admin\LayoutService::isActive("setting") ? "subdrop active" : "" }}">
                                <i data-feather="settings"></i>
                                <span>@lang('admin/setting.title')</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul>
                                @foreach (App\Enums\SettingCategoryEnum::cases() as $setting)
                                    <li>
                                        <a href="{{ route('admin.settings', ['category' => $setting->value]) }}">{{ $setting->title() }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                        @foreach (App\Services\Admin\LayoutService::sidebarMenu() as $item)
                            <li @if ($item["submenu"])class="submenu" @endif>
                                <a href="{{ $item["url"] }}"
                                    class="{{ App\Services\Admin\LayoutService::isActive($item["enum"]->route()) ? "subdrop active" : "" }}"> 
                                    <i data-feather="{{ $item["enum"]->icon() }}"></i>
                                    <span>{{ $item["enum"]->menuTitle() }}</span>
                                    @if ($item["submenu"])
                                        <span class="menu-arrow"></span>
                                    @endif
                                </a>
                                @if ($item["submenu"])
                                    <ul>
                                        @foreach ($item["menu"] as $menu)
                                            <li>
                                                <a
                                                    href="{{ route('admin.' . $item["enum"]->route() . '.' . $menu) }}">@lang("admin/{$item['enum']->value}.$menu")</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>