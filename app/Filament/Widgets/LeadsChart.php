<?php

namespace App\Filament\Widgets;

use App\Models\Lead;
use Filament\Widgets\ChartWidget;

class LeadsChart extends ChartWidget
{
    protected static ?int $sort = 2;
    
    protected ?string $heading = 'Leads Last 7 Days';

    protected function getData(): array
    {
        $data = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);

            $data[] = Lead::whereDate('created_at', $date)->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Leads',
                    'data' => $data,
                ],
            ],
            'labels' => [
                now()->subDays(6)->format('D'),
                now()->subDays(5)->format('D'),
                now()->subDays(4)->format('D'),
                now()->subDays(3)->format('D'),
                now()->subDays(2)->format('D'),
                now()->subDays(1)->format('D'),
                now()->format('D'),
            ],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
