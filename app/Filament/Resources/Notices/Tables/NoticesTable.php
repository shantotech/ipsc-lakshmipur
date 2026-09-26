<?php

namespace App\Filament\Resources\Notices\Tables;

use App\Models\Notice;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class NoticesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('published_on', 'desc')
            ->columns([
                TextColumn::make('title_en')
                    ->label('Title')
                    ->icon(fn (Notice $record) => $record->is_pinned ? Heroicon::Star : null)
                    ->iconColor('warning')
                    ->tooltip(fn (Notice $record) => $record->is_pinned ? 'Pinned to top' : null)
                    ->description(fn (Notice $record) => $record->title_bn)
                    ->searchable(['title_en', 'title_bn'])
                    ->wrap(),
                TextColumn::make('category')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => Notice::CATEGORIES[$state] ?? $state)
                    ->color(fn (string $state) => match ($state) {
                        'admission' => 'success',
                        'recruitment' => 'info',
                        'exam' => 'warning',
                        'holiday' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('published_on')
                    ->label('Date')
                    ->date('d M Y')
                    ->sortable(),
                IconColumn::make('attachment')
                    ->label('File')
                    ->icon(fn ($state) => $state ? Heroicon::PaperClip : null)
                    ->color('gray'),
                ToggleColumn::make('is_published')
                    ->label('On website'),
                TextColumn::make('updated_at')
                    ->label('Last changed')
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->options(Notice::CATEGORIES),
                TrashedFilter::make(),
            ])
            ->recordActions([
                Action::make('view')
                    ->label('View')
                    ->icon(Heroicon::OutlinedArrowTopRightOnSquare)
                    ->color('gray')
                    ->url(fn (Notice $record) => route('notices.show', ['locale' => 'en', 'slug' => $record->slug]))
                    ->openUrlInNewTab()
                    ->visible(fn (Notice $record) => $record->is_published && ! $record->trashed()),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('No notices yet')
            ->emptyStateDescription('Create the first notice and it will appear on the website.');
    }
}
