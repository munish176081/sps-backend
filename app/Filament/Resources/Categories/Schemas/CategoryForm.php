<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            /*
            |--------------------------------------------------------------------------
            | Basic Info
            |--------------------------------------------------------------------------
            */
            TextInput::make('name')
                ->required()
                ->live()
                ->afterStateUpdated(
                    fn($state, $set) =>
                    $set('slug', \Illuminate\Support\Str::slug($state))
                ),

            TextInput::make('slug')
                ->required()
                ->unique(ignoreRecord: true),

            Select::make('parent_id')
                ->label('Parent Category')
                ->relationship('parent', 'name')
                ->searchable()
                ->preload()
                ->nullable(),

            Toggle::make('status')
                ->default(true),

            /*
            |--------------------------------------------------------------------------
            | Hero Section
            |--------------------------------------------------------------------------
            */
            FileUpload::make('banner_image')
                ->label('Banner Image')
                ->image()
                ->disk('public')
                ->directory('categories'),

            /*
            |--------------------------------------------------------------------------
            | Gallery Section
            |--------------------------------------------------------------------------
            */
            FileUpload::make('gallery')
                ->label('Gallery')
                ->image()
                ->disk('public')
                ->multiple()
                ->reorderable()
                ->imagePreviewHeight('100')
                ->panelLayout('grid')
                ->directory('categories/gallery'),

            TextInput::make('title')
                ->label('Page Title'),

            Textarea::make('subtitle')
                ->label('Subtitle'),

            /*
            |--------------------------------------------------------------------------
            | Overview Section
            |--------------------------------------------------------------------------
            */
            RichEditor::make('overview')
                ->label('Overview Content')
                ->columnSpanFull(),

            /*
            |--------------------------------------------------------------------------
            | Specifications Section
            |--------------------------------------------------------------------------
            */
            Repeater::make('specs')
                ->label('Specifications')
                ->schema([
                    TextInput::make('title')
                        ->required(),

                    Textarea::make('content')
                        ->required(),
                ])
                ->columnSpanFull()
                ->collapsible()
                ->addActionLabel('Add Specification'),

            /*
            |--------------------------------------------------------------------------
            | Collections Section
            |--------------------------------------------------------------------------
            */
            TextInput::make('collections_title')
                ->label('Collections Title'),

            Textarea::make('collections_description')
                ->label('Collections Description'),

            /*
            |--------------------------------------------------------------------------
            | FAQ Section
            |--------------------------------------------------------------------------
            */
            Repeater::make('faqs')
                ->label('FAQs')
                ->schema([
                    TextInput::make('question')
                        ->required()
                        ->label('Question'),

                    Textarea::make('answer')
                        ->required()
                        ->label('Answer'),
                ])
                ->columnSpanFull()
                ->collapsible()
                ->addActionLabel('Add FAQ'),

            /*
            |--------------------------------------------------------------------------
            | SEO Section
            |--------------------------------------------------------------------------
            */
            Section::make('SEO Settings')
                ->columnSpanFull()
                ->schema([
                    TextInput::make('meta_title')
                        ->label('Meta Title'),

                    Textarea::make('meta_description')
                        ->label('Meta Description'),
                ])
        ]);
    }
}
