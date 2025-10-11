<?php

namespace App\Models;

use App\Enums\StatusEnum;
use App\Services\CacheService;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    public function getImageAttribute(): string
    {
        return CacheService::remember($this->module->value.'_image_'.$this->id, function () {
            return $this->getFirstMediaUrl() ?? asset('assets/common/images/noimage.jpg');
        });
    }

    public function getOtherAttribute($limit = 5)
    {
        return $this->where('id', '!=', $this->id)->limit($limit)->get();
    }

    public function getPreviousAttribute()
    {
        return $this->where('id', '>', $this->id)->orderBy('id', 'ASC')->first();
    }

    public function getNextAttribute()
    {
        return $this->where('id', '<', $this->id)->orderBy('id', 'ASC')->first();
    }

    public function getStatusViewAttribute(): string
    {
        return StatusEnum::fromValue($this->status)->badge();
    }

    public function scopeActive($query)
    {
        return $query->where('status', StatusEnum::Active->value);
    }

    public function scopeOrder($query)
    {
        return $query->orderBy('order', 'asc')->orderBy('id', 'desc');
    }

    public function scopeViewOrder($query)
    {
        return $query->orderBy('view_count', 'desc');
    }

    public function scopeExclude($query, $id)
    {
        return $query->where('id', '!=', $id);
    }
}
