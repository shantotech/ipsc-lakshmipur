<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class GalleryAlbum extends Model
{
    use SoftDeletes;

    protected $fillable = ['slug', 'title_en', 'title_bn', 'event_date', 'sort_order', 'is_published'];

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'is_published' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (GalleryAlbum $album) {
            if (blank($album->slug)) {
                $base = Str::slug($album->title_en) ?: 'album';
                $slug = $base;
                $i = 2;
                while (static::withTrashed()->where('slug', $slug)->whereKeyNot($album->getKey())->exists()) {
                    $slug = $base.'-'.$i++;
                }
                $album->slug = $slug;
            }
        });

        // Permanently deleting an album also removes its photo files.
        static::forceDeleting(function (GalleryAlbum $album) {
            $album->photos()->get()->each->delete();
        });
    }

    public function photos(): HasMany
    {
        return $this->hasMany(GalleryPhoto::class)->orderBy('sort_order')->orderBy('id');
    }

    public function cover(): HasOne
    {
        return $this->hasOne(GalleryPhoto::class)->orderBy('sort_order')->orderBy('id');
    }

    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('is_published', true)->whereHas('photos');
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderByDesc('event_date')->orderByDesc('id');
    }

    public function title(): string
    {
        return app()->getLocale() === 'bn' && filled($this->title_bn) ? $this->title_bn : $this->title_en;
    }
}
