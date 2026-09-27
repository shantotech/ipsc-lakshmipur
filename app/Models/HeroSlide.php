<?php

namespace App\Models;

use App\Models\Concerns\Localized;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class HeroSlide extends Model
{
    use Localized;

    public const DEFAULT_PHOTO_SECONDS = 7;

    public const DEFAULT_VIDEO_SECONDS = 12;

    private static bool $renumbering = false;

    protected $fillable = [
        'media_type', 'image', 'image_mobile', 'video',
        'eyebrow_en', 'eyebrow_bn', 'title_en', 'title_bn', 'text_en', 'text_bn',
        'button_label_en', 'button_label_bn', 'button_url', 'duration_seconds', 'sort_order', 'is_active',
    ];

    protected function casts(): array
    {
        return ['is_active' => 'boolean', 'duration_seconds' => 'integer', 'sort_order' => 'integer'];
    }

    protected static function booted(): void
    {
        // New slides go to the end of the slider.
        static::creating(function (HeroSlide $slide) {
            if (! $slide->sort_order) {
                $slide->sort_order = (int) static::max('sort_order') + 1;
            }
        });

        // Delete old files when they are replaced or removed.
        static::updated(function (HeroSlide $slide) {
            foreach (['image', 'image_mobile', 'video'] as $field) {
                $old = $slide->getOriginal($field);
                if ($old && $slide->wasChanged($field)) {
                    Storage::disk('public')->delete($old);
                }
            }
        });

        // Keep positions tidy (1, 2, 3 ...). A slide moved to position 2
        // takes that place and the others shift down.
        static::saved(function (HeroSlide $slide) {
            if (! self::$renumbering && ($slide->wasRecentlyCreated || $slide->wasChanged('sort_order'))) {
                static::renumber($slide);
            }
        });

        static::deleted(function (HeroSlide $slide) {
            Storage::disk('public')->delete(array_filter([$slide->image, $slide->image_mobile, $slide->video]));
            static::renumber();
        });
    }

    public static function renumber(?HeroSlide $moved = null): void
    {
        self::$renumbering = true;

        try {
            $others = static::query()
                ->when($moved, fn ($q) => $q->whereKeyNot($moved->getKey()))
                ->orderBy('sort_order')->orderBy('id')
                ->get();

            if ($moved) {
                $index = max(0, min($others->count(), (int) $moved->sort_order - 1));
                $others->splice($index, 0, [$moved]);
            }

            $others->values()->each(function (HeroSlide $slide, int $i) {
                if ($slide->sort_order !== $i + 1) {
                    $slide->sort_order = $i + 1;
                    $slide->saveQuietly();
                }
            });
        } finally {
            self::$renumbering = false;
        }
    }

    /** How long this slide stays on screen, in milliseconds. */
    public function durationMs(): int
    {
        $seconds = $this->duration_seconds ?: ($this->isVideo() ? self::DEFAULT_VIDEO_SECONDS : self::DEFAULT_PHOTO_SECONDS);

        return max(2, min(120, $seconds)) * 1000;
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

    /** Tall photo for phones (photo slides only). */
    public function mobileImageUrl(): ?string
    {
        return ! $this->isVideo() && $this->image_mobile ? Storage::disk('public')->url($this->image_mobile) : null;
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
