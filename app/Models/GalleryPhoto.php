<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class GalleryPhoto extends Model
{
    protected $fillable = ['gallery_album_id', 'image', 'caption_en', 'caption_bn', 'sort_order'];

    protected static function booted(): void
    {
        // Remove the image file when a photo is deleted.
        static::deleted(function (GalleryPhoto $photo) {
            if ($photo->image) {
                Storage::disk('public')->delete($photo->image);
            }
        });
    }

    public function album(): BelongsTo
    {
        return $this->belongsTo(GalleryAlbum::class, 'gallery_album_id');
    }

    public function url(): string
    {
        return Storage::disk('public')->url($this->image);
    }

    public function caption(): ?string
    {
        return app()->getLocale() === 'bn' && filled($this->caption_bn) ? $this->caption_bn : $this->caption_en;
    }
}
