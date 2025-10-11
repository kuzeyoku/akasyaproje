<?php

namespace App\Services\Admin;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingService
{
    public function update(Request $request)
    {
        if ($request->category === 'asset') {
            return $this->assetUpload($request);
        }

        $settings = collect($request->except('_token', '_method', 'category'))
            ->map(function ($value, $key) use ($request) {
                return [
                    'key' => $key,
                    'value' => $value,
                    'category' => $request->category,
                ];
            })->values()->toArray();

        return Setting::upsert($settings, ['key', 'category'], ['value']);
    }

    public function assetUpload($request)
    {
        foreach ($request->files as $key => $value) {
            if ($request->hasFile($key)) {
                $setting = Setting::updateOrCreate(
                    ['key' => $key, 'category' => 'asset'],
                    ['value' => 'image']
                );

                $setting->clearMediaCollection();
                $setting->addMediaFromRequest($key)
                    ->usingFileName($key.'.'.$request->{$key}->extension())
                    ->toMediaCollection();
            }
        }
    }

    public function getCategory($category)
    {
        $settings = Setting::where('category', $category)->get();
        if ($category == 'asset') {
            $settings->each(function ($setting) {
                $setting->media_url = $setting->getFirstMediaUrl();
            });

            return $settings->pluck('media_url', 'key');
        }

        return $settings->pluck('value', 'key');
    }

    public static function getChangeFreqList(): array
    {
        return [
            'always' => __('admin/setting.sitemap_changefreq_always'),
            'hourly' => __('admin/setting.sitemap_changefreq_hourly'),
            'daily' => __('admin/setting.sitemap_changefreq_daily'),
            'weekly' => __('admin/setting.sitemap_changefreq_weekly'),
            'monthly' => __('admin/setting.sitemap_changefreq_monthly'),
            'yearly' => __('admin/setting.sitemap_changefreq_yearly'),
            'never' => __('admin/setting.sitemap_changefreq_never'),
        ];
    }
}
