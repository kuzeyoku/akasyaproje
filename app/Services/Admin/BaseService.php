<?php

namespace App\Services\Admin;

use App\Enums\ModuleEnum;
use App\Services\SettingService;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;

class BaseService
{
    private TranslationService $translationService;

    private MediaService $mediaService;

    public function __construct(private readonly Model $model, private readonly ModuleEnum $module)
    {
        $this->translationService = app(TranslationService::class);
        $this->mediaService = app(MediaService::class);
    }

    public function folder(): string
    {
        return $this->module->folder();
    }

    public function route(): string
    {
        return $this->module->route();
    }

    public function getAll(?int $perPage = null)
    {
        $perPage ??= SettingService::get('pagination', 'admin', 15);

        return $this->model->orderByDesc('id')->paginate($perPage);
    }

    public function create(array $data): Model
    {
        $item = $this->model->create($data);
        $this->translationService->sync($item, $data);
        $this->imageUpload($item, $data);

        return $item;
    }

    public function update(array $data, Model $item): Model
    {
        $item->update($data);
        $this->translationService->sync($item, $data);
        $this->imageUpload($item, $data);

        return $item;
    }

    public function statusUpdate(array $data, Model $item): bool
    {
        return $item->update($data);
    }

    public function delete(Model $item): ?bool
    {
        if ($item instanceof HasMedia) {
            $this->mediaService->clearMedia($item);
        }

        return $item->delete();
    }

    public function getCategories(): array
    {
        return CategoryService::getModuleCategories($this->module, true);
    }

    protected function imageUpload(Model $item, array $data)
    {
        if ($item instanceof HasMedia) {
            $this->mediaService->handleUploads($item, $data);
        }
    }
}
