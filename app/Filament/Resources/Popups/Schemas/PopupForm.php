<?php

namespace App\Filament\Resources\Popups\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class PopupForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Tabs::make('Text')
                    ->columnSpan(2)
                    ->tabs([
                        Tab::make('English')->schema([
                            TextInput::make('title_en')->label('Title')->placeholder('Parenting Conference 2026')->required()->maxLength(120),
                            Textarea::make('body_en')->label('Text')->rows(5)->maxLength(1000)
                                ->helperText('Keep it short: what, when, where. Line breaks are kept.'),
                            TextInput::make('button_label_en')->label('Button text')->placeholder('Book now')->maxLength(40),
                        ]),
                        Tab::make('বাংলা (Bangla)')->schema([
                            TextInput::make('title_bn')->label('Title (Bangla)')->maxLength(120),
                            Textarea::make('body_bn')->label('Text (Bangla)')->rows(5)->maxLength(1000),
                            TextInput::make('button_label_bn')->label('Button text (Bangla)')->maxLength(40),
                        ]),
                    ]),
                Section::make('When to show')
                    ->columnSpan(1)
                    ->schema([
                        Toggle::make('is_active')->label('Turned on')->default(true),
                        DateTimePicker::make('starts_at')->label('Start showing')->native(false)->seconds(false)
                            ->timezone('Asia/Dhaka')->displayFormat('d M Y, h:i A')->helperText('Empty = from now.'),
                        DateTimePicker::make('ends_at')->label('Stop showing')->native(false)->seconds(false)
                            ->timezone('Asia/Dhaka')->displayFormat('d M Y, h:i A')->helperText('Empty = until turned off.')
                            ->after('starts_at'),
                        TextInput::make('button_url')->label('Button link')->placeholder('notices')
                            ->helperText('A page on this site (e.g. "notices", "admission/apply") or a full web address.')->maxLength(255),
                    ]),
                Section::make('Image')
                    ->columnSpan(2)
                    ->schema([
                        FileUpload::make('image')
                            ->hiddenLabel()
                            ->image()
                            ->disk('public')
                            ->directory('popups')
                            ->imageResizeMode('contain')
                            ->imageResizeTargetWidth('1200')
                            ->imageResizeTargetHeight('1200')
                            ->imageResizeUpscale(false)
                            ->maxSize(10240)
                            ->helperText('Optional. A banner or poster for the event. Wide images look best.'),
                    ]),
            ]);
    }
}
