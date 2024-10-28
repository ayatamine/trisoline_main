<?php

namespace App\Filament\Admin\Pages;

use App\Filament\Admin\Resources\OrderResource\Widgets\AdminOrdersChart;
use App\Filament\Admin\Widgets\AdminStateOverview;
use App\Filament\Widgets;
use Filament\Facades\Filament;
use Filament\Pages\Dashboard as BasePage;

class Dashboard extends BasePage
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.admin.pages.dashboard';
    public function getColumns(): int | string | array
    {
        return [
            'md' => 4,
            'xl' => 5,
        ];
    }
    // public function getWidgets(): array
    // {
    //     return [
    //       AdminStateOverview::class ,
    //       AdminOrdersChart::class  
    //     ];
    // }
}
