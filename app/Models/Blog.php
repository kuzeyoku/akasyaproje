<?php

namespace App\Models;

use App\Enums\ModuleEnum;
use App\Traits\HasCategory;
use App\Traits\HasComments;
use App\Traits\HasModule;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Blog extends BaseModel implements HasMedia
{
    use HasCategory;
    use HasComments;
    use HasModule;
    use HasTranslations;
    use InteractsWithMedia;

    protected $translationModel = BlogTranslate::class;

    protected $commentModel = BlogComment::class;

    protected $translationForeignKey = 'blog_id';

    protected $commentForeignKey = 'blog_id';

    protected $module = ModuleEnum::Blog;

    protected $appends = [
        'title',
        'titles',
        'description',
        'descriptions',
        'tags',
        'tags_to_array',
        'short_description',
        'meta_description',
    ];

    protected $fillable = [
        'slug',
        'status',
        'category_id',
        'user_id',
        'order',
    ];

    protected $with = ['category', 'translate', 'user', 'comments'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($model) {
            $model->user_id = \Illuminate\Support\Facades\Auth::id();
            $model->slug = Str::slug(request('title.'.app()->getFallbackLocale()));
        });
    }
}
