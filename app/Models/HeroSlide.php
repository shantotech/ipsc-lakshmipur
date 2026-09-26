<?php

namespace App\Models;

use App\Models\Concerns\Localized;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class HeroSlide extends Model
{
    use Localized;

    protected $fillable = [
        'media_type', 'image', 'video',
        'eyebrow_en', 'eyebrow_bn', 'title_en', 'title_bn', 'text_en', 'text_bn',
        'button_label_en', 'button_label_bn', 'button_url', 'sort_order', 'is_active',
    ];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    protected static function booted(): void
    {
        // New slides go to the end of the slider.
        static::creating(function (HeroSlide $slide) {
            if (! $slide->sort_order) {
                $slide->sort_order = (int) static::max('sort_order') + 1;
            }
        });

        static::deleted(function (HeroSlide $slide) {
            Storage::disk('public')->delete(array_filter([$slide->image, $slide->video]));
        });
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)
            ->where(fn ($q) => $q->where(fn ($q) => $q->where('media_type', 'image')->whereNotNull('image'))
                ->orWhere(fn ($q) => $q->where('media_type', 'video')->whereNotNull('video')))
            ->orderBy('sort_order')->orderBy('id');
    }

    public function isVideo(): bool
    {
        return $this->media_type === 'video' && filled($this->video);
    }

    public function imageUrl(): ?string
    {
        return $this->image ? Storage::disk('public')->url($this->image) : null;
    }

    public function videoUrl(): ?string
    {
        return $this->video ? Storage::disk('public')->url($this->video) : null;
    }

    /** Relative links like "/en/admission" or "admission" are made absolute; external links are kept. */
    public function buttonHref(): ?string
    {
        return self::href($this->button_url);
    }

    public static function href(?string $url): ?string
    {
        if (blank($url)) {
            return null;
        }

        return preg_match('#^(https?:|mailto:|tel:|/)#i', $url) ? $url : url(app()->getLocale().'/'.ltrim($url, '/'));
    }
}
