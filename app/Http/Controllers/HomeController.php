<?php

namespace App\Http\Controllers;

use App\Enums\ModuleEnum;
use App\Models\Blog;
use App\Models\Page;
use App\Models\Project;
use App\Models\Reference;
use App\Models\Service;
use App\Models\Slider;
use App\Models\Testimonial;
use App\Services\CacheService;
use App\Services\SeoService;

class HomeController extends Controller
{
    public function index()
    {
        SeoService::index();
        $data['services'] = $this->getModuleData(ModuleEnum::Service, Service::class, 6);
        $data['references'] = $this->getModuleData(ModuleEnum::Reference, Reference::class);
        $data['sliders'] = $this->getModuleData(ModuleEnum::Slider, Slider::class);
        $data['projects'] = $this->getModuleData(ModuleEnum::Project, Project::class, 6);
        $data['testimonials'] = $this->getModuleData(ModuleEnum::Testimonial, Testimonial::class);
        $data['blogs'] = $this->getModuleData(ModuleEnum::Blog, Blog::class, 3);
        $data['about'] = CacheService::cacheQuery('about_home', fn () => Page::find(setting('information', 'about_page')));

        return view('index', $data);
    }

    private function getModuleData(ModuleEnum $module, $model, $limit = 0)
    {
        $query = $model::active()->order();
        if ($limit > 0) {
            $query->limit($limit);
        }

        return CacheService::cacheQuery($module->value.'_home', fn () => $query->get());
    }
}
