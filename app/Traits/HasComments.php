<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasComments
{
    public function comments(): HasMany
    {
        if (! property_exists($this, 'commentModel') || ! property_exists($this, 'commentForeignKey')) {
            throw new \Exception('Comment model or foreign key not defined in '.static::class);
        }

        return $this->hasMany($this->commentModel, $this->commentForeignKey);
    }
}
