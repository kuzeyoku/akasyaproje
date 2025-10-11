<?php

namespace App\Models;

use App\Enums\StatusEnum;

class Message extends BaseModel
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'ip',
        'user_agent',
        'consent',
        'status',
    ];

    public function scopeUnread($query)
    {
        return $query->whereStatus(StatusEnum::Unread);
    }

    protected static function boot(): void
    {
        parent::boot();
        static::addGlobalScope('order', function ($builder) {
            $builder->orderByDesc('created_at');
        });
    }
}
