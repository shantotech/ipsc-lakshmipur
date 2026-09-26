<?php

namespace App\Support;

use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Throwable;

/**
 * Site-wide settings edited in the admin (Settings page).
 *
 * Every setting falls back to the text in lang/{en,bn}/site.php, so an empty
 * setting never breaks the site. Bilingual settings are stored as key_en and
 * key_bn; the Bangla value falls back to English.
 *
 * In views: Site::get('phone'), Site::get('hero_title'), Site::logoUrl() ...
 */
class Site
{
    /** Bilingual settings => fallback translation key. */
    public const TRANSLATED = [
        'school_name' => 'site.school.name',
        'branch' => 'site.school.branch',
        'tagline' => 'site.school.tagline',
        'version' => 'site.school.version',
        'address' => 'site.school.address',
        'office_hours' => 'site.school.office_hours',
        'meta_description' => 'site.meta.description',
        'hero_eyebrow' => 'site.hero.eyebrow',
        'hero_title' => 'site.hero.title',
        'hero_text' => 'site.hero.text',
        'announcement_text' => 'site.announcement.text',
        'announcement_link_label' => 'site.announcement.link_label',
    ];

    /** Single-value settings => fallback translation key (or null). */
    public const PLAIN = [
        'phone' => 'site.school.phone',
        'phone_2' => null,
        'email' => 'site.school.email',
        'facebook' => 'site.school.facebook',
        'youtube' => 'site.school.youtube',
        'map_query' => 'site.contact.map_query',
        'map_link' => null,
        'logo' => null,
        'announcement_enabled' => null,
        'announcement_url' => null,
    ];

    protected static ?array $values = null;

    /** All stored values, loaded once per request. */
    public static function values(): array
    {
        if (static::$values !== null) {
            return static::$values;
        }

        try {
            return static::$values = Schema::hasTable('settings')
                ? Setting::query()->pluck('value', 'key')->all()
                : [];
        } catch (Throwable) {
            return static::$values = [];
        }
    }

    public static function raw(string $key): ?string
    {
        $value = static::values()[$key] ?? null;

        return filled($value) ? $value : null;
    }

    /** The setting in the current language, falling back to English, then the default text. */
    public static function get(string $key): ?string
    {
        if (array_key_exists($key, static::TRANSLATED)) {
            $value = app()->getLocale() === 'bn' ? static::raw($key.'_bn') : null;

            return $value ?? static::raw($key.'_en') ?? __(static::TRANSLATED[$key]);
        }

        $fallback = static::PLAIN[$key] ?? null;

        return static::raw($key) ?? ($fallback ? __($fallback) : null);
    }

    /** Save many settings at once (from the admin form). */
    public static function save(array $data): void
    {
        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => is_bool($value) ? ($value ? '1' : '0') : $value]);
        }

        static::$values = null;
    }

    /** Stored values shaped for the admin form. */
    public static function formData(): array
    {
        $data = [];

        foreach (array_keys(static::TRANSLATED) as $key) {
            $data[$key.'_en'] = static::raw($key.'_en');
            $data[$key.'_bn'] = static::raw($key.'_bn');
        }

        foreach (array_keys(static::PLAIN) as $key) {
            $data[$key] = static::raw($key);
        }

        $data['announcement_enabled'] = static::announcementEnabled();

        return $data;
    }

    public static function fullName(): string
    {
        return static::get('school_name').', '.static::get('branch');
    }

    public static function phoneHref(?string $phone = null): string
    {
        return 'tel:'.preg_replace('/[^0-9+]/', '', $phone ?? (string) static::get('phone'));
    }

    public static function logoUrl(): ?string
    {
        if ($logo = static::raw('logo')) {
            return Storage::disk('public')->url($logo);
        }

        foreach (['images/logo.svg', 'images/logo.png'] as $path) {
            if (file_exists(public_path($path))) {
                return asset($path);
            }
        }

        return null;
    }

    public static function announcementEnabled(): bool
    {
        return static::raw('announcement_enabled') !== '0';
    }

    public static function announcementUrl(): string
    {
        $url = static::raw('announcement_url');

        return $url ? \App\Models\HeroSlide::href($url) : route('admission.apply');
    }

    /** Changes when the announcement text changes, so visitors see new announcements. */
    public static function announcementId(): string
    {
        return 'a-'.substr(md5((string) static::get('announcement_text')), 0, 10);
    }

    /** Social links that are actually filled in. */
    public static function socialLinks(): array
    {
        return array_filter([
            'facebook' => static::get('facebook'),
            'youtube' => static::get('youtube'),
        ], fn ($url) => filled($url) && $url !== '#');
    }
}
