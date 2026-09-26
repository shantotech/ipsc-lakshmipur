<?php

namespace App\Filament\Resources\ContactMessages\Pages;

use App\Filament\Resources\ContactMessages\ContactMessageResource;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Icons\Heroicon;

class ViewContactMessage extends ViewRecord
{
    protected static string $resource = ContactMessageResource::class;

    public function mount(int|string $record): void
    {
        parent::mount($record);

        // Opening a message marks it as read.
        if (! $this->getRecord()->read_at) {
            $this->getRecord()->update(['read_at' => now()]);
        }
    }

    public function getTitle(): string
    {
        return 'Message from '.$this->getRecord()->name;
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('note')
                ->label('Add note')
                ->icon(Heroicon::OutlinedPencilSquare)
                ->color('gray')
                ->schema([
                    Textarea::make('note')->label('Note')->helperText('For example: "Called back, will visit Sunday".')->required()->rows(3),
                ])
                ->action(function (array $data) {
                    $record = $this->getRecord();
                    $stamp = now('Asia/Dhaka')->format('d M Y, h:i A').' — '.auth()->user()->name;
                    $record->update(['notes' => trim(($record->notes ? $record->notes."\n\n" : '').$stamp.":\n".$data['note'])]);
                    Notification::make()->title('Note added')->success()->send();
                }),
            Action::make('unread')
                ->label('Mark unread')
                ->icon(Heroicon::OutlinedEnvelope)
                ->color('gray')
                ->action(function () {
                    $this->getRecord()->update(['read_at' => null]);
                    $this->redirect(ContactMessageResource::getUrl('index'));
                }),
            ActionGroup::make([
                DeleteAction::make(),
                RestoreAction::make(),
            ]),
        ];
    }
}
