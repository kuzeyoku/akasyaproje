<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\GeneralStatusRequest;
use App\Http\Requests\Project\ImageProjectRequest;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Models\Project;
use App\Services\Admin\MediaService;
use App\Services\Admin\ProjectService;
use Exception;
use Illuminate\Support\Facades\View;

class ProjectController extends Controller
{
    public function __construct(private readonly ProjectService $service)
    {
        View::share([
            'route' => $service->route(),
            'folder' => $service->folder(),
        ]);
    }

    public function index()
    {
        $items = $this->service->getAll();

        return view(themeView('admin', "{$this->service->folder()}.index"), compact('items'));
    }

    public function image(Project $project)
    {
        return view(themeView('admin', "{$this->service->folder()}.image"), compact('project'));
    }

    public function storeImage(ImageProjectRequest $request, Project $project): object
    {
        try {
            $this->service->imageUpload($request->validated(), $project);

            return (object) [
                'message' => __('admin/general.success'),
            ];
        } catch (Exception $e) {
            return (object) [
                'message' => __('admin/general.error'),
            ];
        }
    }

    public function destroyAllImages(Project $project)
    {
        try {
            app(MediaService::class)->clearMedia($project, 'gallery');

            return back()->with('success', __('admin/alert.default_success'));
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function create()
    {
        $categories = $this->service->getCategories();

        return view(themeView('admin', "{$this->service->folder()}.create"), compact('categories'));
    }

    public function store(StoreProjectRequest $request)
    {
        try {
            $this->service->create($request->validated());

            return redirect()
                ->route("admin.{$this->service->route()}.index")
                ->with('success', __('admin/alert.default_success'));
        } catch (Exception $e) {
            return back()
                ->withInput()
                ->with('error', __('admin/alert.default_error'));
        }
    }

    public function edit(Project $project)
    {
        $categories = $this->service->getCategories();

        return view(themeView('admin', "{$this->service->folder()}.edit"), compact('project', 'categories'));
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        try {
            $this->service->update($request->validated(), $project);

            return redirect()
                ->route("admin.{$this->service->route()}.index")
                ->with('success', __('admin/alert.default_success'));
        } catch (Exception $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function statusUpdate(GeneralStatusRequest $request, Project $project)
    {
        try {
            $this->service->statusUpdate($request->validated(), $project);

            return back()
                ->with('success', __('admin/alert.default_success'));
        } catch (Exception $e) {
            return back()
                ->with('error', __('admin/alert.default_error'));
        }
    }

    public function destroy(Project $project)
    {
        try {
            $this->service->delete($project);

            return redirect()
                ->route("admin.{$this->service->route()}.index")
                ->with('success', __('admin/alert.default_success'));
        } catch (Exception $e) {
            return back()
                ->with('error', __('admin/alert.default_error'));
        }
    }
}
