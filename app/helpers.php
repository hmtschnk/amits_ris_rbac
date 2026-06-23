<?php
// app/Helpers/helpers.php

use App\Models\UiLabel;
use Illuminate\Support\Facades\Cache;

if (! function_exists('ui_label')) {
    function ui_label(string $key, ?string $lang = null): string
    {
        $lang = $lang ?? app()->getLocale() ?? 'en';

        $labels = Cache::remember("ui_labels.$lang", 3600, function () use ($lang) {
            return UiLabel::where('language', $lang)->pluck('label_text', 'label_key');
        });

        return $labels[$key] ?? $key; // fallback: show the key itself if missing
    }
}