<?php

namespace App\Filament\Resources\Galleries\Schemas;

use Filament\Forms;
use Filament\Schemas\Schema;

class GalleryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            Forms\Components\TextInput::make('title')
                ->label('Title')
                ->maxLength(255),

            Forms\Components\FileUpload::make('image')
                ->label('Gallery Image')
                ->image()
                ->required()
                ->directory('gallery')
                ->disk('r2') // your Cloudflare R2 disk
                ->visibility('public'),

            Forms\Components\TextInput::make('category')
                ->label('Category')
                ->placeholder('Interior / Exterior'),

            Forms\Components\TextInput::make('sort_order')
                ->numeric()
                ->default(0),

            Forms\Components\Toggle::make('status')
                ->default(true),

        ]);
    }
}