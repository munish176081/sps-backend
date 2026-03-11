<?php

namespace App\Filament\Widgets;

use App\Models\Lead;
use App\Models\Product;
use App\Models\Category;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    
    protected int|string|array $columnSpan = 'full';

    protected function getStats(): array
    {
        return [

            Stat::make('Total Leads', Lead::count())
                ->description('All leads received')
                ->color('success'),

            Stat::make('Leads Today', Lead::whereDate('created_at', today())->count())
                ->description('Leads today')
                ->color('warning'),

            Stat::make('Products', Product::count())
                ->description('Total products')
                ->color('primary'),

            Stat::make('Categories', Category::count())
                ->description('Total categories')
                ->color('info'),

        ];
    }
}