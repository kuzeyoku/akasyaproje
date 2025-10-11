<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends BaseModel
{
    use HasTranslations;

    protected $translationModel = MenuTranslate::class;

    protected $translationForeignKey = 'menu_id';

    protected $fillable = [
        'url',
        'parent_id',
        'order',
        'blank',
    ];

    public $timestamps = false;

    protected $with = ['translate', 'subMenu'];

    public function subMenu(): HasMany
    {
        return $this->hasMany(Menu::class, 'parent_id');
    }

    public static function boot(): void
    {
        parent::boot();
        self::deleting(function ($model) {
            $model->subMenu()->delete();
        });
    }
}
