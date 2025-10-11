<?php

namespace App\Http\Controllers;

use App\Enums\ModuleEnum;
use App\Models\Category;
use App\Models\Reference;
use App\Models\Service;
use App\Services\CacheService;
use App\Services\SeoService;

class ServiceController extends Controller
{
    public function index()
    {
        SeoService::module(ModuleEnum::Service);
        $cacheKey = ModuleEnum::Service->value.'_index';
        $services = Service::active()->order()->get();
        $references = Reference::active()->order()->get();
        $categories = CacheService::cacheQuery($cacheKey, fn () => Category::module(ModuleEnum::Service)->active()->order()->get());

        return view('service.index', compact('categories', 'services', 'references'));
    }

    public function show(Service $service)
    {
        SeoService::show($service);
        $cacheKey = ModuleEnum::Service->value.'_'.$service->id.'_other';
        $otherServices = Service::active()->exclude($service->id)->order()->get();
        $references = Reference::active()->get();

        return view('service.show', compact('service', 'otherServices', 'references'));
    }
}
