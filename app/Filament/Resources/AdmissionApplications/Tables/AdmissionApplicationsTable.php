<?php

namespace App\Filament\Resources\AdmissionApplications\Tables;

use App\Filament\Resources\AdmissionApplications\Schemas\AdmissionApplicationInfolist;
use App\Models\AdmissionApplication;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

class AdmissionApplicationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->recordUrl(fn (AdmissionApplication $record) => route('filament.admin.resources.admission-applications.view', $record))
            ->columns([
                TextColumn::make('reference')
                    ->fontFamily('mono')
                    ->size('sm')
                    ->color('gray')
                    ->searchable(),
                TextColumn::make('student_name')
                    ->label('Student')
                    ->weight('medium')
                    ->description(fn (AdmissionApplication $record) => 'Guardian: '.$record->guardian_name)
                    ->searchable(['student_name', 'guardian_name']),
                TextColumn::make('class')
                    ->badge()
                    ->color('gray')
                    ->formatStateUsing(fn (string $state) => AdmissionApplication::CLASSES[$state] ?? $state),
                TextColumn::make('phone')
                    ->label('Mobile')
                    ->copyable()
                    ->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => AdmissionApplication::STATUSES[$state] ?? $state)
                    ->color(fn (string $state) => AdmissionApplicationInfolist::statusColor($state)),
                TextColumn::make('created_at')
                    ->label('Received')
                    ->since('Asia/Dhaka')
                    ->dateTimeTooltip('d M Y, h:i A', 'Asia/Dhaka')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('class')->options(AdmissionApplication::CLASSES),
                SelectFilter::make('academic_year')
                    ->label('Academic year')
                    ->options(fn () => AdmissionApplication::query()->distinct()->orderByDesc('academic_year')->pluck('academic_year', 'academic_year')->all()),
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make()->label('Open'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('setStatus')
                        ->label('Change status')
                        ->icon(Heroicon::OutlinedCheckCircle)
                        ->schema([
                            Select::make('status')->options(AdmissionApplication::STATUSES)->required()->native(false),
                        ])
                        ->action(fn (Collection $records, array $data) => $records->each->update(['status' => $data['status']]))
                        ->deselectRecordsAfterCompletion(),
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->emptyStateIcon(Heroicon::OutlinedAcademicCap)
            ->emptyStateHeading('No applications here')
            ->emptyStateDescription('Applications sent from the website\'s "Apply Online" form appear here.');
    }
}
