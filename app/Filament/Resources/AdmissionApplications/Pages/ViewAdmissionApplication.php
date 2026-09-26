<?php

namespace App\Filament\Resources\AdmissionApplications\Pages;

use App\Filament\Resources\AdmissionApplications\AdmissionApplicationResource;
use App\Models\AdmissionApplication;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\RestoreAction;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Icons\Heroicon;

class ViewAdmissionApplication extends ViewRecord
{
    protected static string $resource = AdmissionApplicationResource::class;

    public function getTitle(): string
    {
        return $this->getRecord()->student_name;
    }

    protected function getHeaderActions(): array
    {
        return [
            $this->statusAction('contacted', 'Mark contacted', Heroicon::OutlinedPhone, 'info'),
            $this->statusAction('approved', 'Approve', Heroicon::OutlinedCheckCircle, 'success'),
            $this->statusAction('rejected', 'Reject', Heroicon::OutlinedXCircle, 'danger'),
            Action::make('note')
                ->label('Add note')
                ->icon(Heroicon::OutlinedPencilSquare)
                ->color('gray')
                ->schema([
                    Textarea::make('note')->label('Note')->required()->rows(3),
                ])
                ->action(function (array $data) {
                    $record = $this->getRecord();
                    $stamp = now('Asia/Dhaka')->format('d M Y, h:i A').' — '.auth()->user()->name;
                    $record->update(['notes' => trim(($record->notes ? $record->notes."\n\n" : '').$stamp.":\n".$data['note'])]);
                    Notification::make()->title('Note added')->success()->send();
                }),
            ActionGroup::make([
                EditAction::make(),
                DeleteAction::make(),
                RestoreAction::make(),
            ]),
        ];
    }

    private function statusAction(string $status, string $label, Heroicon $icon, string $color): Action
    {
        return Action::make('status_'.$status)
            ->label($label)
            ->icon($icon)
            ->color($color)
            ->visible(fn () => $this->getRecord()->status !== $status && ! $this->getRecord()->trashed())
            ->action(function () use ($status) {
                $this->getRecord()->update(['status' => $status]);
                Notification::make()
                    ->title('Status changed to '.AdmissionApplication::STATUSES[$status])
                    ->success()
                    ->send();
            });
    }
}
