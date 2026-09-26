<?php

namespace App\Filament\Resources\GalleryAlbums\Tables;

use App\Models\GalleryAlbum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class GalleryAlbumsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->with('cover')->withCount('photos'))
            ->defaultSort('sort_order')
            ->columns([
                ImageColumn::make('cover.image')
                    ->label('')
                    ->disk('public')
                    ->imageSize(56)
                    ->square()
                    ->defaultImageUrl(null),
                TextColumn::make('title_en')
                    ->label('Album')
                    ->description(fn (GalleryAlbum $record) => $record->title_bn)
                    ->searchable(['title_en', 'title_bn'])
                    ->wrap(),
                TextColumn::make('photos_count')
                    ->label('Photos')
                    ->badge()
                    ->color(fn (int $state) => $state > 0 ? 'success' : 'gray'),
                TextColumn::make('event_date')
                    ->label('Date')
                    ->date('d M Y')
                    ->placeholder('—')
                    ->sortable(),
                TextColumn::make('sort_order')
                    ->label('Position')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                ToggleColumn::make('is_published')
                    ->label('On website'),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make()->label('Open'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('No albums yet')
            ->emptyStateDescription('Create an album (for example "Campus" or "Sports Day"), then upload photos into it.');
    }
}
