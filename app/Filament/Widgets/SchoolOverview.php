<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\AdmissionApplications\AdmissionApplicationResource;
use App\Filament\Resources\ContactMessages\ContactMessageResource;
use App\Filament\Resources\Notices\NoticeResource;
use App\Models\AdmissionApplication;
use App\Models\ContactMessage;
use App\Models\Notice;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

/** Dashboard summary: what needs attention today. */
class SchoolOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $newApplications = AdmissionApplication::where('status', 'new')->count();
        $unread = ContactMessage::whereNull('read_at')->count();

        return [
            Stat::make('New applications', $newApplications)
                ->description(trans_choice(':count received in total', AdmissionApplication::count()))
                ->icon(Heroicon::OutlinedAcademicCap)
                ->color($newApplications > 0 ? 'warning' : 'gray')
                ->url(AdmissionApplicationResource::getUrl('index', ['activeTab' => 'new'])),
            Stat::make('Unread messages', $unread)
                ->description(trans_choice('{1} :count message in total|[0,*] :count messages in total', ContactMessage::count()))
                ->icon(Heroicon::OutlinedEnvelope)
                ->color($unread > 0 ? 'warning' : 'gray')
                ->url(ContactMessageResource::getUrl('index', ['activeTab' => 'unread'])),
            Stat::make('Notices on website', Notice::visible()->count())
                ->description('Add or edit notices')
                ->icon(Heroicon::OutlinedMegaphone)
                ->url(NoticeResource::getUrl('index')),
        ];
    }
}
