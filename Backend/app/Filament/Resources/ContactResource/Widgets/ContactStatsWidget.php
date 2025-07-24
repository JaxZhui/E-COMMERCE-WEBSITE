<?php

namespace App\Filament\Widgets;

use App\Models\Contact;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ContactStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Unread Contacts', Contact::unread()->count())
                ->description('New messages')
                ->descriptionIcon('heroicon-m-envelope')
                ->color('warning'),
            Stat::make('Total Contacts', Contact::count())
                ->description('All time contacts')
                ->descriptionIcon('heroicon-m-envelope-open')
                ->color('success'),
            Stat::make('This Month', Contact::whereMonth('created_at', now()->month)->count())
                ->description('Contacts this month')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('info'),
        ];
    }
}
