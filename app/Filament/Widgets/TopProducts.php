<?php

namespace App\Filament\Widgets;

use App\Models\Lead;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Columns\TextColumn;


class TopProducts extends BaseWidget
{
    protected static ?string $heading = 'Top Products by Leads';

    protected static ?int $sort = 3;

    protected function getTableQuery(): Builder
    {
        // We select product_id as the 'id' so Filament doesn't get confused
        return Lead::query()
            ->selectRaw('product_id as id, product_id, COUNT(*) as total')
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('total');
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('product.title')
                ->label('Product')
                ->badge()
                ->color('success')
                ->placeholder('No Product Linked'),

            TextColumn::make('total')
                ->label('Leads')
                ->badge()
                ->color('primary'),
        ];
    }

    public function getTableRecordKey(Model|array $record): string
    {
        return (string) ($record instanceof Model ? $record->product_id : $record['product_id']);
    }
}
