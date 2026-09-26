<?php

namespace App\Filament\Resources\GalleryAlbums\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class GalleryAlbumForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Album')
                    ->description('Create the album first, then add photos to it below.')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('title_en')
                            ->label('Album name (English)')
                            ->placeholder('e.g. Annual Sports Day 2027')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('title_bn')
                            ->label('Album name (Bangla)')
                            ->helperText('Optional. If empty, the English name is shown.')
                            ->maxLength(255),
                        DatePicker::make('event_date')
                            ->label('Date')
                            ->helperText('Optional. When the photos were taken.')
                            ->native(false)
                            ->displayFormat('d M Y'),
                        TextInput::make('sort_order')
                            ->label('Position')
                            ->helperText('Lower numbers show first. Leave 0 to sort by date.')
                            ->numeric()
                            ->minValue(0)
                            ->default(0),
                        Toggle::make('is_published')
                            ->label('Show on website')
                            ->default(true),
                    ]),
            ]);
    }
}
