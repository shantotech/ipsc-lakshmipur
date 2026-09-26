<?php

namespace App\Filament\Resources\GalleryAlbums\Pages;

use App\Filament\Resources\GalleryAlbums\GalleryAlbumResource;
use Filament\Resources\Pages\CreateRecord;

class CreateGalleryAlbum extends CreateRecord
{
    protected static string $resource = GalleryAlbumResource::class;

    /** Go straight to the album so photos can be uploaded. */
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('edit', ['record' => $this->getRecord()]);
    }
}
