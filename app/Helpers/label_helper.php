<?php
// app/Helpers/helpers.php

use App\Models\UiLabel;
use Illuminate\Support\Facades\Cache;

if (! function_exists('ui_label')) {
    function ui_label(string $key)
    {
        $lang = app()->getLocale();

        return Cache::remember(
            "ui_label_{$key}_{$lang}",
            3600,
            function () use ($key, $lang) {
                return UiLabel::where('label_key', $key)
                    ->where('language', $lang)
                    ->value('label_text')
                    ?? $key;
            }
        );
    }
}
