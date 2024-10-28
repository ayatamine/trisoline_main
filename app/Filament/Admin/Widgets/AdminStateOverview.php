<?php

namespace App\Filament\Admin\Widgets;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Quota;
use App\Models\Client;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class AdminStateOverview extends BaseWidget
{
    protected static ?string $pollingInterval = '15s';


    protected function getStats(): array
    {
        $orders_count = Order::whereStatus('approved')->count();
        $orders_array  =Order::whereBetween('created_at', [now()->subDays(30),now()])
        ->orderBy('created_at')
        ->get()
        ->groupBy(function ($val) {
            return Carbon::parse($val->created_at)->format('d');
        });
        $orders_chart =[];
        foreach ($orders_array as $key => $value) {
            array_push($orders_chart,count($value));
        }
        /////////////////////////
        $quota_count = Order::whereStatus('approved')->count();
        $quota_array  =Quota::whereBetween('created_at', [now()->subDays(30),now()])
        ->orderBy('created_at')
        ->get()
        ->groupBy(function ($val) {
            return Carbon::parse($val->created_at)->format('d');
        });
        $quotas_chart =[];
        foreach ($quota_array as $key => $value) {
            array_push($quotas_chart,count($value));
        }
        $pending_containers = Order::whereIn('status', ["approved", "inspected"])->pluck('containers');

        // Get the containers for completed orders
        $completed_containers = Order::where('status', 'completed')->pluck('containers');

       
        // Initialize counts
        $pending_count = 0;
  
        $pendingtotalCount=0;
        foreach ($pending_containers as $container) {
            // Assuming each $container is a string representation of an array, decode it
            
            foreach($container as $con)
            {
                if (is_array($con) && isset($con['count'])) {
                    $pendingtotalCount += (int)$con['count'];
                }
            }
        }

        $completedtotalCount=0;
        foreach ($completed_containers as $container) {
            
            if (is_array($container) && isset($container['count'])) {
                $completedtotalCount += (int)$container['count'];
            }
        }



        return [
            Stat::make('Total Clients', Client::count())
            ->description('32k increase')
            ->color('success')
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->extraAttributes([
                'class' => 'cursor-pointer',
                'wire:click' => "\$dispatch('setStatusFilter', { filter: 'processed' })",
            ]),
            // ...
            Stat::make('Total Quotations', Quota::count())
            ->description("Processing now: ".$quota_count." ".trans_choice('dash.quota',$quota_count))
            ->chart($quotas_chart)
            ->url(route('filament.admin.resources.quotas.index'))
            ->color('info'),
            Stat::make('Total Orders', Order::count())
            ->description("Processing now: ".$orders_count." ".trans_choice('dash.order',$orders_count))
            ->color('warning')
            ->url(route('filament.admin.resources.orders.index'))
            ->chart($orders_chart),
            Stat::make('Total Processed Orders Containers', $completedtotalCount)
            ->description("Processing now: ".$pendingtotalCount." ".trans('dash.container'))
            ->url(route('filament.admin.resources.orders.index'))
            ->color('info'),
        ];
    }
}
