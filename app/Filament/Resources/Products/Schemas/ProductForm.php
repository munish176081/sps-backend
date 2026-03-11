<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            Toggle::make('status')
                ->columnSpanFull()
                ->default(true),

            TextInput::make('title')
                ->required()
                ->live()
                ->afterStateUpdated(
                    fn($state, $set) =>
                    $set('slug', Str::slug($state))
                ),

            TextInput::make('slug')
                ->required()
                ->unique(ignoreRecord: true),

            Select::make('category_id')
                ->columnSpanFull()
                ->relationship('category', 'name')
                ->searchable()
                ->required(),

            RichEditor::make('description')
                ->columnSpanFull(),

            FileUpload::make('main_image')
                ->image()
                ->disk('public')
                ->directory('products'),

            FileUpload::make('gallery')
                ->multiple()
                ->image()
                ->disk('public')
                ->directory('products/gallery')
                ->reorderable()
                ->panelLayout('grid')
                ->label('Gallery Images'),

            Repeater::make('sizes')
                ->relationship()
                ->schema([
                    TextInput::make('section')
                        ->required(),

                    TextInput::make('value')
                        ->required(),
                ])
                ->columns(2),

            Repeater::make('faqs')
                ->relationship()
                ->schema([
                    TextInput::make('question')
                        ->required(),

                    Textarea::make('answer')
                        ->required(),
                ]),

            Section::make('SEO Settings')
                ->columnSpanFull()
                ->schema([

                    TextInput::make('meta_title')
                        ->label('Meta Title')
                        ->maxLength(60),

                    Textarea::make('meta_description')
                        ->label('Meta Description')
                        ->rows(3)
                        ->maxLength(160),

                    TextInput::make('meta_keywords')
                        ->label('Meta Keywords')
                        ->helperText('Comma separated keywords'),
                ])
                ->collapsed(),
        ]);
    }
}
