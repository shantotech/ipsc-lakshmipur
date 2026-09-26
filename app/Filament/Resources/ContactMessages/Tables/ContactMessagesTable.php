<?php

namespace App\Filament\Resources\ContactMessages\Tables;

use App\Models\ContactMessage;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class ContactMessagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->recordUrl(fn (ContactMessage $record) => route('filament.admin.resources.contact-messages.view', $record))
            ->columns([
                TextColumn::make('name')
                    ->label('From')
                    ->weight(fn (ContactMessage $record) => $record->isRead() ? null : 'bold')
                    ->icon(fn (ContactMessage $record) => $record->isRead() ? null : Heroicon::Envelope)
                    ->iconColor('warning')
                    ->description(fn (ContactMessage $record) => $record->phone)
                    ->searchable(['name', 'phone', 'email']),
                TextColumn::make('subject')
                    ->weight(fn (ContactMessage $record) => $record->isRead() ? null : 'bold')
                    ->description(fn (ContactMessage $record) => Str::limit($record->message, 90))
                    ->wrap()
                    ->searchable(['subject', 'message']),
                TextColumn::make('created_at')
                    ->label('Received')
                    ->since('Asia/Dhaka')
                    ->dateTimeTooltip('d M Y, h:i A', 'Asia/Dhaka')
                    ->sortable(),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make()->label('Open'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('markRead')
                        ->label('Mark as read')
                        ->icon(Heroicon::OutlinedEnvelopeOpen)
                        ->action(fn (Collection $records) => $records->each->update(['read_at' => now()]))
                        ->deselectRecordsAfterCompletion(),
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->emptyStateIcon(Heroicon::OutlinedEnvelope)
            ->emptyStateHeading('No messages')
            ->emptyStateDescription('Messages sent from the website\'s Contact page appear here.');
    }
}
