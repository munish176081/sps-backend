<?php

namespace App\Filament\Widgets;

use App\Models\Lead;
use Filament\Tables;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\TextColumn;


class LatestLeads extends TableWidget
{
    protected static ?string $heading = 'Latest Leads';

    protected static ?int $sort = 4;

    protected int|string|array $columnSpan = 'full';

    protected function getTableQuery(): Builder
    {
        return Lead::query()->with('product')->latest()->limit(5);
    }

    protected function getTableColumns(): array
    {
        return [

            TextColumn::make('name')
                ->searchable(),

            TextColumn::make('phone'),

            TextColumn::make('product.title')
                ->label('Product')
                ->searchable()
                ->badge()
                ->color('success'),

            TextColumn::make('created_at')
                ->label('Submitted')
                ->since(),
        ];
    }
}
