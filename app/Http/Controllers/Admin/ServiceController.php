<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ModuleEnum;
use App\Http\Requests\GeneralStatusRequest;
use App\Http\Requests\Service\StoreServiceRequest;
use App\Http\Requests\Service\UpdateServiceRequest;
use App\Models\Service;
use App\Services\Admin\ServiceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Throwable;

class ServiceController extends Controller
{
    public function __construct(private readonly ServiceService $service)
    {
        View::share([
            'categories' => $service->getCategories(),
            'route' => $service->route(),
            'folder' => $service->folder(),
            'module' => ModuleEnum::Service,
        ]);
    }

    public function index()
    {
        $items = $this->service->getAll();

        return view(themeView('admin', "{$this->service->folder()}.index"), compact('items'));
    }

    public function create()
    {
        return view(themeView('admin', "{$this->service->folder()}.create"));
    }

    public function store(StoreServiceRequest $request)
    {
        try {
            $this->service->create($request->validated());

            return redirect()
                ->route("admin.{$this->service->route()}.index")
                ->with('success', __('admin/alert.default_success'));
        } catch (Throwable $e) {
            return back()
                ->withInput()
                ->with('error', __('admin/alert.default_error'));
        }
    }

    public function edit(Service $service)
    {
        return view(themeView('admin', "{$this->service->folder()}.edit"), compact('service'));
    }

    public function update(UpdateServiceRequest $request, Service $service)
    {
        try {
            $this->service->update($request->validated(), $service);

            return redirect()
                ->route("admin.{$this->service->route()}.index")
                ->with('success', __('admin/alert.default_success'));
        } catch (Throwable $e) {
            return back()
                ->withInput()
                ->with('error', __('admin/alert.default_error'));
        }
    }

    public function image(Service $service)
    {
        return view(themeView("admin", "{$this->service->folder()}.image"), compact("service"));
    }

    public function storeImage(Request $request, Service $service): object
    {
        try {
            $this->service->imageUpload($request->all(), $service);

            return (object) [
                'message' => __('admin/general.success'),
            ];
        } catch (Throwable $e) {
            return (object) [
                'message' => __('admin/general.error'),
            ];
        }
    }

    public function statusUpdate(GeneralStatusRequest $request, Service $service)
    {
        try {
            $this->service->statusUpdate($request->validated(), $service);

            return back()
                ->with('success', __('admin/alert.default_success'));
        } catch (Throwable $e) {
            return back()
                ->with('error', __('admin/alert.default_error'));
        }
    }

    public function destroy(Service $service)
    {
        try {
            $this->service->delete($service);

            return redirect()
                ->route("admin.{$this->service->route()}.index")
                ->with('success', __('admin/alert.default_success'));
        } catch (Throwable $e) {
            return back()
                ->with('error', __('admin/alert.default_error'));
        }
    }
}
