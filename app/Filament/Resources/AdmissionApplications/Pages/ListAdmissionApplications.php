<?php

namespace App\Filament\Resources\AdmissionApplications\Pages;

use App\Filament\Resources\AdmissionApplications\AdmissionApplicationResource;
use App\Models\AdmissionApplication;
use App\Support\CsvExport;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Builder;

class ListAdmissionApplications extends ListRecords
{
    protected static string $resource = AdmissionApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('export')
                ->label('Download for Excel')
                ->icon(Heroicon::OutlinedArrowDownTray)
                ->color('gray')
                ->tooltip('Downloads the applications currently shown (tab, filters and search apply).')
                ->action(fn () => CsvExport::download(
                    'admission-applications-'.now('Asia/Dhaka')->format('Y-m-d').'.csv',
                    $this->getFilteredSortedTableQuery()->get(),
                    [
                        'Reference' => fn ($r) => $r->reference,
                        'Received' => fn ($r) => $r->created_at->timezone('Asia/Dhaka')->format('Y-m-d H:i'),
                        'Status' => fn ($r) => AdmissionApplication::STATUSES[$r->status] ?? $r->status,
                        'Academic year' => fn ($r) => $r->academic_year,
                        'Class' => fn ($r) => AdmissionApplication::CLASSES[$r->class] ?? $r->class,
                        'Student name' => fn ($r) => $r->student_name,
                        'Date of birth' => fn ($r) => $r->date_of_birth->format('Y-m-d'),
                        'Gender' => fn ($r) => AdmissionApplication::GENDERS[$r->gender] ?? $r->gender,
                        'Previous school' => fn ($r) => $r->previous_school,
                        'Guardian name' => fn ($r) => $r->guardian_name,
                        'Mobile' => fn ($r) => $r->phone,
                        'Email' => fn ($r) => $r->email,
                        'Address' => fn ($r) => $r->address,
                        'Office notes' => fn ($r) => $r->notes,
                    ],
                )),
            CreateAction::make()->label('Add walk-in application'),
        ];
    }

    public function getTabs(): array
    {
        $count = fn (?string $status) => AdmissionApplication::query()
            ->when($status, fn (Builder $q) => $q->where('status', $status))
            ->count();

        $tabs = ['all' => Tab::make('All')->badge($count(null))];

        foreach (AdmissionApplication::STATUSES as $key => $label) {
            $tabs[$key] = Tab::make($label)
                ->badge($count($key))
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', $key));
        }

        return $tabs;
    }
}
