<?php

namespace App\Filament\Resources\Popups\Tables;

use App\Models\Popup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class PopupsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('updated_at', 'desc')
            ->description('Only one popup shows at a time: the most recently edited one that is turned on and within its dates. It appears every time the homepage opens.')
            ->columns([
                ImageColumn::make('image')->label('')->disk('public')->imageWidth(90)->imageHeight(56)->extraImgAttributes(['class' => 'rounded-md object-cover']),
                TextColumn::make('title_en')->label('Title')->description(fn (Popup $record) => $record->title_bn)->wrap()->searchable(),
                TextColumn::make('starts_at')->label('From')->dateTime('d M Y, h:i A', 'Asia/Dhaka')->placeholder('Now'),
                TextColumn::make('ends_at')->label('Until')->dateTime('d M Y, h:i A', 'Asia/Dhaka')->placeholder('Turned off'),
                TextColumn::make('status')
                    ->state(fn (Popup $record) => $record->isLive() ? 'Showing' : ($record->is_active && $record->starts_at?->isFuture() ? 'Scheduled' : 'Not showing'))
                    ->badge()
                    ->color(fn (string $state) => match ($state) { 'Showing' => 'success', 'Scheduled' => 'info', default => 'gray' }),
                ToggleColumn::make('is_active')->label('On'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->emptyStateIcon(Heroicon::OutlinedWindow)
            ->emptyStateHeading('No popups')
            ->emptyStateDescription('Create a popup to announce an event, like a parenting conference or admission test.');
    }
}
