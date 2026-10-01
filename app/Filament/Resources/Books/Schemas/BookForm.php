<?php

namespace App\Filament\Resources\Books\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class BookForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('price')
                    ->required()
                    ->integer()
                    ->prefix('$'),
                Select::make('author_id')
                    ->relationship('authors', 'name')
                    ->required()
                    ->multiple(true)
                    ->createOptionForm([
                        TextInput::make('name')
                            ->required(),
                    ]),
                FileUpload::make('image')
                    ->image()
                    ->required(),
                Toggle::make('is_published')
                    ->default(true)
                    ->required(),
            ]);
    }
}
