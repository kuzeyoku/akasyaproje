<?php

namespace App\Enums;

enum PageTypeEnum: string
{
    case Cookie = 'cookie_policy';
    case Privacy = 'privacy_policy';
    case Terms = 'terms_of_service';
    case KVKK = 'kvkk';

    public static function getValues(): array
    {
        return [
            self::Cookie->value,
            self::Privacy->value,
            self::Terms->value,
            self::KVKK->value,
        ];
    }

    public static function toSelectArray(): array
    {
        return [
            self::Cookie->value => 'Çerez Politikası',
            self::Privacy->value => 'Gizlilik Politikası',
            self::Terms->value => 'Kullanım Sözleşmesi',
            self::KVKK->value => 'KVKK',
        ];
    }
}
