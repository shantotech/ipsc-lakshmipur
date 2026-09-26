<?php

namespace App\Filament\Resources\ContactMessages\Schemas;

use App\Models\ContactMessage;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContactMessageInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make(fn (ContactMessage $record) => $record->subject)
                    ->columnSpan(2)
                    ->schema([
                        TextEntry::make('message')->hiddenLabel()->prose()
                            ->formatStateUsing(fn (string $state) => nl2br(e($state)))->html(),
                    ]),
                Section::make('From')
                    ->columnSpan(1)
                    ->schema([
                        TextEntry::make('name'),
                        TextEntry::make('phone')->label('Mobile')->copyable()
                            ->url(fn (ContactMessage $record) => 'tel:'.preg_replace('/[^0-9+]/', '', $record->phone)),
                        TextEntry::make('email')->placeholder('—')->copyable()
                            ->url(fn (ContactMessage $record) => $record->email ? 'mailto:'.$record->email : null),
                        TextEntry::make('created_at')->label('Received')->dateTime('d M Y, h:i A', 'Asia/Dhaka'),
                    ]),
                Section::make('Office notes')
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('notes')->hiddenLabel()->placeholder('No notes yet.')
                            ->formatStateUsing(fn (?string $state) => nl2br(e((string) $state)))->html(),
                    ]),
            ]);
    }
}
