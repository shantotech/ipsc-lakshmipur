<?php

namespace App\Filament\Resources\Notices\Schemas;

use App\Models\Notice;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class NoticeForm
{
    /** Formatting options shown in the notice text editor. */
    private const TOOLBAR = [
        ['bold', 'italic', 'underline', 'link'],
        ['h2', 'h3'],
        ['bulletList', 'orderedList'],
        ['undo', 'redo'],
    ];

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Tabs::make('Language')
                    ->columnSpan(2)
                    ->tabs([
                        Tab::make('English')
                            ->schema([
                                TextInput::make('title_en')
                                    ->label('Title')
                                    ->required()
                                    ->maxLength(255),
                                Textarea::make('excerpt_en')
                                    ->label('Short summary')
                                    ->helperText('Shown in notice lists. Leave empty to use the start of the notice text.')
                                    ->rows(2)
                                    ->maxLength(500),
                                RichEditor::make('body_en')
                                    ->label('Notice text')
                                    ->toolbarButtons(self::TOOLBAR),
                            ]),
                        Tab::make('বাংলা (Bangla)')
                            ->schema([
                                TextInput::make('title_bn')
                                    ->label('Title (Bangla)')
                                    ->helperText('Optional. If empty, the English title is shown on the Bangla site.')
                                    ->maxLength(255),
                                Textarea::make('excerpt_bn')
                                    ->label('Short summary (Bangla)')
                                    ->rows(2)
                                    ->maxLength(500),
                                RichEditor::make('body_bn')
                                    ->label('Notice text (Bangla)')
                                    ->toolbarButtons(self::TOOLBAR),
                            ]),
                    ]),

                Grid::make(1)
                    ->columnSpan(1)
                    ->schema([
                        Section::make('Publishing')
                            ->schema([
                                Select::make('category')
                                    ->options(Notice::CATEGORIES)
                                    ->default('general')
                                    ->required()
                                    ->native(false),
                                DatePicker::make('published_on')
                                    ->label('Notice date')
                                    ->default(now('Asia/Dhaka'))
                                    ->helperText('A future date schedules the notice; it appears on that day.')
                                    ->required()
                                    ->native(false)
                                    ->displayFormat('d M Y'),
                                Toggle::make('is_published')
                                    ->label('Show on website')
                                    ->default(true),
                                Toggle::make('is_pinned')
                                    ->label('Pin to top')
                                    ->helperText('Pinned notices stay first in every list.'),
                            ]),
                        Section::make('Attachment')
                            ->schema([
                                FileUpload::make('attachment')
                                    ->hiddenLabel()
                                    ->disk('public')
                                    ->directory('notices')
                                    ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png', 'image/webp'])
                                    ->maxSize(10240)
                                    ->openable()
                                    ->downloadable()
                                    ->helperText('PDF or image, up to 10 MB.'),
                            ]),
                    ]),
            ]);
    }
}
