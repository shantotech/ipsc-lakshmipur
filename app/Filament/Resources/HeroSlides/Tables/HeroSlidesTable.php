<?php

namespace App\Filament\Resources\HeroSlides\Tables;

use App\Models\HeroSlide;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class HeroSlidesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->description('Slides play in this order (#). Drag the handle to reorder, or set Position and Show for (seconds) when editing a slide. The main homepage text stays on top of every slide unless a slide has its own title. With no slides, the homepage shows the standard welcome section.')
            ->columns([
                TextColumn::make('sort_order')
                    ->label('#')
                    ->badge()
                    ->color('gray')
                    ->width('1%'),
                ImageColumn::make('image')
                    ->label('')
                    ->disk('public')
                    ->imageWidth(120)
                    ->imageHeight(68)
                    ->extraImgAttributes(['class' => 'rounded-md object-cover']),
                TextColumn::make('title_en')
                    ->label('Title')
                    ->placeholder('Main homepage text')
                    ->description(fn (HeroSlide $record) => $record->title_bn)
                    ->wrap(),
                TextColumn::make('media_type')
                    ->label('Type')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => $state === 'video' ? 'Video' : 'Photo')
                    ->icon(fn (string $state) => $state === 'video' ? Heroicon::OutlinedFilm : Heroicon::OutlinedPhoto)
                    ->color(fn (string $state) => $state === 'video' ? 'info' : 'gray'),
                TextColumn::make('image_mobile')
                    ->label('Mobile photo')
                    ->state(fn (HeroSlide $record) => $record->isVideo() ? '—' : ($record->image_mobile ? 'Yes' : 'Uses computer photo'))
                    ->color(fn (HeroSlide $record) => $record->image_mobile ? 'success' : 'gray')
                    ->icon(fn (HeroSlide $record) => $record->image_mobile ? Heroicon::OutlinedDevicePhoneMobile : null),
                TextColumn::make('duration_seconds')
                    ->label('Shows for')
                    ->state(fn (HeroSlide $record) => ($record->durationMs() / 1000).' sec'),
                ToggleColumn::make('is_active')->label('On website'),
            ])
            ->reorderRecordsTriggerAction(fn ($action, bool $isReordering) => $action->label($isReordering ? 'Done reordering' : 'Reorder slides'))
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->paginated(false)
            ->emptyStateIcon(Heroicon::OutlinedFilm)
            ->emptyStateHeading('No slides yet')
            ->emptyStateDescription('Add a campus video or photos to show a full-width slider at the top of the homepage.');
    }
}
