<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

trait HasTranslations
{
    public function translate(): HasMany
    {
        if (! property_exists($this, 'translationModel') || ! property_exists($this, 'translationForeignKey')) {
            throw new \Exception('Translation model or foreign key not defined in '.static::class);
        }

        return $this->hasMany($this->translationModel, $this->translationForeignKey);
    }

    public function getTitleAttribute()
    {
        return $this->translate->where('lang', app()->getLocale())->pluck('title')->first();
    }

    public function getTitlesAttribute(): array
    {
        return $this->translate->pluck('title', 'lang')->all();
    }

    public function getDescriptionAttribute()
    {
        return $this->translate->where('lang', app()->getLocale())->pluck('description')->first();
    }

    public function getDescriptionsAttribute(): array
    {
        return $this->translate->pluck('description', 'lang')->all();
    }

    public function getTagsAttribute(): array
    {
        return $this->translate->pluck('tags', 'lang')->all();
    }

    public function getTagsToArrayAttribute(): array
    {
        $tags = $this->translate->where('lang', app()->getLocale())->value('tags');

        return array_filter(explode(',', $tags ?? ''));
    }

    public function getShortDescriptionAttribute(): string
    {
        return Str::limit(strip_tags($this->description), 80);
    }

    public function getMetaDescriptionAttribute(): string
    {
        $description = $this->translate->where('lang', app()->getFallbackLocale())->pluck('description')->first();

        return Str::limit(strip_tags($description), 160);
    }
}
