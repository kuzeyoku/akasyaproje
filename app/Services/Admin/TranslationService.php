<?php

namespace App\Services\Admin;

use Illuminate\Database\Eloquent\Model;

class TranslationService
{
    public function sync(Model $item, array $data, array $fields = ['title', 'description', 'tags', 'features']): void
    {
        if (method_exists($item, 'translate')) {

            languageList()->each(function ($lang) use ($item, $data, $fields) {
                $queryData = [];
                foreach ($fields as $field) {
                    $queryData[$field] = $data[$field][$lang->code] ?? null;
                }
                $item->translate()->updateOrCreate(
                    [
                        'lang' => $lang->code,
                    ],
                    $queryData
                );
            });
        }
    }
}
