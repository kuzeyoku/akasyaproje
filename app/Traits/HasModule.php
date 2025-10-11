<?php

namespace App\Traits;

trait HasModule
{
    public function getModuleAttribute()
    {
        if (! property_exists($this, 'module')) {
            return throw new \Exception('Module property not defined in '.static::class);
        }

        return $this->module->title();
    }

    public function getUrlAttribute(): string
    {
        if (! property_exists($this, 'module')) {
            return throw new \Exception('Module property not defined in '.static::class);
        }

        return $this->slug ? route($this->module->route().'.show', [$this->id, $this->slug]) : '';
    }
}
