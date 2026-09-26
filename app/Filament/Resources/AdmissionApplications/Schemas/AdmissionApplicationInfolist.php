<?php

namespace App\Filament\Resources\AdmissionApplications\Schemas;

use App\Models\AdmissionApplication;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AdmissionApplicationInfolist
{
    public static function statusColor(string $status): string
    {
        return match ($status) {
            'new' => 'warning',
            'contacted' => 'info',
            'approved' => 'success',
            'rejected' => 'danger',
            default => 'gray',
        };
    }

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make('Student')
                    ->columns(2)
                    ->columnSpan(2)
                    ->schema([
                        TextEntry::make('student_name')->label('Name')->weight('bold')->size('lg')->columnSpanFull(),
                        TextEntry::make('class')->label('Class applying for')
                            ->formatStateUsing(fn (string $state) => AdmissionApplication::CLASSES[$state] ?? $state)
                            ->badge(),
                        TextEntry::make('gender')->formatStateUsing(fn (string $state) => AdmissionApplication::GENDERS[$state] ?? $state),
                        TextEntry::make('date_of_birth')->date('d M Y')
                            ->helperText(fn (AdmissionApplication $record) => 'Age on 1 Jan '.$record->academic_year.': '.$record->ageOn($record->academic_year.'-01-01')),
                        TextEntry::make('previous_school')->placeholder('—'),
                    ]),
                Section::make('Application')
                    ->columnSpan(1)
                    ->schema([
                        TextEntry::make('reference')->copyable()->fontFamily('mono'),
                        TextEntry::make('status')->badge()
                            ->formatStateUsing(fn (string $state) => AdmissionApplication::STATUSES[$state] ?? $state)
                            ->color(fn (string $state) => self::statusColor($state)),
                        TextEntry::make('created_at')->label('Received')->dateTime('d M Y, h:i A', 'Asia/Dhaka'),
                        TextEntry::make('academic_year'),
                    ]),
                Section::make('Guardian')
                    ->columns(2)
                    ->columnSpan(2)
                    ->schema([
                        TextEntry::make('guardian_name')->label('Name'),
                        TextEntry::make('phone')->label('Mobile')->copyable()
                            ->url(fn (AdmissionApplication $record) => 'tel:'.preg_replace('/[^0-9+]/', '', $record->phone)),
                        TextEntry::make('email')->placeholder('—')->copyable(),
                        TextEntry::make('address')->columnSpanFull(),
                    ]),
                Section::make('Office notes')
                    ->columnSpan(1)
                    ->schema([
                        TextEntry::make('notes')->hiddenLabel()->placeholder('No notes yet.')
                            ->formatStateUsing(fn (?string $state) => nl2br(e((string) $state)))->html(),
                    ]),
            ]);
    }
}
