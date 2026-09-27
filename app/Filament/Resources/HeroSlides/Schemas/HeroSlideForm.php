<?php

namespace App\Filament\Resources\HeroSlides\Schemas;

use App\Models\HeroSlide;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class HeroSlideForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make('Background')
                    ->columnSpan(2)
                    ->schema([
                        ToggleButtons::make('media_type')
                            ->label('Type')
                            ->options(['image' => 'Photo', 'video' => 'Video'])
                            ->icons(['image' => Heroicon::OutlinedPhoto, 'video' => Heroicon::OutlinedFilm])
                            ->default('image')
                            ->inline()
                            ->live()
                            ->required(),
                        FileUpload::make('video')
                            ->label('Video (MP4 or WebM)')
                            ->disk('public')
                            ->directory('hero')
                            ->acceptedFileTypes(['video/mp4', 'video/webm'])
                            ->maxSize(51200)
                            ->helperText('MP4, up to 50 MB. Best: 10–30 seconds, 1280×720, no sound needed (it plays muted). Smaller files load faster on phones.')
                            ->visible(fn (Get $get) => $get('media_type') === 'video')
                            ->required(fn (Get $get) => $get('media_type') === 'video'),
                        FileUpload::make('image')
                            ->label(fn (Get $get) => $get('media_type') === 'video' ? 'Cover photo (shown while the video loads)' : 'Computer photo (wide)')
                            ->image()
                            ->disk('public')
                            ->directory('hero')
                            ->imageResizeMode('cover')
                            ->imageResizeTargetWidth('1920')
                            ->imageResizeTargetHeight('1080')
                            ->imageResizeUpscale(false)
                            ->maxSize(15360)
                            ->helperText('Landscape photo for computers and tablets. Resized to 1920×1080 automatically.')
                            ->required(fn (Get $get) => $get('media_type') !== 'video'),
                        FileUpload::make('image_mobile')
                            ->label('Mobile photo (tall) — optional')
                            ->image()
                            ->disk('public')
                            ->directory('hero')
                            ->imageResizeMode('contain')
                            ->imageResizeTargetWidth('1080')
                            ->imageResizeTargetHeight('1920')
                            ->imageResizeUpscale(false)
                            ->maxSize(15360)
                            ->helperText('Portrait photo shown on phones, e.g. 1080×1920 (9:16) or 1080×1350 (4:5). When the headline is on, it covers the middle of the photo, so keep faces and the building near the top or bottom. If empty, phones show the computer photo.')
                            ->visible(fn (Get $get) => $get('media_type') !== 'video'),
                    ]),
                Section::make('Settings')
                    ->columnSpan(1)
                    ->schema([
                        Toggle::make('is_active')->label('Show on website')->default(true),
                        Toggle::make('show_text')
                            ->label('Show headline on this slide')
                            ->default(true)
                            ->helperText('Turn off for posters and banners that already contain their own text. The banner is then shown in full (not cropped) with only its button, if set.'),
                        TextInput::make('sort_order')
                            ->label('Position')
                            ->numeric()
                            ->minValue(1)
                            ->placeholder('Last')
                            ->helperText('1 = first slide, 2 = second … Leave empty to add at the end. The other slides move to make room.'),
                        TextInput::make('duration_seconds')
                            ->label('Show for')
                            ->numeric()
                            ->minValue(2)
                            ->maxValue(120)
                            ->suffix('seconds')
                            ->placeholder(fn (Get $get) => $get('media_type') === 'video' ? (string) HeroSlide::DEFAULT_VIDEO_SECONDS : (string) HeroSlide::DEFAULT_PHOTO_SECONDS)
                            ->helperText(fn (Get $get) => 'How long this slide stays before the next one. Empty = '.($get('media_type') === 'video' ? HeroSlide::DEFAULT_VIDEO_SECONDS : HeroSlide::DEFAULT_PHOTO_SECONDS).' seconds.'),
                        TextInput::make('button_url')
                            ->label('Button link')
                            ->placeholder('admission/apply')
                            ->helperText('A page on this site (e.g. "admission/apply", "about", "gallery") or a full web address.')
                            ->maxLength(255),
                    ]),
                Tabs::make('Text')
                    ->columnSpan(2)
                    ->tabs([
                        Tab::make('English')->schema([
                            TextInput::make('eyebrow_en')->label('Small label above the title')->placeholder('Now open in Lakshmipur')->maxLength(80),
                            Textarea::make('title_en')->label('Title')->rows(2)->maxLength(120)->helperText('Leave empty to show the main homepage text over this slide (recommended). Fill in only for a special slide, e.g. an event.'),
                            Textarea::make('text_en')->label('Short text')->rows(2)->maxLength(300),
                            TextInput::make('button_label_en')->label('Button text')->placeholder('Apply now')->maxLength(40),
                        ]),
                        Tab::make('বাংলা (Bangla)')->schema([
                            TextInput::make('eyebrow_bn')->label('Small label (Bangla)')->maxLength(80),
                            Textarea::make('title_bn')->label('Title (Bangla)')->rows(2)->maxLength(120),
                            Textarea::make('text_bn')->label('Short text (Bangla)')->rows(2)->maxLength(300),
                            TextInput::make('button_label_bn')->label('Button text (Bangla)')->maxLength(40),
                        ]),
                    ]),
            ]);
    }
}
