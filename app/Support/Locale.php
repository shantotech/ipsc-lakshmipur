<?php

namespace App\Support;

use Illuminate\Support\Facades\Route;
use IntlDateFormatter;

/**
 * Small helpers for the bilingual (Bangla / English) site.
 */
class Locale
{
    public static function isBangla(): bool
    {
        return app()->getLocale() === 'bn';
    }

    /**
     * The same page in the other language.
     */
    public static function switchUrl(): string
    {
        $target = self::isBangla() ? 'en' : 'bn';
        $route = Route::current();

        if (! $route || ! $route->getName()) {
            return url($target);
        }

        return route($route->getName(), array_merge($route->parameters(), ['locale' => $target]));
    }

    /**
     * Converts 0-9 to Bangla digits when the site is in Bangla.
     */
    public static function number(int|float|string $value): string
    {
        $value = (string) $value;

        if (! self::isBangla()) {
            return $value;
        }

        return strtr($value, ['0' => '০', '1' => '১', '2' => '২', '3' => '৩', '4' => '৪', '5' => '৫', '6' => '৬', '7' => '৭', '8' => '৮', '9' => '৯']);
    }

    /**
     * Formats a Y-m-d date, e.g. "16 Aug 2026" or "১৬ আগস্ট ২০২৬".
     */
    public static function date(string $date, string $pattern = 'd MMM y'): string
    {
        $formatter = new IntlDateFormatter(
            self::isBangla() ? 'bn_BD' : 'en_GB',
            IntlDateFormatter::NONE,
            IntlDateFormatter::NONE,
            'Asia/Dhaka',
            IntlDateFormatter::GREGORIAN,
            $pattern,
        );

        return self::number($formatter->format(new \DateTimeImmutable($date, new \DateTimeZone('Asia/Dhaka'))));
    }

    /**
     * Picks the Bangla or English value from a ['bn' => ..., 'en' => ...] pair.
     */
    public static function pick(array|string|null $value): mixed
    {
        if (! is_array($value)) {
            return $value;
        }

        return $value[app()->getLocale()] ?? $value['en'] ?? reset($value);
    }
}
