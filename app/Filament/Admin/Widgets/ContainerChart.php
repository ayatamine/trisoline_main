<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Order;
use Filament\Forms\Components\DatePicker;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class ContainerChart extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static string $chartId = 'containerChart';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'ContainerChart';
    protected static ?int $sort = 5;

    protected function getFormSchema(): array
    {
        return [

            DatePicker::make('date_start')
                ->default( now()->startOfYear()),
    
            DatePicker::make('date_end')
                ->default(now()->endOfYear())
    
        ];
    }
    protected function getOptions(): array
    {
        $dateStart = $this->filterFormData['date_start'];
        $dateEnd = $this->filterFormData['date_end'];
        
        // $data = Trend::model(Order::class)
        // ->query(  
        //     Order::query()
        //     ->status("completed")
        // )
        // ->between(
        //     start: Carbon::createFromDate($dateStart) ?? now()->startOfYear(),
        //     end: Carbon::createFromDate($dateEnd)?? now()->endOfYear(),
        // )
        // ->perMonth();
        $pending_containers = Order::whereIn('status', [ "pending"])->whereBetween('created_at',[$dateStart,$dateEnd])->pluck('containers');
        $approved_containers = Order::whereIn('status', [ "approved","inspected"])->whereBetween('created_at',[$dateStart,$dateEnd])->pluck('containers');

        // Get the containers for completed orders
        $completed_containers = Order::where('status', 'completed')->whereBetween('created_at',[$dateStart,$dateEnd])->pluck('containers');

       
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
        $approvedtotalCount=0;
        foreach ($approved_containers as $container) {
            // Assuming each $container is a string representation of an array, decode it
            
            foreach($container as $con)
            {
                if (is_array($con) && isset($con['count'])) {
                    $approvedtotalCount += (int)$con['count'];
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
            'chart' => [
                'type' => 'donut',
                'height' => 300,
            ],
            'series' => [$pendingtotalCount,$approvedtotalCount,$completedtotalCount],
            'labels' => ['pending','approved','completed'],
            'legend' => [
                'labels' => [
                    'fontFamily' => 'inherit',
                ],
            ],
        ];
    }
}
