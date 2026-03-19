<?php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Resources\Products\ProductResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function getBreadcrumbs(): array
    {
        $product = $this->record;

        $breadcrumbs = [
            route('filament.admin.pages.dashboard') => 'Dashboard',
            route('filament.admin.resources.products.index') => 'Products',
        ];

        if ($product->category?->parent) {
            $breadcrumbs[] = $product->category->parent->name;
        }

        if ($product->category) {
            $breadcrumbs[] = $product->category->name;
        }

        $breadcrumbs[] = $product->title;

        return $breadcrumbs;
    }
}
