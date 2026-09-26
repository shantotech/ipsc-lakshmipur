<?php

namespace App\Models\Concerns;

/** For models with *_en / *_bn columns: pick the current language, fall back to English. */
trait Localized
{
    public function localized(string $field): ?string
    {
        $bn = $this->{$field.'_bn'} ?? null;

        return app()->getLocale() === 'bn' && filled($bn) ? $bn : $this->{$field.'_en'};
    }
}
