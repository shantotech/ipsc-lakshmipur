<?php

namespace App\Filament\Resources\GalleryAlbums\RelationManagers;

use App\Models\GalleryPhoto;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PhotosRelationManager extends RelationManager
{
    protected static string $relationship = 'photos';

    protected static ?string $title = 'Photos';

    /** Photos are resized in the browser before upload, so big phone photos stay light. */
    private static function imageUpload(string $name): FileUpload
    {
        return FileUpload::make($name)
            ->image()
            ->disk('public')
            ->directory('gallery')
            ->imageResizeMode('contain')
            ->imageResizeTargetWidth('1920')
            ->imageResizeTargetHeight('1920')
            ->imageResizeUpscale(false)
            ->maxSize(15360);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                self::imageUpload('image')
                    ->label('Photo')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('caption_en')
                    ->label('Caption (English)')
                    ->maxLength(255),
                TextInput::make('caption_bn')
                    ->label('Caption (Bangla)')
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->contentGrid(['md' => 3, 'xl' => 4])
            ->columns([
                Stack::make([
                    ImageColumn::make('image')
                        ->disk('public')
                        ->imageWidth('100%')
                        ->imageHeight(170)
                        ->extraImgAttributes(['class' => 'rounded-lg object-cover', 'loading' => 'lazy']),
                    TextColumn::make('caption_en')
                        ->placeholder('No caption')
                        ->color('gray')
                        ->size('sm'),
                ])->space(2),
            ])
            ->headerActions([
                Action::make('upload')
                    ->label('Upload photos')
                    ->icon(Heroicon::OutlinedArrowUpTray)
                    ->modalHeading('Upload photos')
                    ->modalDescription('Select or drag in several photos at once. Large photos are resized automatically.')
                    ->modalSubmitActionLabel('Add to album')
                    ->schema([
                        self::imageUpload('images')
                            ->hiddenLabel()
                            ->multiple()
                            ->maxFiles(50)
                            ->panelLayout('grid')
                            ->reorderable()
                            ->required(),
                    ])
                    ->action(function (array $data): void {
                        $album = $this->getOwnerRecord();
                        $next = (int) $album->photos()->max('sort_order');

                        foreach ($data['images'] as $path) {
                            $album->photos()->create(['image' => $path, 'sort_order' => ++$next]);
                        }

                        Notification::make()
                            ->title(count($data['images']).' photo(s) added')
                            ->success()
                            ->send();
                    }),
            ])
            ->recordActions([
                EditAction::make()->label('Caption'),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('No photos in this album yet')
            ->emptyStateDescription('Click "Upload photos" to add some.')
            ->paginated([12, 24, 48]);
    }
}
