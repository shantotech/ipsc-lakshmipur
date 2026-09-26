<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Notice extends Model
{
    use SoftDeletes;

    public const CATEGORIES = [
        'general' => 'General',
        'admission' => 'Admission',
        'recruitment' => 'Recruitment',
        'exam' => 'Exam & Results',
        'event' => 'Events',
        'holiday' => 'Holiday',
    ];

    protected $fillable = [
        'slug', 'category',
        'title_en', 'title_bn', 'excerpt_en', 'excerpt_bn', 'body_en', 'body_bn',
        'attachment', 'published_on', 'is_pinned', 'is_published',
    ];

    protected function casts(): array
    {
        return [
            'published_on' => 'date',
            'is_pinned' => 'boolean',
            'is_published' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Notice $notice) {
            if (blank($notice->slug)) {
                $notice->slug = static::uniqueSlug($notice->title_en);
            }
        });
    }

    public static function uniqueSlug(string $title): string
    {
        $base = Str::slug($title) ?: 'notice';
        $slug = $base;
        $i = 2;

        while (static::withTrashed()->where('slug', $slug)->exists()) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }

    /** Visible on the website: published and dated today or earlier. */
    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('is_published', true)->whereDate('published_on', '<=', now('Asia/Dhaka')->toDateString());
    }

    public function scopeLatestFirst(Builder $query): Builder
    {
        return $query->orderByDesc('is_pinned')->orderByDesc('published_on')->orderByDesc('id');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /** Text in the current language, falling back to English. */
    public function localized(string $field): ?string
    {
        $bn = $this->{$field.'_bn'};

        return app()->getLocale() === 'bn' && filled($bn) ? $bn : $this->{$field.'_en'};
    }

    public function title(): string
    {
        return (string) $this->localized('title');
    }

    public function excerpt(): string
    {
        $excerpt = $this->localized('excerpt');

        return filled($excerpt) ? $excerpt : Str::limit(trim(strip_tags((string) $this->localized('body'))), 180);
    }

    public function body(): ?string
    {
        return $this->localized('body');
    }

    public function attachmentUrl(): ?string
    {
        return $this->attachment ? Storage::disk('public')->url($this->attachment) : null;
    }

    public function categoryLabel(): string
    {
        return __(self::CATEGORIES[$this->category] ?? 'General');
    }
}
