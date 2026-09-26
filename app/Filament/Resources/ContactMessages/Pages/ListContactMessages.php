<?php

namespace App\Filament\Resources\ContactMessages\Pages;

use App\Filament\Resources\ContactMessages\ContactMessageResource;
use App\Models\ContactMessage;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListContactMessages extends ListRecords
{
    protected static string $resource = ContactMessageResource::class;

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All'),
            'unread' => Tab::make('Unread')
                ->badge(ContactMessage::whereNull('read_at')->count() ?: null)
                ->modifyQueryUsing(fn (Builder $query) => $query->whereNull('read_at')),
        ];
    }
}
