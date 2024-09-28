<?php

namespace App\Actions;

class DisplayDataWithCurrentLang
{
    public static function display($value)
    {
        // Assuming $value is a JSON string or array like: {"ar": "منتج", "en": "product"}
        $decodedValue = is_string($value) ? json_decode($value, true) : $value;

        $locale = app()->getLocale() ?? 'en';

        return $decodedValue[$locale] ?? $value;
    }
}
