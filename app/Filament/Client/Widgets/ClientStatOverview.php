<?php

namespace App\Filament\Client\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ClientStatOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $total_products = 0;
        if(auth()->user()->client->quotations)
        {
            foreach (auth()->user()->client->quotations as $quot) {
                $total_products+= count($quot->products   ?? []) ;
            }
            foreach (auth()->user()->client->orders as $ord) {
                $total_products+= count($ord->products   ?? []) ;
            }
        }
        return [
            Stat::make('Total Products', count(auth()->user()->client->quotations)),
            Stat::make('Quotations', count(auth()->user()->client->quotations)),
            Stat::make('Orders', count(auth()->user()->client->orders)),
            Stat::make('payments', count(auth()->user()->client->orders)),
        ];
    }
}
