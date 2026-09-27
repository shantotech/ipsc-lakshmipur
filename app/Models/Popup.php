<?php

namespace App\Models;

use App\Models\Concerns\Localized;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Popup extends Model
{
    use Localized;

    protected $fillable = [
        'title_en', 'title_bn', 'body_en', 'body_bn', 'image',
        'button_label_en', 'button_label_bn', 'button_url', 'starts_at', 'ends_at', 'repeat_after_hours', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'is_active' => 'boolean',
            'repeat_after_hours' => 'integer',
        ];
    }

    /** The popup to show right now, if any (newest active one within its dates). */
    public static function current(): ?self
    {
        $now = now();

        return static::query()
            ->where('is_active', true)
            ->where(fn ($q) => $q->whereNull('starts_at')->orWhere('starts_at', '<=', $now))
            ->where(fn ($q) => $q->whereNull('ends_at')->orWhere('ends_at', '>=', $now))
            ->latest('updated_at')
            ->first();
    }

    public function isLive(): bool
    {
        return $this->is_active
            && (! $this->starts_at || $this->starts_at->isPast())
            && (! $this->ends_at || $this->ends_at->isFuture());
    }

    public function imageUrl(): ?string
    {
        return $this->image ? Storage::disk('public')->url($this->image) : null;
    }

    /** Changes whenever the popup is edited, so an edited popup shows again. */
    public function versionKey(): string
    {
        return 'popup-'.$this->id.'-'.$this->updated_at?->timestamp;
    }
}
